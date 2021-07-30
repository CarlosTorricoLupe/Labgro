<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutputRequest;
use App\Models\Article;
use App\Models\Output;
use App\Models\OutputDetail;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class OutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $outputs = Output::searchOutput($request->outputvalue, $request->month, $request->year);
        return response()->json([
            'success' => true,
            'incomes'=> $outputs
        ]);

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
    public function store(OutputRequest $request)
    {

        $details = $request->only('details');

        $result = $this->decrementStockArticle($details['details']);

        $response = array();

        if(isset($result['details'])){
            $output = Output::create($request->except('details'));

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
     * @param  Output  $output
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $output)
    {
        $result = Output::find($output);
        $result->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Salida actualizada correctamente'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($output)
    {
        $result = Output::find($output);
        $result->delete();
    }

    public function searchOutputByDate(Request $request){
        $outputs = Output::whereMonth('order_date', '=', $request->month)
                            ->whereYear('order_date', '=', $request->year)
                            ->get();

        if(count($outputs)){
            return $outputs;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontrarossn resultados'
            ],404);
        }
    }

    public function getDetailOutput($output){
        $details = OutputDetail::where('output_id',$output)->get();
        if(count($details)){
            return $details;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    public function getArticles($section){
        /*$articles = Article::whereHas('outputs', function (Builder $query) use ($section) {
                $query->where('section_id', $section);
        })->get();

        return $articles;
    */
        $articles = Article::join('categories','articles.category_id','=','categories.id')
                            ->join('units', 'articles.unit_id', '=', 'units.id')
                            ->join('output_details','output_details.article_id','=', 'articles.id' )
                            ->join('outputs', 'output_details.output_id','=','outputs.id')
                            ->where('outputs.section_id', $section)
                            ->select('outputs.delivery_date', 'articles.name_article', 'output_details.quantity', 'units.unit_measure', 'categories.name')
                            ->get();

        return $articles;
    }

    public function prueba(){
        $outputs = Output::whereTime('created_at', '>=', '23:07:00')
                            ->whereTime('created_at','<=', '23:08:00')
                            ->get();
        return $outputs;
    }
}
