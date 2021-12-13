<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_production extends Model
{
    use HasFactory;

    protected $fillable=[
        'quantity_required',
        'role_id',
        'control',
        'material_id',
        'production_product_id'
    ];


}
