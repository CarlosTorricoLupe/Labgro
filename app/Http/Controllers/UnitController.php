<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Unit::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUnitRequest $request)
    {
        Unit::create($request->all());
        return response()->json([
            'sucess' =>true,
            'message' =>'unidad creada correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return response()->json([
            'success'=> true,
            'unit' =>$unit
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Unidad actualizada correctamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit=Unit::findorfail($id);
        $articles=Unit::join('articles','articles.unit_id','units.id')->where('units.id',$unit->id)->select('articles.cod_article','articles.name_article')->get();
        if(count($articles)){
            return response()->json([
                'success'=>false,
                'message'=>'No se puede eliminar la Unidad porque tiene los siguientes articulos',
                'articles'=>$articles
            ],200);
        }else{
        Unit::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Se elimino correctamente'
        ],200);
        }
    }
}
