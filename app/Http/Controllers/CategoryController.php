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
        $categories=Category::where('Active','=',1)->get();
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
         $category->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Categoria actualizada correctamente'
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
        $category = Category::findorfail($id);
        $articles =Category::join('articles','articles.category_id','=',"categories.id")
            ->where('categories.name','=',$category->name)
            ->select('articles.cod_article','articles.name_article')
            ->get();
        if(count($articles)){
            return response()->json([
                'success'=>false,
                'message'=>'No se puede eliminar la categoria porque tiene los siguientes articulos',
                'articles'=>$articles
            ],200);
        } else {
            Category::destroy($id);
            return response()->json([
                'success'=>true,
                'message'=>'Categoria eliminada correctamente',
            ],200);
            }          
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
