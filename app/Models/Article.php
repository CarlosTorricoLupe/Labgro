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
             ->get();
    }

    public function scopeArticlesPeripheralReport($query, $request){
        $periods=[
            'Primer Trimestre'=>[1,3],
            'Segundo Trimestre'=>[4,6],
            'Tercer Trimestre'=>[7,9],
            'Cuarto Trimestre'=>[10,12],
        ];
        return $query
            ->join('article_incomes','articles.id','article_incomes.article_id')
            ->join('incomes','article_incomes.income_id','incomes.id')
            ->join('units','articles.unit_id','units.id')
            ->join('output_details','articles.id','output_details.article_id')
            ->join('outputs','output_details.output_id','outputs.id')
            ->WhereYear('outputs.delivery_date', '=', $request->year)
            ->WhereYear('incomes.created_at', '=', $request->year)
            ->WhereMonth('incomes.created_at', '>=', $periods[$request->trimestre][0])
            ->WhereMonth('incomes.created_at', '<=', $periods[$request->trimestre][1])
            ->WhereMonth('outputs.delivery_date', '>=', $periods[$request->trimestre][0])
            ->WhereMonth('outputs.delivery_date', '<=', $periods[$request->trimestre][1])

            
            ->select('articles.id as articleId',
                'article_incomes.id as articleIncomeId',
                'incomes.id as incomeId',
                'articles.cod_article',
                'articles.name_article',
                'articles.stock as articleStock',
                'articles.unit_price as articleUnitPrice',
                'article_incomes.unit_price as incomesUnitPrice',
                'article_incomes.quantity as incomesQuantity',
                'article_incomes.last_output as lastOutput',
                'article_incomes.quantity as currentStock',
                'output_details.quantity as outputQuantity',
                'output_details.budget_output as output',
                'units.unit_measure')
            ->get();
    }

    public static function getArticlePhysicalReport($id,$monthone, $monthtwo,$year){
        if($monthone == 0 && $monthtwo == 0 && $year == 0 ){
            return self::join('article_incomes','articles.id','article_incomes.article_id')
                        ->join('incomes','article_incomes.income_id','incomes.id')
                        ->select(//'articles.name_article as article_name',
                            'incomes.created_at as fecha',
                            'incomes.invoice_number as comprobante',                    
                            'article_incomes.quantity as cantidadEntrada',
                            'article_incomes.total_price as importeEntrada',
                            'article_incomes.quantity as cantidadSaldo',
                            'article_incomes.total_price as importeSaldo',
                            'article_incomes.unit_price as precioMedioEntrada',
                            'article_incomes.created_at as created_at',
                        )
                ->where('article_incomes.article_id',$id)
                ->get();

        }else{
            return self::join('article_incomes','articles.id','article_incomes.article_id')
                    ->join('incomes','article_incomes.income_id','incomes.id')
                    ->select(//'articles.name_article as article_name',
                        'incomes.created_at as fecha',
                        'incomes.invoice_number as comprobante',                    
                        'article_incomes.quantity as cantidadEntrada',
                        'article_incomes.total_price as importeEntrada',
                        'article_incomes.quantity as cantidadSaldo',
                        'article_incomes.total_price as importeSaldo',
                        'article_incomes.unit_price as precioMedioEntrada',
                        'article_incomes.created_at as created_at',
                    )
                ->where('article_incomes.article_id',$id)
                ->WhereMonth('incomes.created_at', '>=',  $monthone)
                ->WhereMonth('incomes.created_at', '<=', $monthtwo)
                ->WhereYear('incomes.created_at', $year)
                ->get();
        }
    }

    public static function getArticlePhysicalReportOutput($id,$monthone, $monthtwo,$year){

        if($monthone == 0 && $monthtwo == 0 && $year == 0 ){
            return self::join('output_details','articles.id','output_details.article_id')
                    ->join('outputs','output_details.output_id','outputs.id')
                    ->join('sections','outputs.section_id','sections.id')
                    ->select(//'articles.name_article as article_name',
                        'outputs.delivery_date as fecha',
                        'outputs.receipt as comprobante',
                        'sections.name as origen',
                        'output_details.quantity as cantidadSalida',
                        'output_details.total as importeSalida',
                        'output_details.balance_stock as cantidadSaldo',
                        'output_details.balance_price as importeSaldo',
                        'output_details.created_at as created_at'
                    )       
            ->where('output_details.article_id',$id)
            ->get();
        }else{
            return self::join('output_details','articles.id','output_details.article_id')
                    ->join('outputs','output_details.output_id','outputs.id')
                    ->join('sections','outputs.section_id','sections.id')
                    ->select(//'articles.name_article as article_name',
                        'outputs.delivery_date as fecha',
                        'outputs.receipt as comprobante',
                        'sections.name as origen',
                        'output_details.quantity as cantidadSalida',
                        'output_details.total as importeSalida',
                        'output_details.balance_stock as cantidadSaldo',
                        'output_details.balance_price as importeSaldo',
                        'output_details.created_at as created_at'
                    )   
                 ->where('output_details.article_id',$id)
                ->WhereMonth('outputs.delivery_date', '>=',  $monthone)
                ->WhereMonth('outputs.delivery_date', '<=', $monthtwo)
                ->WhereYear('outputs.delivery_date', $year)
                ->get();
        }
    
    }
}
