<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|between:2,25|iunique:raw_materials,code' .$this->route('raw_material')->id,
            'stock_start' => 'required',
            'stock_min' => 'required',
            'color' => 'required',
            'article_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'code.required'   => 'El codigo para el :attribute es obligatorio.',
            'code.iunique'   => 'Esta :attribute ya existe, intente de nuevo.',
            'stock_start'  => 'El :attribute es obligatorio.',
            'stock_min'  => 'El :attribute es obligatorio.',
            'color'  => 'El :attribute es obligatorio.',
            'article_id'  => 'El :attribute es obligatorio.',

        ];
    }

    public function attributes()
    {
        return [
            'code' => 'Codigo',
            'stock_start' => 'Stock inicial',
            'stock_min' => 'Stock minimo',
            'color' => 'Color',
            'article_id' => 'id articulo',
        ];
    }
}
