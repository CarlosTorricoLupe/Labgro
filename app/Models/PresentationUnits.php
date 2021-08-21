<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationUnits extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit_cost_production',
        'unit_price_sale',
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
