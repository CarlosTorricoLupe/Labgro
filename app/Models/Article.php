<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;


    protected $table = 'articles';

    protected $casts = [
        'created_at' => "datetime:Y-m-d",
        'stock' => 'integer',
        'stock_min' => 'integer',
        'stock_total' =>'integer'

    ];

    protected $fillable = [
        'id',
        'cod_article',
        'name_article',
        'stock',
        'unit_price',
        'category_id',
        'unit_id',
        'created_at',
        'stock_min'
    ];
    protected $hidden = [
        'updated_at',
    ];

    public function categories(){
        return $this->belongsToMany(Category::class,'category_id');
    }

    public function units(){
        return $this->belongsToMany(Unit::class);
    }

    public function incomes()
    {
        return $this->belongsToMany(Income::class,'article_incomes')->withPivot('quantity','unit_price','total_price')->withTimestamps();
    }
    public function outputs(){
        return $this->belongsToMany(Output::class, "output_details", "article_id", "output_id")
                    ->withPivot('quantity','budget_output','total')
                    ->withTimestamps();;
    }

    public function scopeUpdateStatusIsLow($query){
        $articles = Article::all();
        foreach ($articles as $article) {
            $stock = $article->stock;
            $stock_min = $article->stock_min;
            if ( $stock <= $stock_min ){
                $article->is_low = 1;
            }else{
                $article->is_low = 0;
            }
            $article->save();
        }
    }

    public function scopeArticlesAll($query){
         return $query->join('categories','articles.category_id','=',"categories.id")
             ->join('units','articles.unit_id','=',"units.id")
             ->select('articles.name_article')
             ->orderBy('articles.is_low','DESC')
             ->select('articles.*','categories.name', 'units.unit_measure','units.kind')
             ->orderBy('articles.name_article')
             ->get();
    }

    public static function getArticlePhysicalReport($id,$monthone, $monthtwo,$year){
        return self::join('article_incomes','articles.id','article_incomes.article_id')
                ->join('incomes','article_incomes.income_id','incomes.id')
                ->select(//'articles.name_article as article_name',
                    'incomes.created_at as fecha',
                    'incomes.invoice_number as comprobante',                    
                    'article_incomes.quantity as cantidadEntrada',
                    'article_incomes.total_price as importeEntrada',
                    'article_incomes.current_stock as stock',
                    'article_incomes.current_price as price',
                    'article_incomes.unit_price as precioMedioEntrada',
                    'article_incomes.unit_value as valUnit',
                    'article_incomes.created_at as created_at',
                )
            ->where('article_incomes.article_id',$id)
            ->WhereMonth('incomes.created_at', '>=',  $monthone)
            ->WhereMonth('incomes.created_at', '<=', $monthtwo)
            ->when($year >= date('Y'), function ($query) use ($year){
                $query->WhereYear('incomes.created_at', date('Y'));   
            })
            ->when($year < date('Y'), function ($query) use ($year){
                $query->WhereYear('incomes.created_at', $year);   
                })
            ->orderBy('fecha','ASC')
            ->orderBy('created_at','ASC')
            ->get();
    }

    public static function getArticlePhysicalReportOutput($id,$monthone, $monthtwo,$year){
        return self::join('output_details','articles.id','output_details.article_id')
                ->join('outputs','output_details.output_id','outputs.id')
                ->join('sections','outputs.section_id','sections.id')
                ->select(//'articles.name_article as article_name',
                    'outputs.delivery_date as fecha',
                    'outputs.receipt as comprobante',
                    'sections.name as origen',
                    'articles.unit_price as valUnit',
                    'output_details.quantity as cantidadSalida',
                    'output_details.total as importeSalida',
                    'output_details.balance_stock as cantidadSaldo',
                    'output_details.balance_price as importeSaldo',
                    'output_details.created_at as created_at'
                )   
            ->where('output_details.article_id',$id)
            ->WhereMonth('outputs.delivery_date', '>=',  $monthone)
            ->WhereMonth('outputs.delivery_date', '<=', $monthtwo)
            ->when($year >= date('Y'), function ($query) use ($year){
                $query->WhereYear('outputs.delivery_date', date('Y'));   
                })
                ->when($year < date('Y'), function ($query) use ($year){
                $query->WhereYear('outputs.delivery_date', $year);   
                })
            ->orderBy('fecha','ASC')
            ->orderBy('created_at','ASC')
            ->get();
    }

    public static function getInputs($year, $periodIni, $periodEnd){
        return DB::table('articles')
            ->join('article_incomes','articles.id','article_incomes.article_id')
            ->join('incomes','article_incomes.income_id',"incomes.id")
            ->join('units','articles.unit_id',"units.id")
            ->whereYear('incomes.created_at',$year)
            ->WhereMonth('incomes.created_at', '>=', $periodIni)
            ->WhereMonth('incomes.created_at', '<=', $periodEnd)
            ->select(
                'article_incomes.article_id',
                'articles.cod_article',
                DB::raw('SUM(article_incomes.quantity) as quantity'),
                'units.unit_measure',
                'articles.name_article',
                'articles.unit_price',
                DB::raw('SUM(article_incomes.total_price) as total'),
            )
            ->groupBy('article_incomes.article_id',
                'articles.cod_article',
                'units.unit_measure',
                'articles.name_article',
                'articles.unit_price',
            );
    }
}
