<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'image'
    ];

    public function presentations()
    {
        return $this->belongsToMany(PresentationUnit::class,'presentation_unit_products',"presentation_unit_id","product_id")->withPivot('unit_cost_production','unit_price_sale')->withTimestamps();
    }

    public function ingredients()
    {
        return $this->belongsToMany(Material::class,'material_products',"material_id","product_id")->withPivot('quantity')->withTimestamps();
    }


    public static function searchProducts($value='',$month,$year){
        if (!$value) {
            return self::select('products.id',
                'products.name',
                'products.description',
                'products.image',
                'products.created_at')
                ->WhereMonth('products.created_at',$month)
                ->WhereYear('products.created_at',$year)
                ->paginate(12);
        }
        return self::select('products.id',
            'products.name',
            'products.description',
            'products.image',
            'products.created_at')
            ->where('products.name','like',"%$value%")
            ->paginate(12);
    }
}
