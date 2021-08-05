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
        'stock' => 'integer',
        'stock_min' => 'integer'

    ];

    protected $fillable = [
        'id',
        'cod_article',
        'name_article',
        'stock',
        'unit_price',
        'category_id',
        'unit_id',
        'created_at',
        'stock_min'
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

    public function incomes()
    {
        return $this->belongsToMany(Income::class,'article_incomes')->withPivot('quantity','unit_price','total_price')->withTimestamps();
    }
    public function outputs(){
        return $this->belongsToMany(Output::class, "output_details", "article_id", "output_id")
                    ->withTimestamps();;
    }

    //scopes
    public function scopeArticlesWithoutStock($query)
    {
        return $query->join('categories','articles.category_id','=',"categories.id")
            ->join('units','articles.unit_id','=',"units.id")
            ->whereRaw('articles.stock <= articles.stock_min')

            ->select('articles.name_article')
//            ->select('articles.*','categories.name', 'units.unit_measure','units.kind')

            ->get();
    }

    public function scopeArticlesWithStock($query)
    {
        return $query->join('categories','articles.category_id','=',"categories.id")
            ->join('units','articles.unit_id','=',"units.id")
            ->whereRaw('articles.stock > articles.stock_min')
            ->select('articles.name_article')
       //     ->select('articles.*','categories.name', 'units.unit_measure','units.kind')

            ->get();
    }
}
