<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //GET listar registro
    public function index()
    {
           $result =Article::ArticlesStockMin();
           return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //POST insertar datos
    public function store(CreateArticuloRequest $request)
    {
        Article::create($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Registro creado correctamente'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //GET return un solo registro
    public function show(Article $article)
    {
        return response()->json([
            'success'=> true,
            'category' =>$article
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //PUT actualizar registros
    public function update(UpdateArticuloRequest $request, Article $article)
    {
        $article->update($request->all());
        return response()->json([
            'res' => true,
            'message' => 'Articulo actualizado correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //DELETE eliminar
    public function destroy($id)
    {
        Article::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Se elimino correctamente'
        ],200);
    }

    public function searchArticle(Request $request)
    {
        $result = Article::where('name_article', 'like',$request->txtBuscar.'%')->get();

        if(count($result)){
            return $result;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    public function searchArticleForCategorgy(Request $request)
    {
        $result =Article::join('categories','articles.category_id','=',"categories.id")
            ->where('categories.name','=',$request->txtBuscar)
            ->select('articles.*')
            ->get();


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
