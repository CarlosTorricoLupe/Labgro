<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_production'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,'production_products')->withPivot('quantity')->withTimestamps();
    }

    public static function indexProductsByProduction($production_id){
        return self::join('production_products','productions.id','production_products.production_id')
                    ->join('products','production_products.product_id','products.id')->select('products.name','production_products.quantity','productions.date_production')->where('production_products.production_id',$production_id)->paginate(12);
    }
    public static function getProductsContainMaterialId($material_id){
        return self::join('production_products','productions.id','production_products.production_id')
            ->join('products','production_products.product_id','products.id')
            ->join('material_products','products.id','material_products.product_id')
            ->select('productions.id as production_id','products.id as product_id','products.name',  'production_products.quantity','material_products.quantity as quantity_required' ,'productions.created_at')
            ->where('material_products.material_id', $material_id)
            ->get();
    }
}
