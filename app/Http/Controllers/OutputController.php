<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutputRequest;
use App\Models\Article;
use App\Models\Article_income;
use App\Models\Output;
use App\Models\OutputDetail;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param OutputRequest $request
     * @return \Illuminate\Http\Response
     */


    public function store(OutputRequest $request)
    {

        $details = $request->only('details');

        $response = array();
        dd($details['details']);

        if( $this->verifyStockArticle($details['details']) ){

            $this->decrementStockArticle($details['details']);

            $output = Output::create($request->except('details'));

            $output->articles()->attach($details['details']);

            $response['sucess'] = true;

            $response['message'] = "Salida creada correctamente";
        }else{
            $response['sucess'] = false;

            $response['errors'] = "Ningun articulo tiene el stock suficiente";
        }

        return response()->json([$response]);
    }

    public function verifyStockArticle($details){

        $is_permit = true;

        foreach ($details as $detail){
            $article = Article::find($detail['article_id']);

            $stock_article = $article->stock;
            $quantity_order = $detail['quantity'];

            if( ($stock_article - $quantity_order) < 0 ){
                if(($this->translateStockIncome($article, $quantity_order)) == false){
                    $is_permit = false;
                }
            }
        }
        return $is_permit;
    }

    public function translateStockIncome($article, $quantity_order){
        $is_permit = false;

        $income = Article_income::
            where('article_id', $article->id )
            ->where('is_consumed', '=' , 0)
            ->first();

        if( ($article->stock + $income->quantity) > $quantity_order) {
            $article->stock = $article->stock + $income->quantity;
            $income->is_consumed = 1;
            $article->save();
            $income->save();
            $is_permit = true;
        }

        return $is_permit;
    }


    public function decrementStockArticle($details){
        foreach ($details as $detail){
            $article = Article::find($detail['article_id']);

            if($article) {
                $article->stock = $article->stock - $detail['quantity'];
                $article->stock_total = $article->stock;
                $article->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Output  $output
     * @return \Illuminate\Http\Response
     */
    public function show(Output $output)
    {
        $outputs=Output::getOutput($output->id);
        $details=OutputDetail::getDetails($output->id);

        return response()->json([
            'success'=>true,
            'output'=>$outputs,
            'details'=>$details
        ]);
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

    public function getDetailOutput(Request $request){
        $details = Article_income::getDetails($request->id);

        return response()->json([
            'success'=> true,
            'details' => $details
        ],200);
    }

    public function getArticles($section){
        $articles = Article::join('categories','articles.category_id','=','categories.id')
                            ->join('units', 'articles.unit_id', '=', 'units.id')
                            ->join('output_details','output_details.article_id','=', 'articles.id' )
                            ->join('outputs', 'output_details.output_id','=','outputs.id')
                            ->where('outputs.section_id', $section)
                            ->select('outputs.delivery_date', 'articles.name_article', 'output_details.quantity', 'units.unit_measure', 'categories.name')
                            ->get();

        return $articles;
    }

    public function verififyPriceArticle($id){
        $response = Array();
        $article = Article::find($id);
        $income = Article_income::where('article_id', $article->id )
            ->where('is_consumed', '=' , 0)
            ->first();

        $actual_price = $article->unit_price;
        $response ['actual']['stock'] = $article->stock;
        $response ['actual']['price'] = $actual_price;


        if($income){
            $income_price = $income->unit_price;
            $response ['income']['stock'] = $income->quantity;
            $response ['income']['price'] = $income_price;
            $response ['income']['date'] = $income->created_at;
            $response['same_price'] = ($actual_price == $income_price);
        }else{
            $response['income'] = "No hay entrada para este articulo";
        }

        return $response;
    }

    public function outputsByArticle($id){
        $outputs = Output::getOutputsByArticle($id);

        return response()->json([
            'success'=> true,
            'outputs' => $outputs
        ],200);
    }
}
