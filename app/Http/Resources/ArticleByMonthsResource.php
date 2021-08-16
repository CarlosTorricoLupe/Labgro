<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\RawMaterial;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ArticleByMonthsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'=>Article::find($this->id)->name_article,
            'articlesByMonth'=>[
                'nameMonth'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 1)
                    ->get(),
                'febrero'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 2)
                    ->get(),
                'marzo'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 3)
                    ->get(),
                'abril'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 4)
                    ->get(),
                'mayo'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 5)
                    ->get(),
                'junio'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 6)
                    ->get(),
                'julio'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 7)
                    ->get(),
                'agosto'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 8)
                    ->get(),
                'septiembre'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 9)
                    ->get(),
                'octubre'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 10)
                    ->get(),
                'noviembre'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 11)
                    ->get(),
                'diciembre'=>RawMaterial::where('article_id',$this->id)
                    ->whereYear('created_at', '=', 2021)
                    ->whereMonth('created_at', '=', 12)
                    ->get()
            ]
        ];
    }
}
