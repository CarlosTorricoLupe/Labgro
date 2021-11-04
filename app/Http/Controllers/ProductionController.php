<?php

namespace App\Http\Controllers;

use App\Models\Presentation_production_product;
use App\Models\Production;
use App\Models\Production_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\RequestInterface;

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
        $production=Production::create($data);
        return response()->json([
            'sucess' =>true,
            'message' =>'Produccion creada correctamente',
            'production'=>$production,
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

    public function updateQuantityUsedInProduction(Request $request){
        $response=array();
        $productions=Production::whereDate('date_production',$request->date)->where('role_id', auth()->user()->role_id)->first();
        if ($productions) {
            $productions->quantity_used=$request->quantity;
            $productions->saveOrFail();
            $response['sucess'] = true;
            $response['message'] = "Cantidad actualizada correctamente";
        }else{
            $response['sucess'] = false;
            $response['message'] = "No se encontraron resultados para la fecha";
        }
        return response()->json($response, 201);
    }

    public function getConsolidate(Request $request){
     $productions=Production::getProductsProducedByMonthGroupedPresentation($request->month,$request->year);
     $result = array();
        foreach ($productions as $production){
            $import =  $production->units_produced*$production->unit_cost_production;
            $result[] = [
                'Codigo' => $production->product_code,
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
                'Total_Utilidad'=>0-$import
            ];
        }
        return $result;
    }


    public function getDetailProduction(Request $request){
        $pr=Production::whereMonth('productions.created_at','=',$request->month)
        ->whereYear('productions.created_at',$request->year)
        ->where('productions.role_id',auth()->user()->role_id)->get(['id','quantity_used']);
        foreach($pr as $p){
            $result = array();
            $presentations=Production::getProductsByProduction($p->id);
            foreach($presentations as $presentation){
                $import =  $presentation->units_produced*$presentation->unit_cost_production;
                $result[]=[
                    'Fecha produccion' => $presentation->date_production,
                    'Cantidad Usada' => 0,
                    'Codigo' => $presentation->production_code,
                    'Produccion Estandar' => $presentation->name_product,
                    'Unidad/Presentacion' => $presentation->presentation_name,
                    'Costo_unitario' => $presentation->unit_cost_production,
                    'Cantidad' => $presentation->units_produced,
                    'Importe' =>$import,
                    'Cantidad_unidades_defectuosos' =>0,
                    'Importe_unidades_defectuosos' =>0,
                    'Cantidad_efectivamente_producido' =>$presentation->units_produced,
                    'Importe_efectivamente_producido' =>$import
                ];
            }
            $p->presentation=$result;
        }
        return $pr;
       }

       public function getSummaryProduction(Request $request){
        $productions=Production::getProductsProducedByMonthGroupedPresentation($request->month,$request->year);
        $result = array();
        foreach ($productions as $production){
            $import =  $production->units_produced*$production->unit_cost_production;
            $result[] = [
                'Codigo' => $production->product_code,
                'Producto' => $production->product_name,
                'Unidad_Presentacion' => $production->presentation_name,
                'Costo_Unitario_Produccion' => $production->unit_cost_production,
                'Unidades_Producidas' => $production->units_produced,
                'Importe' =>$import,
                'Cantidad_unidades_defectuosas' =>0,
                'Importe_unidades_defectuosas' =>0,
                'Cantidad_total_produccion_efectiva_' =>$production->units_produced,
                'Importe_total_produccion_efectiva' =>$import,
            ];
        }
        return $result;   
        
       }
}
