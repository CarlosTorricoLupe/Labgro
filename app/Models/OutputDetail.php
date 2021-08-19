<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getDetails($id){
        return self::join('articles','output_details.article_id','articles.id')->join('units','articles.unit_id',"units.id")
            ->select('output_details.article_id','output_details.quantity', 'output_details.budget_output','output_details.total', 'output_details.output_id','articles.name_article','unit_measure')
            ->where('output_details.output_id', '=', $id)
            ->get();
    }
}
