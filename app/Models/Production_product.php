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
}
