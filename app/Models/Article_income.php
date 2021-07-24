<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_income extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'unit_price',
        'total_price',
        'income_id',
        'article_id'
    ];

}
