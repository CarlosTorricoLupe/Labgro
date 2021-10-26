<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePresentationUnit_productRequest;
use App\Models\PresentationUnit_product;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductPresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $presentations = PresentationUnit_product::getPresentations($id);
        if (count($presentations)) {
            return $presentations;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron resultados'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdatePresentationUnit_productRequest $request, $id)
    {
        $response = array();
        $product = Product::find($id);
        if (!$product->presentations->contains($request->presentation_unit_id)) {
            $product->presentations()->attach($request->presentation_unit_id, ['unit_cost_production' => $request->unit_cost_production, 'unit_price_sale' => $request->unit_price_sale]);
            $response['sucess'] = true;
            $response['message'] = "Presentacion agregada correctamente";
            $status=201;
        } else {
            $response['sucess'] = false;
            $response['error'] = "La unidad de presentacion ya existe";
            $status=400;
        }
        return response()->json($response,$status);
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
    public function update(UpdatePresentationUnit_productRequest $request, $product_id, $presentation_unit_id)
    {
        $pres = PresentationUnit_product::where('product_id', $product_id)
            ->where('presentation_unit_id', $presentation_unit_id)->get();
        if ($pres[0]->created_at->isCurrentMonth()) {
            foreach($pres as $pre){
                $pre['unit_cost_production']=$request->unit_cost_production;
                $pre['unit_price_sale']=$request->unit_price_sale;
                $pre->saveOrFail();
            }
        } else {
            $product = Product::find($product_id);
            $product->presentations()->attach($request->presentation_unit_id, ['unit_cost_production' => $request->unit_cost_production, 'unit_price_sale' => $request->unit_price_sale]);
        }
        return response()->json([
            'sucess' => true,
            'message' => 'Se actualizo correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $presentation_unit_id)
    {
        PresentationUnit_product::where('product_id', $product_id)
            ->where('presentation_unit_id', $presentation_unit_id)
            ->delete();
        return response()->json([
            'sucess' => true,
            'message' => 'Se elimino correctamente'
        ], 200);
    }
}
