<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material_production_product extends Model
{
    use HasFactory;

    protected $table = 'material_production_product';

    protected $fillable=[
        'quantity_required'
    ];

    public static function getMaterialsByProduction($pr)
    {
        return self::join('materials', 'material_production_product.material_id','materials.id')
                ->join('articles','materials.article_id','articles.id')
                ->join('units','articles.unit_id', 'units.id')    
                ->select('materials.id','articles.name_article','units.unit_measure','material_production_product.quantity_required')
                ->where('production_product_id',$pr)
                ->get();
        }
}
