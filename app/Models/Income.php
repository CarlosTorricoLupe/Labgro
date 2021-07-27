<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => "datetime:Y-m-d",
    ];

    protected $fillable =[
        'receipt',
        'order_number',
        'provider',
        'total',
        'user_id',
        'created_at'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class,'article_incomes',"income_id","article_id")->withPivot('quantity','unit_price','total_price')->withTimestamps();
    }

    public static function searchIncome($value='',$month,$year){
        if (!$value) {
            return self::select('incomes.id',
            'incomes.receipt','incomes.order_number','provider',
            'total','created_at')->WhereMonth('created_at',$month)->WhereYear('created_at',$year)->paginate(12);
        }   
        return self::select('incomes.id',
        'incomes.receipt','incomes.order_number','provider',
        'total','created_at')->where('receipt','like',"%$value%")->paginate(12);
    }

    public static function getIncome($id){
        return self::select('incomes.receipt','incomes.order_number','provider',
        'total')->where('incomes.id',$id)->get();
    }

    public static function getDetails($id){
        return self::join('articles','article_incomes.article_id','articles.id')->join('units','articles.unit_id',"units.id")
        ->select('article_incomes.quantity','article_incomes.unit_price','article_incomes.total_price', 'articles.name_article','unit_measure')
        ->where('article_incomes.income_id', '=', $id)
        ->get();
    }
}
