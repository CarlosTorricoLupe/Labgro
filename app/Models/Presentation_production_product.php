<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presentation_production_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'unit_cost_production',
        'unit_price_sale'
    ];


}
