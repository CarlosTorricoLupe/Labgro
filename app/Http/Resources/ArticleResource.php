<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'id' => $this->id,
            'cod_article' => $this->cod_article,
            'name_article' => $this->name_article,
            'incomes' => $this->incomes,
            'output' => $this->outputs,
            'updated_at' => $this->updated_at,
        ];
    }
}
