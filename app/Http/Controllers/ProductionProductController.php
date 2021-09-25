<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;

class ProductionProductController extends Controller
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
    public function store(Request $request,$id)
    {
        $response = array();
        $production = Production::find($id);
        if (isset($production)) {
            $production->products()->attach($request->product_id, ['quantity' => $request->quantity]);
            $response['sucess'] = true;
            $response['message'] = "Producto agregado a la produccion correctamente";
        } else {
            $response['sucess'] = false;
            $response['error'] = "No tiene una produccion registrada";
        }
        return response()->json($response, 201);
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
