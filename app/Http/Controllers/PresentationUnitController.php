<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresentationUnitRequest;
use App\Http\Requests\UpdatePresentationUnitRequest;
use App\Models\PresentationUnit;
use App\Models\PresentationUnit_product;
use App\Models\Product;
use Illuminate\Http\Request;

class PresentationUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presentations=PresentationUnit::where('role_id',auth()->user()->role_id)->get();

        if(count($presentations)){
            return response()->json([
                'success'=>true,
                'presentations'=>$presentations
            ],200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    public function indexByProduct($id)
    {
        $presentations = PresentationUnit_product::join('products','presentation_unit_products.product_id','products.id')->join('presentation_units','presentation_unit_products.presentation_unit_id','presentation_units.id')->select('presentation_units.name','presentation_unit_products.unit_cost_production','presentation_unit_products.unit_price_sale')->where('presentation_unit_products.product_id',$id)->get();
        if(count($presentations)){
            return response()->json([
                'success'=>true,
                'presentations'=>$presentations
            ],200);
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
    public function store(PresentationUnitRequest $request)
    {
        $data= $request->all();
        $data['role_id'] = auth()->user()->role_id;
        PresentationUnit::create($data);
        return response()->json([
            'sucess' =>true,
            'message' =>'Unidad de presentacion creada correctamente'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PresentationUnit  $presentationUnit
     * @return \Illuminate\Http\Response
     */
    public function show(PresentationUnit $presentation)
    {
        return response()->json([
            'success'=> true,
            'presentation' =>$presentation
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresentationUnit $presentationUnit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePresentationUnitRequest $request, PresentationUnit $presentation)
    {
        $data=$request->all();
        $data['role_id']= auth()->user()->role_id;
        $presentation->update($data);
        return response()->json([
            'sucess' => true,
            'message' => 'Unidad de presentacion actualizada correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresentationUnit  $presentationUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $presentation=PresentationUnit::findOrFail($id);
        $products =PresentationUnit_product::getProducts($presentation->id);
        if(count($products)){
            return response()->json([
                'success'=>false,
                'message'=>'No se puede eliminar la presentacion porque tiene los siguientes productos',
                'products'=>$products
            ],200);
        } else {
            PresentationUnit::destroy($id);
            return response()->json([
                'success'=>true,
                'message'=>'Presentacion eliminada correctamente',
            ],200);
            }
    }
}
