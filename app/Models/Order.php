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
        'role_id',
        'created_at',
        'view_order',
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class,'order_materials', 'order_id', 'material_id')->withPivot('quantity')->withTimestamps();
    }
    public function outputs(){
        return $this->belongsToMany(Output::class,'orders_outputs', 'order_id', 'output_id')->withTimestamps();
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
    public function scopeGetTypeStatus($query, $value, $month, $year){
        $query->join('sections','orders.section_id','sections.id')
            ->select('sections.name as section_name', 'orders.id', 'orders.id', 'orders.id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation')
            ->where('status', $value);
        if(isset($month)){
            $query->WhereMonth('orders.created_at', $month);
        }
        if(isset($year)){
            $query->WhereYear('orders.created_at', $year);
        }
        return $query->orderBy('orders.created_at', 'desc');
    }

    public function scopeGetOrderById($query, $id){
        return $query->join('sections','orders.section_id','sections.id')
            ->select('sections.id as section_id','sections.name as section_name', 'orders.id as order_id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation')
            ->where('orders.id', $id);
    }

    public function scopeReprobate($query, $id_order, $value){
        return $query->where('id', $id_order)
            ->update(['status'=>'reprobate',
                      'observation' => $value,
                      'view_order' => 'false']);
    }

    public function scopeApproved($query, $id_order){
        return $query->where('id', $id_order)
            ->update(['status'=>'approved',
                'view_order' => 'false']);
    }

    public function scopeGetQuantityNotifications($query){
        return $query->join('sections','orders.section_id','sections.id')
            ->select('sections.id as section_id','sections.name as section_name', 'orders.id as order_id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation', 'orders.observation', 'orders.viewed_general', 'orders.viewed_order')
            ->where('orders.role_id',auth()->user()->role_id)
            ->where('orders.view_order', 'false');

    }
    public function scopeGetNotifications($query){
        return $query->join('sections','orders.section_id','sections.id')
            ->select('sections.id as section_id','sections.name as section_name', 'orders.id as order_id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation', 'orders.observation', 'orders.view_order')
            ->where('orders.role_id',auth()->user()->role_id)
            ->orderByRaw("case orders.view_order when 'true' then 1 when 'false' then 2 end")
            ->orderBy('orders.updated_at', 'desc');
    }
    public function scopeViewedAllGeneral($query){
        return $query->where('role_id',auth()->user()->role_id)
            ->update(['view_order'=>'true']);
    }
}
