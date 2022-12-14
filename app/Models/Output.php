<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Output extends Model
{
    use HasFactory;

    protected $casts = [
        'delivery_date' => "datetime:Y-m-d",
    ];
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
                    ->withPivot('quantity','budget_output','total','balance_stock','balance_price')
                    ->withTimestamps();;
    }

    public function orders(){
        return $this->belongsToMany(Order::class,'orders_outputs', 'output_id', 'order_id')->withTimestamps();
    }
    public function scopeSearchOutput($query, $monthone, $monthtwo, $year){
        $query->join('output_details','outputs.id','output_details.output_id')
            ->join('articles','output_details.article_id','articles.id')
            ->join('sections','outputs.section_id','sections.id');
        if(isset($monthone) && isset($monthtwo)){
            $query->WhereMonth('order_date', '>=',  $monthone)
                ->WhereMonth('order_date', '<=', $monthtwo);
        }

        if(isset($year)){
            $query->WhereYear('order_date',$year);
        }
        return $query->select('outputs.*', 'sections.name');
    }

    public function scopeFilterValue($query, $value){
        if(isset($value)){
            $query->where('outputs.receipt','like',"%$value%")
                ->orWhere('sections.name','like',"%$value%")
                ->orWhere('articles.name_article','like',"%$value%");
        }
        return $query;
    }

    public static function getOutput($id){
        return self::select('outputs.*')->where('outputs.id',$id)->get();
    }

    public static function getOutputsByArticle($id, $year, $month, $role_id){
        return self::join('output_details','output_details.output_id','outputs.id')
            ->join('articles','output_details.article_id','articles.id')
           // ->join('orders_outputs', 'orders_outputs.output_id', 'outputs.id')
            //->join('orders', 'orders_outputs.order_id', 'orders.id')
            ->select('outputs.section_id',
                'outputs.id as output_id',
                'outputs.receipt',
                'outputs.order_number',
                'outputs.order_date',
                'outputs.delivery_date',
                'outputs.total',
                'outputs.created_at',
                'output_details.article_id',
                'articles.name_article',
                'output_details.quantity',
                'output_details.budget_output',
                'output_details.total as price_total'
            )
            //->where('orders.role_id', $role_id)
            ->whereYear('outputs.created_at',$year)
            ->whereMonth('outputs.created_at',$month)
            ->where('output_details.article_id',$id)
            ->paginate(12)->appends(request()->query());

    }

    public static function getOutputs($article_id, $year, $periodIni, $periodEnd){
        return DB::table('outputs')
            ->join('output_details','outputs.id','output_details.output_id')
            ->join('articles','output_details.article_id','articles.id')
            ->whereYear('outputs.delivery_date',$year)
            ->WhereMonth('outputs.delivery_date', '>=', $periodIni)
            ->WhereMonth('outputs.delivery_date', '<=', $periodEnd)
            ->Where('output_details.article_id', $article_id)
            ->select(
                'output_details.quantity as outputs',
                'output_details.balance_stock',
            );
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($output) { // before delete() method call this
            $output->articles()->detach();
        });
    }

    public static function getDetailsOutputsMaterials($id, $year){
        return self::join('output_details','output_details.output_id','outputs.id')
            ->join('articles','output_details.article_id','articles.id')
            ->join('units','articles.unit_id', 'units.id')
            ->select('outputs.id as order_id',
                'outputs.created_at as date_of_admission',
                'articles.name_article',
                'output_details.quantity',
                'units.unit_measure'
            )
            ->where('output_details.article_id',$id)
            ->whereYear('outputs.created_at',$year)
            ->get();
    }

    public static function searchArticleByDate($id,$month=0,$monthtwo=0,$year=0){
        if($month == 0 && $monthtwo == 0 && $year == 0 ){
            return self::join('output_details','output_details.output_id','outputs.id')
                ->join('articles','output_details.article_id','articles.id')
                ->join('sections','outputs.section_id','sections.id')
                ->select(
                    'outputs.receipt',
                    'outputs.order_number',
                    'outputs.order_date',
                    'outputs.delivery_date',
                    'outputs.total',
                    'output_details.article_id',
                    'articles.name_article',
                    'output_details.quantity',
                    'output_details.budget_output',
                    'output_details.total',
                    'sections.name',
                    'articles.unit_price',
                    'outputs.id'
                )
                ->where('output_details.article_id',$id)
                ->paginate(12)->appends(request()->query());
        }else{
            return self::join('output_details','output_details.output_id','outputs.id')
                ->join('articles','output_details.article_id','articles.id')
                ->join('sections','outputs.section_id','sections.id')
                ->select(
                    'outputs.receipt',
                    'outputs.order_number',
                    'outputs.order_date',
                    'outputs.delivery_date',
                    'outputs.total',
                    'output_details.article_id',
                    'articles.name_article',
                    'output_details.quantity',
                    'output_details.budget_output',
                    'output_details.total',
                    'sections.name',
                    'articles.unit_price',
                    'outputs.id'
                )
                ->where('output_details.article_id',$id)
                ->WhereMonth('outputs.delivery_date', '>=',  $month)
                ->WhereMonth('outputs.delivery_date', '<=', $monthtwo)
                ->WhereYear('outputs.delivery_date', $year)
                ->paginate(12)->appends(request()->query());
        }
    }

}
