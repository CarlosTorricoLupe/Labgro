<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'receipt',
        'order_number',
        'order_date',
        'delivery_date'
    ];

    public function articles(){
        return $this->belongsToMany(Article::class, "output_details", "output_id", "article_id");
    }

}
