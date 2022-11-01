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
        'image',
        'role_id',
        'unit_id'
    ];

    public function presentations()
    {
        return $this->belongsToMany(PresentationUnit::class,'presentation_unit_products')->withPivot('unit_cost_production','unit_price_sale')->withTimestamps();
    }

    public function ingredients()
    {
        return $this->belongsToMany(Material::class,'material_products')->withPivot('quantity')->withTimestamps();
    }

    public function productions()
    {
        return $this->belongsToMany(Production::class,'production_products')->withPivot('quantity')->withTimestamps();
    }

    public function units(){
        return $this->belongsToMany(Unit::class);
    }

    public static function searchProducts($value='',$month,$year){
        if (!$value && !$month && !$year) {
            return self::join('units','products.unit_id','units.id')
            ->select('products.id',
                'products.name',
                'products.code',
                'products.description',
                'products.image',
                'products.created_at',
                'unit_id',
                'unit_measure')
                ->Where('role_id',auth()->user()->role_id)
                ->get();
        }
        if (!$value) {
            return self::select('products.id',
                'products.name',
                'products.code',
                'products.description',
                'products.image',
                'products.created_at')
                ->WhereMonth('products.created_at',$month)
                ->WhereYear('products.created_at',$year)
                ->Where('role_id',auth()->user()->role_id)
                ->get();
        }
        return self::select('products.id',
            'products.name',
            'products.description',
            'products.image',
            'products.created_at')
            ->where('products.name','like',"%$value%")
            ->Where('role_id',auth()->user()->role_id)
            ->get();
    }

    public function scopeGetContainMaterialId($query, $material_id){

        return $query->join('material_products','material_products.product_id','products.id')
                ->join('materials', 'material_products.material_id', 'materials.id')
                ->join('articles', 'materials.article_id', 'articles.id')

            ->select('products.id as product_id' ,'products.code', 'products.name')
            ->where('material_products.material_id', $material_id);
    }

    public static function showProduct($id){
        return self::join('units','products.unit_id','units.id')
        ->select('products.id',
                'products.name',
                'products.code',
                'products.description',
                'products.image',
                'products.created_at',
                'unit_id',
                'unit_measure')
                ->Where('role_id',auth()->user()->role_id)
                ->where('products.id',$id)
                ->get();
        
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($product) { // before delete() method call this
            $product->presentations()->detach();
            $product->ingredients()->detach();
        });
    }
}
