<?php

namespace App\Http\Controllers;

use App\Models\PresentationUnit;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products=Product::searchProducts($request->value,$request->month,$request->year);
        if(count($products)){
            return $products;
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'No se encontraron resultados'
            ],404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response=array();
        $input = $request->all();
        if($request->hasFile('image')){
            $input['image'] = time() . '_' . $request->file('image')->getClientOriginalName();
            //$request->file('image')->storeAs('products', $input['image']);
            $request->image->move(public_path('products'), $input['image']);
        }

        $presentations=$request->get('presentations');
        $ingredients=$request->get('ingredients');

         if(isset($presentations)){
            if (isset($ingredients)) {
                $product=Product::create($input);
                $product->presentations()->sync($presentations);
                $product->ingredients()->sync($ingredients);
                $response['sucess'] = true;
                $response['message'] = "Producto creado correctamente";
            }else{
                $response['sucess'] = false;
                $response['error'] = "No se agregaron Ingredientes";
            }
        }else{
            $response['sucess'] = false;
            $response['error'] = "No se agregaron Presentaciones";
        }
        return response()->json([$response],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'success'=> true,
            'product' =>$product
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        if ($request->hasFile("image")) {
            $input['image'] = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('images'), $input['image']);
        }
        $product->update($input);
        return response()->json([
            'sucess' => true,
            'message' => 'Producto actualizado correctamente'
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
        Product::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Producto elimininado correctamente'
        ],200);
    }
}
