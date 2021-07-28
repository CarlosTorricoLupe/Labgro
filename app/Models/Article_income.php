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
    public function kardex(){
        return $this->hasMany(Kardex::class);
    }

    public static function getDetails($id){
        return self::join('articles','article_incomes.article_id','articles.id')->join('units','articles.unit_id',"units.id")
        ->select('article_incomes.article_id','article_incomes.quantity','article_incomes.unit_price','article_incomes.total_price', 'articles.name_article','unit_measure','article_incomes.income_id')
        ->where('article_incomes.income_id', '=', $id)
        ->get();
    }

}
