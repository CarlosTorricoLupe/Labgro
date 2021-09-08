<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'stock_start',
        'stock_min',
        'color',
        'article_id',
        'is_a'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_materials', 'material_id','order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'material_products', 'material_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }

    public function scopeUpdateCategoryMaterial($query, $material, $article_id){
        $category = Article::join('categories','articles.category_id','categories.id')
                    ->where('articles.id',$article_id)
                    ->select('categories.name')
                    ->get();

        $name = $category[0]->name;

        if ($name == "Materia Prima"){
            $material->is_a = "raw_material";
        }else{
            $material->is_a = "supplies";
        }
        $material->save();

    }
}
