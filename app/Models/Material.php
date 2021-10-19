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
        return $this->belongsToMany(Order::class,'order_materials', 'material_id','order_id')->withTimestamps();;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'material_products', 'material_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }

    public function productions()
    {
        return $this->belongsToMany(Production::class,'material_production', 'material_id', 'production_id')->withPivot('quantity_required')->withTimestamps();
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

    public function scopeGetTypeMaterial($query, $name){
        return $query->join('articles','materials.article_id','articles.id')
            ->join('units','articles.unit_id','units.id')
            ->select('materials.*', 'articles.name_article','units.unit_measure')
            ->where('is_a', $name);
    }

    public function scopeGetTypeMaterialById($query, $id){
        return $query->join('articles','materials.article_id','articles.id')
            ->join('units','articles.unit_id','units.id')
            ->select('materials.*', 'articles.name_article','units.unit_measure')
            ->where('materials.id', $id);
    }
}
