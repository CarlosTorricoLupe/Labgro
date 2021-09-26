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
        $productions=Production::indexProductsByProduction($id);
          return response()->json([
            'success' => true,
            'productions'=> $productions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $response = array();
        $production = Production::find($id);
        $materials = Material_product::getDetailMaterial($request->product_id)->toArray();
        dd($materials);
        if ($production) {
            if( $this->verifyStockMaterial($materials,$request->quantity) ){
            $production->products()->attach($request->product_id, ['quantity' => $request->quantity]);
            $response['sucess'] = true;
            $response['message'] = "Producto agregado a la produccion correctamente";
            }
        } else {
            $response['sucess'] = false;
            $response['error'] = "No tiene una produccion registrada";
        }
        return response()->json($response, 201);
    }


    public function verifyStockMaterial($materials,$quantity){

        $is_permit = true;

        foreach ($materials as $material){
            $mat = Material::find($material['id']);

            $stock_material = $mat->stock_start;
            $quantity_order = $material['quantity'];

            if( ($quantity_order*$quantity) < $stock_material ){
                    $is_permit = false;
            }
        }
        return $is_permit;
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
    public function destroy($id)
    {
        //
    }
}
