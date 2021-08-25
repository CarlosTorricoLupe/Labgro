<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresentationUnitRequest;
use App\Models\PresentationUnit;
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
        $presentations=PresentationUnit::all();
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
        $product=Product::find($id);
        $presentations=PresentationUnit::join('products','presentation_units.product_id','products.id')
                                          ->where('presentation_units.product_id',$product->id)
                                          ->get();
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
        PresentationUnit::create($request->only('name'));
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
    public function show(PresentationUnit $presentationUnit)
    {
        return response()->json([
            'success'=> true,
            'presentation' =>$presentationUnit
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresentationUnit $presentationUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PresentationUnit $presentationUnit)
    {
        $presentationUnit->update($request->all());
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
    public function destroy(PresentationUnit $presentationUnit)
    {
        $result = PresentationUnit::find($presentationUnit);
        $result->delete();
    }
}
