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

  /*  public function ingredients()
    {
        return $this->belongsToMany(Material::class,'material_products',"material_id","product_id")->withPivot('quantity')->withTimestamps();
    }
*/
    public function materials()
    {
        return $this->belongsToMany(Material::class,'product_materials', 'product_id', 'material_id');
    }

}
