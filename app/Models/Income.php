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
        return $this->belongsToMany(Article::class,'article_incomes')->withPivot('quantity','unit_price','total_price')->withTimestamps();
    }

    public static function searchIncome($value='',$month){
        if (!$value) {
            return self::select('incomes.id',
            'incomes.receipt',
            'total')->WhereMonth('created_at',$month)->paginate(12);
        }   
        return self::select('incomes.id',
        'incomes.receipt',
        'total')->where('receipt','like',"%$value%")->paginate(12);
    }
}
