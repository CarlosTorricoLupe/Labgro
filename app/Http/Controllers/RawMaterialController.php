<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRawMaterialRequest;
use App\Models\RawMaterial;
use Illuminate\Http\Request;

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
    public function show(RawMaterial $rawMaterial)
    {
        return response()->json([
            'success'=> true,
            'raw_material' =>$rawMaterial
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $rawMaterial->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Materia Prima actualizada correctamente'
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
        RawMaterial::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Se elimino correctamente'
        ],200);
    }
}
