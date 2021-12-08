<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'product_id',
        'production_id'
    ];

    public function materiales()
    {
        return $this->belongsToMany(Material::class,'material_production_product')->withPivot('quantity_required')->withTimestamps();
    }

    public function presentations(){
        return $this->belongsToMany(PresentationUnit::class,'presentation_production_product','production_product_id','presentation_unit_id')->withPivot('quantity','unit_cost_production','unit_price_sale')->withTimestamps();
    }

    public function scopeGetProductionByDate($query, $month, $year){
        $query->join('productions','production_products.production_id','productions.id')->join('material_production_product', 'material_production_product.production_product_id', 'production_products.id');
        $query->where('productions.role_id',auth()->user()->role_id);
        if(isset($month)){
            $query->WhereMonth('productions.date_production',$month);
        }
        if(isset($year)) {
            $query->WhereYear('productions.date_production', $year);
        }
        return $query->select('production_products.quantity as quantity_production','material_production_product.material_id' ,'material_production_product.quantity_required as quantity_material');
    }
}
