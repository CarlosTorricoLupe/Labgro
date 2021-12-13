<?php

namespace App\Http\Controllers;

use App\Models\Presentation_production_product;
use App\Models\Production;
use App\Models\Production_product;
use Illuminate\Http\Request;

class PresentationProductionProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$production_id,$product_id)
    {
        $production= Production::find($production_id);
        $response=array();
        $productionProduct=Production_product::where('production_id',$production_id)
                            ->where('product_id',$product_id)
                            ->first();
        if (!$productionProduct->presentations->contains($request->presentation_id)) {
            $productionProduct->presentations()
                ->attach($request->presentation_id,[
                    'quantity'=>$request->quantity,
                    'unit_cost_production'=>$request->unit_cost_production,
                    'unit_price_sale'=>$request->unit_price_sale,
                    'role_id'=>$production->role_id
                ]);
            $response['sucess'] = true;
            $response['message'] = "Presentación agregada correctamente";
            $status=201;
        }else{
            $response['sucess'] = false;
            $response['message'] = "La unidad de presentacion ya esta asignada al producto";
            $status=400;
        }
        return response()->json($response, $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presentation_production_product  $presentation_production_product
     * @return \Illuminate\Http\Response
     */
    public function show(Presentation_production_product $presentation_production_product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presentation_production_product  $presentation_production_product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $production_id,$product_id,$presentation_unit_id)
    {
        $response=array();
        $productionProduct=Production_product::where('production_id',$production_id)
                            ->where('product_id',$product_id)
                            ->first()->id;
        $presentationProduct=Presentation_production_product::where('presentation_unit_id',$presentation_unit_id)
                            ->where('production_product_id',$productionProduct)
                            ->first();
        if ($presentationProduct->created_at->isToday()) {
            $presentationProduct->update([
                'quantity'=>$request->quantity,'unit_cost_production'=>$request->unit_cost_production,'unit_price_sale'=>$request->unit_price_sale]);
            $response['sucess'] = true;
            $response['message'] = "Presentacion actualizada correctamente";
        }else{
            $response['sucess'] = false;
            $response['message'] = "No se puede modificar la cantidad";
        }
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presentation_production_product  $presentation_production_product
     * @return \Illuminate\Http\Response
     */
    public function destroy($production_id,$product_id,$presentation_unit_id)
    {
        $productionProduct=Production_product::where('production_id',$production_id)
                            ->where('product_id',$product_id)
                            ->first()->id;
        $presentationProduct=Presentation_production_product::where('presentation_unit_id',$presentation_unit_id)
                            ->where('production_product_id',$productionProduct)
                            ->delete();
        return response()->json([
            'sucess' => true,
            'message' => 'Se elimino correctamente'
        ],200);
    }
}
