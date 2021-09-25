<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_production'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,'production_products')->withPivot('quantity')->withTimestamps();
    }

    public static function indexProductionsByMonth($month,$year){
        return self::join('production_products','productions.id','production_products.id')
                    ->join('products','production_products.product_id','products.id')->select('products.name','production_products.quantity','productions.date_production')->WhereMonth('created_at',$month)->WhereYear('created_at',$year)->paginate(12);
    }
}
