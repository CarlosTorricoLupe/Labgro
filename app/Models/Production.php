<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_production',
        'role_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,'production_products')->withPivot('quantity')->withTimestamps();
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class,'material_production')->withPivot('quantity_required')->withTimestamps();
    }

    public static function indexProductsByProduction($production_id){
        return self::join('production_products','productions.id','production_products.production_id')
                    ->join('products','production_products.product_id','products.id')->select('products.id','products.name','production_products.quantity','productions.date_production','products.code','products.image')->where('production_products.production_id',$production_id)->get();
    }
    public static function getProductsContainMaterialId($material_id, $year){
        return self::join('material_production_product','material_production_product.production_product_id','productions.id')
            ->select('productions.id as production_id',
                'material_production_product.quantity_required',
                'material_production_product.control',
                'productions.created_at')
            ->where('material_production_product.material_id', $material_id)
            ->whereYear('productions.created_at', $year)
            ->get();
    }

    public static function getProductsProducedByMonth($month, $year){
        return DB::table('presentation_production_product')
            ->join('presentation_units','presentation_units.id','presentation_production_product.presentation_unit_id')
            ->join('production_products','production_products.id','presentation_production_product.production_product_id')
            ->join('productions','productions.id','production_products.production_id')
            ->join('products','products.id','production_products.product_id')
            ->whereMonth('productions.created_at','=',$month)
            ->whereYear('productions.created_at',$year)
            ->where('productions.role_id',auth()->user()->role_id)
            ->select('presentation_production_product.presentation_unit_id as presentations',
                'products.name as product_name',
                'presentation_units.name as presentation_name',
                DB::raw('SUM(presentation_production_product.quantity) as units_produced'),
                'presentation_production_product.unit_cost_production as unit_cost_production',
                'presentation_production_product.unit_price_sale as unit_price_sale',
            )
           ->groupBy('presentations','presentation_name','product_name','unit_cost_production','unit_price_sale')
           ->get();
    }

    public static function getProductionsById($id_product, $year){
        return self::join('production_products', 'productions.id', 'production_products.production_id')
                ->where('production_products.product_id', $id_product)
                ->whereYear('productions.created_at', $year)
                ->select('productions.created_at', 'production_products.quantity' )
                ->get();
    }
}
