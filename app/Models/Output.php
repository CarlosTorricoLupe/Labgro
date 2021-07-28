<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'receipt',
        'order_number',
        'order_date',
        'delivery_date'
    ];

    public function articles(){
        return $this->belongsToMany(Article::class, "output_details", "output_id", "article_id");
    }

    public static function searchOutput($value='',$month,$year){
        if (!$value) {
            return self::select('outputs.*')
                        ->WhereMonth('created_at',$month)
                        ->WhereYear('created_at',$year)->paginate(12);
        }
        return self::select('outputs.*')
                ->where('receipt','like',"%$value%")->paginate(12);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($output) { // before delete() method call this
            $output->articles()->detach();
        });
    }

}
