<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => "datetime:Y-m-d",
    ];

    protected $fillable = [
        'id',
        'receipt',
        'order_number',
        'date_issue',
        'is_approved',
        'section_id',
        'role_id'
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class,'order_materials', 'order_id', 'material_id')->withPivot('quantity')->withTimestamps();
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($order) { // before delete() method call this
            $order->materials()->detach();
        });
    }

    public static function getOrder($id){
        return self::select(
                        'id',
                        'receipt',
                        'order_number',
                        'date_issue',
                        'is_approved',
                        'section_id',
                        'created_at')
            ->where('id',$id)
            ->get();
    }

    public static function getDetails($id){
        return self::
            join('order_materials', 'order_materials.order_id','orders.id')
            ->join('materials','order_materials.material_id','materials.id')
            ->join('articles','materials.article_id','articles.id')
            ->join('units','articles.unit_id', 'units.id')
            ->select('order_materials.order_id',
                'order_materials.material_id',
                'order_materials.quantity',
                'materials.code',
                'materials.color',
                'materials.is_a',
                'materials.article_id',
                'articles.name_article',
                'materials.article_id',
                'units.unit_measure'
            )
            ->where('order_materials.order_id',$id)
            ->get();
    }

    public static function getIncomesAllOrders($id){
        return self::
        join('order_materials', 'order_materials.order_id','orders.id')
            ->join('materials','order_materials.material_id','materials.id')
            ->join('articles','materials.article_id','articles.id')
            ->join('units','articles.unit_id', 'units.id')
            ->select('orders.id as id_order','articles.name_article','orders.updated_at as date_of_admission', 'order_materials.quantity', 'units.unit_measure' )
            ->where('order_materials.material_id', $id)
            ->where('orders.is_approved', 1)
            ->where('role_id', auth()->user()->role_id)
            ->orderBy('orders.updated_at', 'desc')
            ->get();
    }
}
