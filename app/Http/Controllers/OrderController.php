<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::all();
        return response()->json([
            'success' => true,
            'orders'=> $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest  $request
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $order = Order::create($request->except('details'));

        $details = $request->only('details');

        $order->materials()->sync($details['details']);

        return response()->json([
            'sucess' =>true,
            'message' =>'Pedido creado correctamente'
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
        $order = Order::getOrder($id);
        $details = Order::GetDetails($id);

        return response()->json([
            'success'=>true,
            'order'=>$order,
            'details' =>$details
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrderRequest  $request
     * @param  Order  $order
     * @return Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        return response()->json([
            'sucess' => true,
            'message' => 'Pedido actualizado correctamente'
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
        $result = Order::find($id);
        $result->delete();
        return response()->json([
            'sucess' => true,
            'message' => 'Pedido eliminado correctamente'
        ],200);
    }
}
