<?php

namespace App\Http\Controllers;

use App\Models\ItemPrice;
use Illuminate\Http\Request;

class ItemPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ItemPrice::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ItemPrice::create($request->all());
        return response()->json([
            'sucess' =>true,
            'message' =>'Precio creada correctamente'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ItemPrice $item)
    {
        return response()->json([
            'success'=> true,
            'item' =>$item
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemPrice $item)
    {
        
        $item->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Precio actualizada correctamente'
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
        ItemPrice::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Se elimino correctamente'
        ],200);
    }
}
