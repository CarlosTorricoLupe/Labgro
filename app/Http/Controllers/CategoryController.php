<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        if(count($categories)){
            return $categories;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
        //return Category::all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {

        Category::create($request->all());
        return response()->json([
            'sucess' =>true,
            'message' =>'Categoria creada correctamente'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json([
            'success'=> true,
            'category' =>$category
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategoryRequest $request, Category $category)
    {
        $name = $category->name;
        if ($name == "Materia Prima" || $name == "Insumos"){
            $response = [
                'success' => false,
                'message' =>'No permitido, su uso esta en Producción'
            ];
        }else{
            $category->update($request->all());
            $response = [
                'success' => true,
                'message' =>'Categoria actualizada correctamente'
            ];
        }
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorfail($id);
        $name = $category->name;

        $articles =Category::join('articles','articles.category_id','=',"categories.id")
            ->where('categories.name','=',$category->name)
            ->select('articles.cod_article','articles.name_article')
            ->get();

        if($name == "Materia Prima" || $name == "Insumos"){
            $response = [
                'success' => false,
                'message' =>'No permitido, su uso esta en Producción'
            ];
        } else if(count($articles) ){
            $response = [
                'success' => false,
                'message' =>'No se puede eliminar la categoria porque tiene los siguientes articulos',
                'articles' => $articles,
            ];
        } else {
            Category::destroy($id);
            $response = [
                'success' => true,
                'message' =>'Categoria eliminada correctamente'
            ];
        }
        return response()->json($response,200);
    }



    public function search($name)
    {
        $result = Category::where('name', 'like',$name.'%')
                            /* ->where('Active','=',1) */->get();
        if(count($result)){
            return $result;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }
}
