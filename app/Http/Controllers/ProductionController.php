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
        $productions=Production::select('date_production')->WhereMonth('date_production',$request->month)->WhereYear('date_production',$request->year)->get();
            return response()->json([
                'success'=>true,
                'productions'=>$productions
            ],404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $production=Production::create($request->all());
        $products=$request->get('products');
        if(isset($products)){
            $production->product()->sync($products);
            $exist_production=true;
        }else{
            $exist_production=false;
             }
        return response()->json([
            'sucess' =>true,
            'message' =>'Produccion creada correctamente'
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
                'Unidad/Presentación' => $production->presentation_name,
                'Costo Unitario de Producción' => $production->unit_cost_production,
                'Precio Unitario de Venta' => $production->unit_price_sale,
                'Unidades Producidas' => $production->units_produced,
                'Importe' =>$import,
                'Cantidad unidades dañadas' =>0,
                'Importe unidades dañadas' =>0,
                'Cantidad unidades vendidas' =>0,
                'Importe unidades vendidas' =>0,
                'Total Utilidad'=>$import
            ];  
        }
        return $result;
    }
}
