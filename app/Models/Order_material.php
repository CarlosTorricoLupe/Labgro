<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_material extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'article_id',
        'income_id',
        'quantity',
        'quantity_approved',
    ];
}
