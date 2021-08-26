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
    ];

    public function materials()
    {
        return $this->belongsToMany(Material::class,'order_materials', 'order_id', 'material_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($order) { // before delete() method call this
            $order->articles()->detach();
        });
    }

    public function scopeGetOrder($query, $id){
        return $query
            ->select(   'id',
                        'receipt',
                        'order_number',
                        'date_issue',
                        'is_approved',
                        'section_id',
                        'created_at')
            ->where('id',$id);
    }


}
