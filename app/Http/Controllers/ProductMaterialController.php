<?php

namespace App\Http\Controllers;

use App\Models\Material_product;
use App\Models\ProductMaterial;
use Illuminate\Http\Request;

class ProductMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $materials = Material_product::getDetailMaterial($id);
        if(count($materials)){
            return $materials;
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
    public function store(Request $request, $id)
    {
        $input = $request->all();
        $input['product_id'] = $id;
        Material_product::create($input);

        return response()->json([
            'sucess' =>true,
            'message' =>'Materia prima/insumo creada correctamente'
        ],201);
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
     * @param  int  $product_id
     * @param  int  $material_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id, $material_id)
    {
        Material_product::where('product_id', $product_id)
            ->where('material_id',$material_id)
            ->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Se actualizo correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product_id
     * @param  int  $material_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $material_id)
    {
        Material_product::where('product_id', $product_id)
            ->where('material_id',$material_id)
            ->delete();
        return response()->json([
            'sucess' => true,
            'message' => 'Se elimino correctamente'
        ],200);
    }
}
