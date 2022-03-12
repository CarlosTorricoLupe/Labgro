<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation_production_product extends Model
{
    use HasFactory;

    protected $table = 'presentation_production_product';

    protected $fillable = [
        'quantity',
        'unit_cost_production',
        'unit_price_sale',
        'production_product_id',
        'role_id',
        'presentation_unit_id',
        'faulty_quantity'
    ];

    public static function getPresentationByProductOfProduction($pr){
        return self::join('presentation_units', 'presentation_production_product.presentation_unit_id','presentation_units.id')
                ->select('presentation_units.id','presentation_units.name','presentation_production_product.quantity','presentation_production_product.unit_cost_production','presentation_production_product.unit_price_sale')
                ->where('production_product_id',$pr)
                ->get();
    }

}
