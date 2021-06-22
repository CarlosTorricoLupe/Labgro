<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateArticuloRequest;
use App\Http\Requests\UpdateArticuloRequest;
use App\Models\Article;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //GET listar registro
    public function index(Request $request)
    {
        if($request->has(key:'txtBuscar'))
        {
            $article = Article::where('categoria', 'like', '%' . $request->txtBuscar . '%')
                            ->get();
        }else{
        $article = Article::all();
        }
        return $article;
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
        $input = $request->all();
        Article::create($input);
        return response()->json([
            'res' => true,
            'message' => 'Regsitro creado correctamente'
        ],status:200);
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
        return $article;
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
            'message' => 'Registro actualizado correctamente'
        ],status:200);
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
            'res' => true,
            'message' => 'Se elimino correctamente'
        ],status:200);
    }
}
