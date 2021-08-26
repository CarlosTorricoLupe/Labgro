<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'stock_start',
        'stock_min',
        'color',
        'article_id',
        'is_a'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_materials', 'material_id','order_id');
    }
}
