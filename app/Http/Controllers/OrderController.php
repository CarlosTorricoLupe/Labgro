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
    public function index(Request $request)
    {
        $orders=[
            "pendiente" => Order::GetTypeStatus('pending', $request->month, $request->year)->get(),
            "aprobado" => Order::GetTypeStatus('approved', $request->month, $request->year)->get(),
            "reprobado" => Order::GetTypeStatus('reprobate', $request->month, $request->year)->get(),
        ];
        return response()->json($orders,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest  $request
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->except('details');
        $input['role_id'] = auth()->user()->role_id;

        $order = Order::create($input);

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
        $order = Order::GetOrderById($id)->first();
        $details = Order::getDetails($id);

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

    public function reprobate($id)
    {
        $result = Order::Reprobate($id);
        return response()->json([
            'sucess' => true,
            'message' => 'Pedido reprobado correctamente',

        ],200);
    }
}
