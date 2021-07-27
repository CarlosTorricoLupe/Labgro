<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;
    protected $table = 'kardexes';

    protected $casts = [
        'created_at' => "datetime:Y-m-d",
    ];
    protected $fillable = [
        'id',   
    ];
    protected $hidden = [
        'updated_at',
        'created_at',
        'article_income_id',
        'output_detail_id',
    ];

    public function article_income(){
        return $this->belongsToMany(Article_income::class);
    }
    public function output(){
        return $this->belongsToMany(Output::class);
    }
    public function article(){
        return $this->belongsToMany(Article::class);
    }

}
