<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
}
