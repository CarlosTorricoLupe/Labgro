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
        'delivery_date',
        'total'
    ];

    public function articles(){
        return $this->belongsToMany(Article::class, "output_details", "output_id", "article_id")
                    ->withTimestamps();;
    }

    public static function searchOutput($value='',$month,$year){
        if (!$value) {
            return self::join('sections','outputs.section_id','sections.id')
                        ->WhereMonth('order_date',$month)
                        ->WhereYear('order_date',$year)
                        ->select('outputs.*', 'sections.name')
                        ->paginate(12);
        }
        return self::join('sections','outputs.section_id','sections.id')
                ->where('receipt','like',"%$value%")
                ->select('outputs.*', 'sections.name')
                ->paginate(12);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($output) { // before delete() method call this
            $output->articles()->detach();
        });
    }

}
