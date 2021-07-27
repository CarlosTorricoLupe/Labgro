<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**$result =Kardex::join('categories','articles.category_id','=',"categories.id")->join('units','articles.unit_id','=',"units.id")

        ->select('articles.*','name', 'unit_measure','kind')
        ->get();
       return $result;**/

        //return Kardex::all();   
        $result =Kardex::join('article_incomes','kardexes.article_income_id','=',"article_incomes.id")->join('output_details','kardexes.output_detail_id','=',"output_details.id")
        ->join('articles','kardexes.article_id','=',"articles.id")->join('units','articles.unit_id','=',"units.id")
        ->select('kardexes.*','article_incomes.quantity','article_incomes.unit_price','article_incomes.total_price','output_details.quantity','output_details.total','articles.cod_article','articles.name_article','articles.stock','units.unit_measure')
        ->orderBy('articles.name_article', 'asc')
        ->paginate(20);
        //->get();
        return response()->json([
            'success'=> true,
            'details' => $result
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result =Kardex::join('article_incomes','kardexes.article_income_id','=',"article_incomes.id")->join('output_details','kardexes.output_detail_id','=',"output_details.id")
        ->join('articles','kardexes.article_id','=',"articles.id")->join('units','articles.unit_id','=',"units.id")
        ->select('kardexes.*','article_incomes.quantity','article_incomes.unit_price','article_incomes.total_price','output_details.quantity','output_details.total','articles.cod_article','articles.name_article','articles.stock','units.unit_measure')
        ->orderBy('articles.name_article', 'asc')
        ->paginate(20);
        //->get();
        return response()->json([
            'success'=> true,
            'details' => $result
        ],200);
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
