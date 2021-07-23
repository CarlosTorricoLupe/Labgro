<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Output;
use App\Models\OutputDetail;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class OutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outputs = Output::all();

        foreach ($outputs as $output){
            $output['details']= $this->getDetail($output['id']);
        }
        if(count($outputs)){
            return $outputs;
        } else {
        return response()->json([
            'success'=>false,
            'message'=>'No se encontraron resultados'
        ],404);
    }

    }

    public function getDetail($output){
        $details  = OutputDetail::where('output_id', $output)->get();
        foreach ($details as $detail){
            $detail['article']= Article::find($detail['article_id']);
        }
        return $details;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $output = Output::create($request->except('details'));

        $details = $request->only('details');

        $result = $this->decrementStockArticle($details['details']);

        $response = array();

        if(isset($result['details'])){

            $output->articles()->attach($result['details']);

        }

        if(isset($result['errors'])){

            $response['errors'][] = $result['errors'];

        }

        return response()->json([
            'sucess' =>true,
            'message' =>'Salida creada correctamente',
            'details' => $response,
        ]);
    }
    public function decrementStockArticle($details){
        $response = array();
        foreach ($details as $detail){
            $article = Article::find($detail['article_id']);//10

            if($article) {
                $stock = $article->stock;

                $new_stock = $stock - $detail['quantity'];

                if( $new_stock < 0 ){
                    $response['errors'][] = "Articulo " . $article->name_article . " no tiene stock suficiente";

                } else {
                    $response['details'][] = $detail;

                    $article->stock = $new_stock;

                    $article->save();
                }
            }
        }

        return $response;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
