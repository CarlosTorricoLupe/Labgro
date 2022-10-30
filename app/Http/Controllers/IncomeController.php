<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Models\Article;
use App\Models\Article_income;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $incomes=Income::searchIncome($request->incomevalue,$request->month,$request->year)
            ->paginate(12)
            ->appends(request()->query());
          return response()->json([
            'success' => true,
            'incomes'=> $incomes
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomeRequest $request)
    {
        logger($request);
        $income = new Income($request->all());
        $income->saveOrFail();
        $articles=$request->get('articles');
        $response=array();
        if(isset($articles)){
            // $income->articles()->sync($articles);
            // $response['incomes']=$res['articles'];
            foreach ($articles as $article){
                list($currentStock,$currentPrice,$unitValue)=$this->getCurrentStock($article);
                $income->articles()->attach(
                    $article['article_id'],
                    ['quantity'=>$article['quantity'],
                    'unit_price'=>$article['unit_price'],
                    'total_price'=>$article['total_price'],
                    'current_stock'=>$currentStock,
                    'current_price'=>$currentPrice,
                    'unit_value'=>$unitValue
                    ]
                );
            }
        $res=$this->updateDataArticles($articles);
        $response['incomes']=$res['articles'];
        }else{
            $response['error'] = "No se agregaron Articulos";
             }
        return response()->json([
            'success' => true,
            'message' => 'Entrada creada correctamente',
            'response' =>$response,
        ],201);
    }

   public function updateDataArticles($articles)
   {
       $response = array();
        foreach($articles as $article){
            $articleUpdate=Article::find($article['article_id']);
            if($articleUpdate){
                $articleUpdate['unit_price']= (($articleUpdate['stock']*$articleUpdate['unit_price'])+($article['quantity']*$article['unit_price']))/(($articleUpdate['stock']+$article['quantity']));
                $articleUpdate['stock'] = $article['quantity'] + $articleUpdate['stock_total'];
                $articleUpdate['stock_total'] = $article['quantity'] + $articleUpdate['stock_total'];
                $article['is_consumed'] = 1;
                $articleUpdate->saveOrFail();
                $response['articles']="Stock de los articulos actualizados correctamente";
            }
       }
       return $response;
   }

   public function getCurrentStock($article)
   {
       $currentStock=0;
        $currentPrice=0;
        $unitValue=0;
        $articleUpdate=Article::find($article['article_id']);
        if($articleUpdate){
            $unitValue=(($articleUpdate['stock']*$articleUpdate['unit_price'])+($article['quantity']*$article['unit_price']))/(($articleUpdate['stock']+$article['quantity']));
            $currentStock=$articleUpdate->stock;
            $currentPrice=$articleUpdate->unit_price;
        }
       return [$currentStock,$currentPrice,$unitValue];
   }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        $incomes=Income::getIncome($income->id);
        $details=Article_income::getDetails($income->id);
        return response()->json([
            'success'=>true,
            'income'=>$incomes,
            'details'=>$details
        ],200);
    }

    public function getDetailsIncome(Request $request){

        $details = Article_income::getDetails($request->id);

        return response()->json([
            'success'=> true,
            'details' => $details
        ],200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Income $income)
    {
        $income->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Entrada actualizada correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function destroy(Income $income)
    {

        $details=Article_income::getDetails($income->id);
        $details=$this->restoreDataArticles($details);
        $income->delete();
        return response()->json([
            'sucess' => true,
            'message' => 'Entrada eliminada correctamente'
        ],200);
    }

    public function restoreDataArticles($details)
    {
        $response = array();
         foreach($details as $detail){
             $articleUpdate=Article::find($detail['article_id']);
             if($articleUpdate){
                 $articleUpdate->stock_total -=$detail['quantity'];
                 $articleUpdate->stock -=$detail['quantity'];
                 $articleUpdate->unit_price -=$detail['unit_price'];
                 $articleUpdate->saveOrFail();
                 $response['articles']="Stock de los articulos restaurados correctamente";
                $articleUpdate->incomes()->detach($detail['income_id']);
             }
        }
        return $details;
    }

    public function getIncomesArticle($id){
        $articles = Article_income::where('article_id', $id)
            ->select('article_incomes.*')
            ->get();
        return $articles;
    }

    public function  getIncomeArticleByDate(Request $request){
        $incomes = Income::searchArticleByDate($request->id,$request->mounthone,$request->mounttwo,$request->year);
        return response()->json([
            'success'=>true,
            'incomes'=>$incomes,
        ],200);
    }

}
