<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductMaterialRequest;
use App\Http\Requests\UpdateProductMaterialRequest;
use App\Models\Material_product;
use App\Models\ProductMaterial;

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
     * @param  CreateProductMaterialRequest  $request
     * @return Response
     */
    public function store(CreateProductMaterialRequest $request, $id)
    {
        $input = $request->all();
        $input['product_id'] = $id;
        $verify = Material_product::where('product_id', $id)
                                    ->where('material_id', $input['material_id'])->get();
        if(count($verify) == 0){
            Material_product::create($input);
            $response['sucess'] = true;
            $response['message'] = "La Materia agregada correctamente";
        }else{
            $response['sucess'] = false;
            $response['error'] = "La Materia de presentacion ya existe";
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
     * @param  UpdateProductMaterialRequest  $request
     * @param  int  $product_id
     * @param  int  $material_id
     * @return Response
     */
    public function update(UpdateProductMaterialRequest  $request, $product_id, $material_id)
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
     * @return Response
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
