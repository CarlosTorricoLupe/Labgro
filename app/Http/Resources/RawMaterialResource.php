<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\RawMaterial;
use Illuminate\Http\Resources\Json\JsonResource;

class RawMaterialResource extends JsonResource
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
            'month'=>   RawMaterial::whereYear('created_at', '=', 2021)
            ->whereMonth('created_at', '=', $this->id)
            ->select('created_at')
            ->get(),

        ];
    }
}
