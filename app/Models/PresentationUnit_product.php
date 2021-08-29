<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationUnit_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_cost_production',
        'unit_price_sale',
    ];
}
