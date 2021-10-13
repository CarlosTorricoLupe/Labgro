<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Production_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productions=Production::select('date_production')->WhereMonth('date_production',$request->month)->WhereYear('date_production',$request->year)->where('role_id',auth()->user()->role_id)->get();
        return response()->json([
            'sucess'=>true,
            'productions'=>$productions
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
        $data=$request->only('date_production');
        $data['role_id'] = auth()->user()->role_id;
        Production::create($data);
        return response()->json([
            'sucess' =>true,
            'message' =>'Produccion creada correctamente',
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }

    public function GetConsolidate(Request $request){
     $productions=Production::getProductsProducedByMonth($request->month,$request->year);
     $result = array();
        foreach ($productions as $production){
            $import =  $production->units_produced*$production->unit_cost_production;
            $result[] = [
                'Producto' => $production->product_name,
                'Unidad_Presentacion' => $production->presentation_name,
                'Costo_Unitario_Produccion' => $production->unit_cost_production,
                'Precio_Unitario_Venta' => $production->unit_price_sale,
                'Unidades_Producidas' => $production->units_produced,
                'Importe' =>$import,
                'Cantidad_unidades_daniadas' =>0,
                'Importe_unidades_daniadas' =>0,
                'Cantidad_unidades_vendidas' =>0,
                'Importe_unidades_vendidas' =>0,
                'Total_Utilidad'=>$import
            ];
        }
        return $result;
    }
}
