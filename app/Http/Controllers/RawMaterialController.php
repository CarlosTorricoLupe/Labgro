<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRawMaterialRequest;
use App\Http\Resources\ArticleByMonths;
use App\Http\Resources\ArticleByMonthsResource;
use App\Http\Resources\RawMaterialResource;
use App\Models\Article;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRawMaterialRequest $request)
    {
        RawMaterial::create($request->all());
        return response()->json([
            'sucess' =>true,
            'message' =>'Materia prima creada correctamente'
        ],201);
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
    public function apiPrueba()
    {
//        $result=RawMaterial::whereYear('created_at', '=', 2021)
//            ->whereMonth('created_at', '=', 8)
//            ->select('created_at')
//            ->get();
        $result = ArticleByMonthsResource::collection(Article::all());
        return response()->json($result,200);
    }
}
