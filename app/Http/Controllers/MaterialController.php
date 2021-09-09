<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $raw_materials = Material::GetTypeMaterial('raw_material')->get();
        $supplies = Material::GetTypeMaterial('supplies')->get();

        return response()->json([
            'success'=> true,
            'raw_material' =>$raw_materials,
            'supplies' => $supplies
        ],200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMaterialRequest $request)
    {
        $material =  Material::create($request->all());
        Material::UpdateCategoryMaterial($material, $material->article_id);

        return response()->json([
            'sucess' =>true,
            'message' =>'Materia creada correctamente'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        $result = Material::GetTypeMaterialById($material->id)->get();
        return response()->json([
            'success'=> true,
            'material' =>$result
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMaterialRequest  $request
     * @param  Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Materia actualizada correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Material::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Materia eliminada correctamente'
        ],200);
    }
}
