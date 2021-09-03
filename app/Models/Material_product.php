<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_product extends Model
{
    use HasFactory;

    protected $fillable=[
        'quantity',
        'material_id',
        'product_id'
    ];

    public static function getMaterials($id){
        return self::join('products','material_products.product_id','products.id')
        ->join('materials','material_products.material_id','materials.id')
        ->join('articles','materials.article_id','articles.id')
        ->select('articles.name_article','material_products.quantity')
        ->where('material_products.product_id',$id)
        ->get();
    }
}
