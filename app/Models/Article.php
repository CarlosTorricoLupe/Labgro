<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
   protected $table = 'articles';

    protected $fillable = [
        'name_article',
        'stock',
        'category_id',
        'unit_id'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function units(){
        return $this->belongsToMany(Unit::class);
    }
}
