<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationUnit_product extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => "datetime:Y-m-d",
    ];

    protected $fillable = [
        'unit_cost_production',
        'unit_price_sale',
        'presentation_unit_id',
        'product_id'
    ];

    public static function getPresentations($id){
        return self::join('products','presentation_unit_products.product_id','products.id')
        ->join('presentation_units','presentation_unit_products.presentation_unit_id','presentation_units.id')->select('presentation_units.id','presentation_units.name','presentation_unit_products.unit_cost_production','presentation_unit_products.unit_price_sale')
        ->where('presentation_unit_products.product_id',$id)
        ->get();
    }

    public static function getProducts($id){
        return self::join('products','presentation_unit_products.product_id','products.id')
        ->join('presentation_units','presentation_unit_products.presentation_unit_id','presentation_units.id')->select('products.name')
        ->where('presentation_unit_products.presentation_unit_id',$id)
        ->get();
    }
}
