<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use App\Models\Output;
use App\Models\Product;

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
     * @return Response
     */
    public function store(CreateMaterialRequest $request)
    {
        $input = $request->all();
        $input['role_id'] = auth()->user()->role_id;
        $material =  Material::create($input);
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
     * @return Response
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
     * @return Response
     */
    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update($request->all());
        Material::UpdateCategoryMaterial($material, $material->article_id);
        return response()->json([
            'sucess' => true,
            'message' => 'Materia actualizada correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $material =  Material::find($id);
        try {
            $material->delete();
            $code =200;
            $response = [
                'success' => true,
                'message' => 'Materia eliminada correctamente'
            ];
        } catch (\Exception $e) {
            $code =400;
            $products = Product::GetContainMaterialId($id)->get();

            $response = [
                'success' => false,
                'message' => 'Este material existe en algún producto',
                'products' => $products,
                'error' => $e->getMessage(),
            ];
        }
        return response()->json($response, $code);
    }

    public function IncomesMaterialByGraphics(){
        $materials = Material::GetTypeMaterial('raw_material')->get();
        $response = array();
        foreach ($materials as $material){
            $outputs = Output::getOutputsByArticle($material->id);
            $series = array();
            foreach ($outputs as $output){
                $series[] =[
                    "value" => $output->quantity,
                    "name" =>Material::MonthName( $output->created_at),
                ];
            }
            $response[] = [
                "name" => $material->article->name_article,
                "series" => $series,
            ];
        }
        return $response;
    }
}
