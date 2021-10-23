<?php

namespace App\Http\Controllers;

use App\Models\Presentation_production_product;
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
        $response=array();
        $productionProduct=Production_product::where('production_id',$production_id)
                            ->where('product_id',$product_id)
                            ->first();
        if ($productionProduct) {
            $productionProduct->presentations()
                ->attach($request->presentation_id,[
                    'quantity'=>$request->quantity,
                    'unit_cost_production'=>$request->unit_cost_production,
                    'unit_price_sale'=>$request->unit_price_sale
                ]);
            $response['sucess'] = true;
            $response['message'] = "Presentación agregada correctamente";
        }else{
            $response['sucess'] = false;
            $response['message'] = "No se encontraron datos que coincida con la producción";
        }
        return response()->json($response, 201);
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
    public function update(Request $request, $production_id,$product_id,$presentation_unit_id,Presentation_production_product  $presentation_production_product)
    {
        $productionProduct=Production_product::where('production_id',$production_id)
                            ->where('product_id',$product_id)
                            ->first()->id;
        $presentationProduct=Presentation_production_product::where('presentation_unit_id',$presentation_unit_id)
                            ->where('production_product_id',$productionProduct)
                            ->first('quantity','unit_cost_production','unit_price_sale');
        $presentationProduct->update($request->all()); 
        return response()->json([
            'success'=>true,
            'message'=>'Presentacion actualizada correctamente',
            'presentacion'=>$presentationProduct
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presentation_production_product  $presentation_production_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presentation_production_product $presentation_production_product)
    {
        //
    }
}
