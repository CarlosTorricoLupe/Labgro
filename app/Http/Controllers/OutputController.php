<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

        $output->articles()->attach($details['details']);

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
