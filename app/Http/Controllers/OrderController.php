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
         $orders = [
             "pendiente" => $this->getCountMaterial('pending', $request->monthone, $request->monthtwo, $request->year, $request->area, $request->article),
             "aprobado" => $this->getCountMaterial('approved', $request->monthone, $request->monthtwo, $request->year, $request->area, $request->article),
             "reprobado" => $this->getCountMaterial('reprobate', $request->monthone, $request->monthtwo, $request->year, $request->area, $request->article),
        ];
        return response()->json($orders,200);
    }
    public function getCountMaterial($status, $monthone, $monthtwo,  $year, $area, $article){
        $orders = Order::GetTypeStatus($status, $monthone, $monthtwo,$year, $area)->get();
        $result = [];
        foreach ($orders as $order){
            $order['quantity_materials'] = $order->materials()->count();
            $order['materials'] = Order::GetMaterials($order->id)->get();
            $filter = false;
            foreach ($order['materials'] as $material){
                if (isset($article)){
                    if( strpos(strtoupper($material['name_article']), strtoupper($article)) !== false ){
                        $filter = true;
                    }
                }else {
                    $filter = true;
                }
            }
            if($filter){
                $result[] = $order;
            }
        }
        return $result;
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

    public function reprobate(Request $request, $id)
    {
        $result = Order::Reprobate($id, $request->description);
        return response()->json([
            'sucess' => true,
            'message' => 'Pedido reprobado correctamente',
        ],200);
    }
    public function quantity_notifications()
    {
        $notifitacions = Order::GetQuantityNotifications()->count();
        return response()->json([
            'sucess' => true,
            'notifications_new' => $notifitacions,
        ],200);
    }

    public function notifications()
    {
        $notifitacions = Order::GetNotifications()->get();
        foreach ($notifitacions as $notifitacion){
            $notifitacion['detail'] = Order::GetMaterials($notifitacion->order_id)->get();
        }
        Order::ViewedAllGeneral();
        return response()->json([
            'sucess' => true,
            'notifications' => $notifitacions,
        ],200);
    }

    public function view_notifications($id)
    {
        Order::Viewed($id);
        return response()->json([
            'sucess' => true,
            'notification' => Order::find($id),
        ],200);
    }


}
