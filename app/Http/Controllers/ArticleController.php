<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$this->authorize('view', Article::class);
        Article::UpdateStatusIsLow();
        $result = Article::ArticlesAll();
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateArticleRequest  $request
     * @return Response
     */
    public function store(CreateArticleRequest $request)
    {
        //$this->authorize('manage', Article::class);
        $article=new Article($request->all());
        $article->stock_total=$article->stock;
        $article->save();
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
     * @param  UpdateArticleRequest  $request
     * @param  Article  $article
     * @return Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //$this->authorize('manage', Article::class);
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
     * @return Response
     */
    public function destroy($id)
    {
        //$this->authorize('manage', Article::class);
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

    public function peripheralReport(Request $request){
        $result=Article::ArticlesPeripheralReport($request);
//        $res = ArticleResource::collection($result);
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
