<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;


    protected $table = 'articles';

    protected $casts = [
        'created_at' => "datetime:Y-m-d",
    ];
    protected $fillable = [
        'id',
        'cod_article',
        'name_article',
        'stock',
        'category_id',
        'unit_id',
        'created_at'
    ];
    protected $hidden = [
        'updated_at',
    ];

    public function categories(){
        return $this->belongsToMany(Category::class,'category_id');
    }

    public function units(){
        return $this->belongsToMany(Unit::class);
    }

    public function outputs(){
        return $this->belongsToMany(Output::class, "output_details");
    }

}
