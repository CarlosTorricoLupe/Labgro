<?php

namespace App\Http\Controllers;

use App\Models\PresentationUnit_product;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $presentations = PresentationUnit_product::where('product_id',$id)->get();
        if(count($presentations)){
            return $presentations;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $response=array();
        $product = Product::find($id);
        if (! $product->presentations->contains($request->presentation_unit_id)) {
            $product->presentations()->attach($request->presentation_unit_id,['unit_cost_production'=>$request->unit_cost_production,'unit_price_sale'=>$request->unit_price_sale]);
            $response['sucess'] = true;
            $response['message'] = "Presentacion agregada correctamente";
        }else{
            $response['sucess'] = false;
            $response['error'] = "La unidad de presentacion ya existe";
        }
        return response()->json($response,201);
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
