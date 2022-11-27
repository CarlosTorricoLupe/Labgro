<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;



    protected $fillable =[
        'receipt',
        'order_number',
        'provider',
        'total',
        'user_id',
        'created_at',
        'invoice_number',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class,'article_incomes',"income_id","article_id")->withPivot('quantity','unit_price','total_price')->withTimestamps();
    }

    public function scopeSearchIncome($query, $monthone, $monthtwo,  $year){
        $query->join('article_incomes','article_incomes.income_id','incomes.id')
            -> join('articles','article_incomes.article_id','articles.id');

        if(isset($monthone) && isset($monthtwo)){
            $query->WhereMonth('incomes.created_at', '>=',  $monthone)
                ->WhereMonth('incomes.created_at', '<=', $monthtwo);
        }

        if(isset($year)){
            $query->WhereYear('incomes.created_at',$year);
        }
        return $query->select('incomes.id', 'incomes.receipt', 'incomes.order_number', 'incomes.provider', 'incomes.total', 'incomes.invoice_number', 'incomes.created_at')->distinct();
    }

    public function scopeFilterValue($query, $value){
        if(isset($value)){
            $query->Where('incomes.receipt','like',"%$value%")
                ->orWhere('articles.name_article','like',"%$value%");
        }
        return $query;
    }

    public static function getIncome($id){
        return self::select('incomes.receipt','incomes.order_number','provider',
        'total','invoice_number','created_at')->where('incomes.id',$id)->get();
    }

    public static function getDetails($id){
        return self::join('articles','article_incomes.article_id','articles.id')->join('units','articles.unit_id',"units.id")
        ->select('article_incomes.quantity','article_incomes.unit_price','article_incomes.total_price', 'articles.name_article','unit_measure')
        ->where('article_incomes.income_id', '=', $id)
        ->get();
    }
    public static function searchArticleByDate($id,$month=0,$monthtwo=0,$year=0){

        if($month == 0 && $monthtwo == 0 && $year == 0 ){
            return self::join('article_incomes','article_incomes.income_id','incomes.id')
                -> join('articles','article_incomes.article_id','articles.id')
                ->select('article_incomes.total_price',
                    'articles.name_article',
                    'incomes.invoice_number',
                    'article_incomes.unit_price',
                    'article_incomes.total_price',
                    'incomes.created_at',
                    'article_incomes.quantity',
                    'incomes.invoice_number',
                    'incomes.receipt',
                    'incomes.id'
                )
                ->where('article_incomes.article_id',$id)
                ->get();
        }else{
            return self::join('article_incomes','article_incomes.income_id','incomes.id')
                -> join('articles','article_incomes.article_id','articles.id')
                ->select('article_incomes.total_price',
                    'articles.name_article',
                    'incomes.invoice_number',
                    'article_incomes.unit_price',
                    'article_incomes.total_price',
                    'incomes.created_at',
                    'article_incomes.quantity',
                    'incomes.invoice_number',
                    'incomes.receipt',
                    'incomes.id'
                )
                ->where('article_incomes.article_id',$id)
                ->WhereMonth('incomes.created_at', '>=',  $month)
                ->WhereMonth('incomes.created_at', '<=', $monthtwo)
                ->WhereYear('incomes.created_at', $year)
                ->get();
        }
    }
}
