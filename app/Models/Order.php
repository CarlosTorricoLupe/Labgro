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
                'materials.article_id',
                'order_materials.material_id',
                'order_materials.quantity as quantity_order',
                'articles.stock_total as quantity_article',
                'materials.stock_start as quantity_materials',
                'articles.name_article',
                'materials.article_id',
                'units.unit_measure'
            )
            ->where('order_materials.order_id',$id)
            ->get();
    }
    public function scopeGetTypeStatus($query, $value){
        return $query->join('sections','orders.section_id','sections.id')
            ->select('sections.name as section_name', 'orders.id', 'orders.id', 'orders.id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation')
            ->where('status', $value)
            ->orderBy('orders.created_at', 'desc');
    }

    public function scopeGetOrderById($query, $id){
        return $query->join('sections','orders.section_id','sections.id')
            ->select('sections.name as section_name', 'orders.id', 'orders.id', 'orders.id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation')
            ->where('orders.id', $id);
    }
}
