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
        return $this->belongsToMany(Material::class,'order_materials', 'order_id', 'material_id')->withPivot('quantity','quantity_approved')->withTimestamps();
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
            ->select(
                'order_materials.id as pivot_id',
                'order_materials.order_id',
                'materials.article_id',
                'order_materials.material_id',
                'order_materials.quantity as quantity_order',
                'articles.stock_total as quantity_article',
                'materials.stock_start as quantity_materials',
                'articles.name_article',
                'materials.article_id',
                'units.unit_measure',
                'order_materials.quantity_approved',
            )
            ->where('order_materials.order_id',$id)
            ->get();
    }
    public function scopeGetTypeStatus($query, $value, $monthone, $monthtwo, $year, $section){
        $query->join('sections','orders.section_id','sections.id')
            ->select('sections.name as section_name', 'orders.id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation')
            ->where('status', $value);
        if(isset($monthone) && isset($monthtwo)){
            $query->WhereMonth('orders.created_at', '>=',  $monthone)
                ->WhereMonth('orders.created_at', '<=', $monthtwo);
        }
        if(isset($year)){
            $query->WhereYear('orders.created_at', $year);
        }
        if (isset($section)){
            $query->Where('sections.name','like',"%$section%");
        }
        return $query->orderBy('orders.created_at', 'desc');
    }

    public function scopeUpdatePivot($query, $id_pivot, $quantity){
        return $query->join('order_materials', 'order_materials.order_id','orders.id')
            ->where('order_materials.id',$id_pivot)
            ->update([
                'order_materials.quantity_approved' => $quantity,
            ]);
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
            ->select('sections.id as section_id','sections.name as section_name', 'orders.id as order_id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation', 'orders.observation', 'orders.viewed_order')
            ->where('orders.role_id',auth()->user()->role_id)
            ->where('orders.view_order', 'false');

    }

    public function scopeGetNotifications($query){
        return $query->join('sections','orders.section_id','sections.id')
            ->select('sections.id as section_id','sections.name as section_name', 'orders.id as order_id', 'orders.receipt', 'orders.order_number', 'orders.date_issue as order_date', 'orders.status', 'orders.created_at', 'orders.observation',  'orders.view_order')
            ->where('orders.role_id',auth()->user()->role_id)
            ->orderByRaw("case orders.view_order when 'true' then 1 when 'false' then 2 end")
            ->orderBy('orders.updated_at', 'desc');
    }

    public function scopeGetMaterials($query, $order_id){
        return $query->join('order_materials', 'order_materials.order_id','orders.id')
            ->join('materials','order_materials.material_id','materials.id')
            ->join('articles','materials.article_id','articles.id')
            ->select('articles.name_article','order_materials.quantity', 'order_materials.quantity_approved')
            ->where('orders.id', $order_id);
    }

    public function scopeViewedAllGeneral($query){
        return $query->where('role_id',auth()->user()->role_id)
            ->update(['view_order'=>'true']);
    }
}
