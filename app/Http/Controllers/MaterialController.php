<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use App\Models\Material_production_product;
use App\Models\Output;
use App\Models\Product;
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
     * @return Response
     */
    public function store(CreateMaterialRequest $request)
    {
        $input = $request->all();
        $role_id = auth()->user()->role_id;
        $article_id = $request->get('article_id');
        $exist = Material::GetMaterialByRoleIdArticleId($role_id, $article_id)->first();
        if (isset($exist) ){
            $response = [
                'success' => false,
                'message' =>'Materia ya existente en este rol'
            ];
            $statusCode =400;
        }else{
            $input['role_id'] = $role_id;
            $material =  Material::create($input);
            Material::UpdateCategoryMaterial($material, $material->article_id);
            $response = [
                'success' => true,
                'message' =>'Materia creada correctamente'
            ];
            $statusCode =200;
        }

        return response()->json($response,$statusCode);
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

    public function IncomesMaterialByGraphics(Request $request){

        $role_id= auth()->user()->role_id;
        $materials = Material::GetTypeMaterial('raw_material')->get();
        $response = array();
        foreach ($materials as $material){
            $response[] = [
                'name' => $material->article->name_article,
                'series' => $this->getDetailByMonths($material, $request->year, 1)
            ];
        }
        return $response;
    }
    public function getDetailByMonths($material, $year, $role_id){
        $series = array();
        for ($month=1; $month<=12; $month++){
            $outputs = Output::getOutputsByArticle($material->id, $year, $month, 1);
            $series[] = [
                'value' =>$outputs->sum('quantity'),
                'name' => Material::MonthNameByNumberMonth($month),
            ];
        }
        return $series;
    }
    public function getQuantityLeftOver($id, Request $request){
        $series = array();
        for ($month=1; $month<=12; $month++){
            $leftover = Material_production_product::where('material_id',$id)
                        ->whereMonth('created_at',$month)
                        ->whereYear('created_at',$request->year)
                        ->where('role_id',auth()->user()->role_id)
                        ->latest()->first(['control']);
            $series[]=[
                'name'=>Material::MonthNameByNumberMonth($month),
                'value'=>$leftover === null? 0:$leftover['control'],
            ];
        }
            dd($series); 
    }
}
