<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|between:2,25|iunique:materials,code',
            'stock_start' => 'required',
            'stock_min' => 'required',
            'color' => 'required',
            'article_id' => 'required|unique:materials,article_id'
        ];
    }
    public function messages()
    {
        return [
            'code.required'   => 'El codigo para el :attribute es obligatorio.',
            'code.iunique'   => 'Este :attribute ya existe, intente de nuevo.',
            'stock_start'  => 'El :attribute es obligatorio.',
            'stock_min'  => 'El :attribute es obligatorio.',
            'color'  => 'El :attribute es obligatorio.',
            'article_id.required'  => 'El :attribute es obligatorio.',
            'article_id.unique'  => 'El :attribute ya fue seleccionado.',
        ];
    }

    public function attributes()
    {
        return [
            'code' => 'Codigo',
            'stock_start' => 'Stock inicial',
            'stock_min' => 'Stock minimo',
            'color' => 'Color',
            'article_id' => 'articulo',
        ];
    }
}
