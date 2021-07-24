<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeRequest;
use App\Models\Article;
use App\Models\Article_income;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $incomes=Income::searchIncome($request->incomevalue,$request->month);   
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
        $income = new Income($request->all()); 
        $income->user_id = auth()->user()->id;
        $income->saveOrFail();
        $articles=$request->get('articles');
        $res=$this->updateDataArticles($articles);
        $response=array();

        if(isset($res['articles'])){
            $income->articles()->sync($articles);
            $response['incomes']=$res['articles'];
        }else{
            $response['error'] = "No se agregaron Articulos";
             }
        return response()->json([
            'success' => true,
            'message' => 'Entrada creada correctamente',
            'response' =>$response,
        ]);
    }

   public function updateDataArticles($articles){
       $response = array();
        foreach($articles as $article){
            $articleUpdate=Article::find($article['article_id']);
            if($articleUpdate){
                $articleUpdate->stock +=$article['quantity'];
                $articleUpdate->saveOrFail();
                $response['articles']="Stock de los articulos actualizados correctamente";
            }
       }
       return $response;
   }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show(Income $income)
    {
        $id     = $income->id;    
        $details = Article_income::join('articles','article_incomes.article_id','articles.id')->join('units','articles.unit_id',"units.id")
        ->select('article_incomes.quantity','article_incomes.unit_price','article_incomes.total_price', 'articles.name_article','unit_measure')
        ->where('article_incomes.income_id', '=', $id)
        ->get();
        
        return response()->json([
            'success'=> true,
            'details' => $details
        ],200);  
    }


     public function getHeader(Request $request){
        $id     = $request->id;
        $income = Income::join('users','incomes.user_id','=','users.id')
                ->select('*')
                ->where('incomes.id', '=', $id)
                ->take(1)->get();

        return response()->json([
        'success'=> true,
        'income' => $income
        ],200);           
    }

    public function getDetailsIncome(Request $request){
        
        $id     = $request->id;    
        $details = Article_income::join('articles','article_incomes.article_id','articles.id')->join('units','articles.unit_id',"units.id")
        ->select('article_incomes.quantity','unit_measure', 'articles.name_article','article_incomes.unit_price','article_incomes.total_price')
        ->where('article_incomes.income_id', $id)
        ->get();
        
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
        $income->user_id=auth()->user()->id;
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
        //
    }

    
}
