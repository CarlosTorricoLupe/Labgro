<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'cod_article' => 'required|between:2,25|iunique:articles,cod_article',
            'name_article' => 'required|unique:articles,name_article',
            'stock' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'stock_min' => 'numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'cod_article.required'   => 'El :attribute es obligatorio.',
            'cod_article.iunique'   => 'El :attribute es unico.',
            'stock.min' => 'El :attribute debe ser un numero positivo',
            'unit_price.min' => 'El :attribute debe ser un numero positivo',
            'stock_min.min' => 'El :attribute debe ser un numero positivo',
        ];
    }

    public function attributes()
    {
        return [
            'cod_article' => 'codigo de articulo',
            'stock' => 'Stock',
            'stock_min' => 'stock minimo',
            'unit_price' => 'precio unitario'
        ];
    }
}
