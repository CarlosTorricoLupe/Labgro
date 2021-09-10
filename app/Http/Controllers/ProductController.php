<?php

namespace App\Http\Controllers;

use App\Models\Material_product;
use App\Models\PresentationUnit;
use App\Models\PresentationUnit_product;
use Illuminate\Http\Request;
use App\Models\Product;
use Image;
use File;

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
        $input['role_id'] = auth()->user()->role_id;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $this->uploadImage($image);
            $input['image'] = time().'_'.$image->getClientOriginalName();
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

    public function uploadImage($request_image){
        $image = Image::make($request_image);

        $path = public_path('products/');

        if (!File::exists($path)) {
            File::makeDirectory($path);
        }
        $image_name= time().'_'.$request_image->getClientOriginalName();

        $image->resize(null, 500, function($constraint) {
            $constraint->aspectRatio();
        });

        $image->save($path.$image_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $presentations=PresentationUnit_product::getPresentations($product->id);
        $materials=Material_product::getDetailMaterial($product->id);
        return response()->json([
            'success'=> true,
            'product' => $product,
            'presentations' => $presentations,
            'materials' => $materials
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
        $input['role_id']=auth()->user()->role_id;
        if ($request->hasFile("image")) {
            $image = $request->file('image');
            $this->uploadImage($image);
            $input['image'] = time().'_'.$image->getClientOriginalName();
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
