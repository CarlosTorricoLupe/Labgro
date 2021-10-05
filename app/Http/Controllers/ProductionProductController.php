<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Material_product;
use App\Models\Production;
use App\Models\Production_product;
use Illuminate\Http\Request;

class ProductionProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        /* $productions = Production::indexProductsByProduction($id); */
        $productions=Production::with('products:id,name')->get(['id','date_production']);
        return response()->json([
            'sucess'=>true,
            'productions'=>$productions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $response = array();
        $production = Production::find($id);
        $materials = Material_product::getDetailMaterial($request->product_id)->toArray();
        if ($this->verifyIsPermit($materials, $request->quantity)) {
            if ($production) {
                $production->products()->attach($request->product_id, ['quantity' => $request->quantity]);
                $pr=Production_product::where('product_id',$request->product_id)->where('production_id',$id)->get();
                $this->decrementStock($materials,$request->quantity,$pr);
                $response['sucess'] = true;
                $response['message'] = "Producto agregado a la produccion correctamente";
            } else {
                $response['sucess'] = false;
                $response['error'] = "No tiene una produccion registrada";
            }
        }else{
            $response['sucess'] = false;
            $response['error'] = "No tiene stock suficiente";
        }
        return response()->json($response, 201);
    }


    public function verifyIsPermit($materials, $quantity)
    {
        $is_permit = true;
        foreach ($materials as $material) {
            $mat = Material::find($material['id']);
            $stock_material = $mat->stock_start;
            $quantity_order = $material['quantity'];
            if (($quantity_order * $quantity) > $stock_material) {
                $is_permit = false;
            }
        }
        return $is_permit;
    }

    public function decrementStock($materials,$quantity,$pr)
    {
        foreach ($materials as $material) {
            $mat = Material::find($material['id']);
            if($mat) {

                $quantity_req=$material['quantity']*$quantity;
                $control = $mat->stock_start - $quantity_req;
                $mat->stock_start = $control;
                $mat->save();
                $pr[0]->materiales()->attach($mat->id, ['quantity_required' => $quantity_req, 'control' => $control]);
            }
        }
    }

    public function verifyStockMaterial(Request $request)
    {
        $materials = Material_product::getDetailMaterial($request->product_id)->toArray();
        $quantity = $request->quantity;

        foreach ($materials as $material) {
            $is_permit = true;
            $mat = Material::find($material['id']);
            $stock_material = $mat->stock_start;
            $quantity_order = $material['quantity'];
            if (($quantity_order * $quantity) > $stock_material) {
                $is_permit = false;
            }
            $result[] = [
                'material_id' => $material['id'],
                'nombre' => $material['name_article'],
                'stock_almacen' => $stock_material.' '. $material['unit_measure'],
                'stock_requerid' => $quantity_order*$quantity.' '.$material['unit_measure'],
                'is_permit' => $is_permit
            ];
        }
    return $result;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($production_id,$product_id)
    {
        Production_product::where('production_id', $production_id)
        ->where('product_id',$product_id)
        ->delete();
        return response()->json([
            'sucess' => true,
            'message' => 'Se elimino correctamente'
        ],200);
    }
}
