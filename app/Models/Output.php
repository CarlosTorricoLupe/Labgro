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
    public static function getOutput($id){
        return self::select('outputs.*')->where('outputs.id',$id)->get();
    }

    public static function getOutputsByArticle($id){
        return self::join('output_details','output_details.output_id','outputs.id')
            ->join('articles','output_details.article_id','articles.id')
            ->select('outputs.section_id',
                'outputs.section_id',
                'outputs.receipt',
                'outputs.order_number',
                'outputs.order_date',
                'outputs.delivery_date',
                'outputs.total',
                'output_details.article_id',
                'articles.name_article',
                'output_details.quantity',
                'output_details.budget_output',
                'output_details.total as price_total'
            )
            ->where('output_details.article_id',$id)
            ->paginate(12);

    }

    public static function boot() {
        parent::boot();

        static::deleting(function($output) { // before delete() method call this
            $output->articles()->detach();
        });
    }
}
