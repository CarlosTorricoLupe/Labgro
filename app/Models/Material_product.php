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

    public static function getDetailMaterial($product_id){
        return self::join('materials', 'material_products.material_id','materials.id')
            ->join('articles','materials.article_id','articles.id')
            ->join('units','articles.unit_id', 'units.id')
            ->where('material_products.product_id',$product_id)
            ->select('articles.name_article','material_products.quantity','units.unit_measure', 'materials.is_a', 'material_products.created_at')
            ->get();
    }
}
