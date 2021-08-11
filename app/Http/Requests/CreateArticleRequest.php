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
            'cod_article' => 'required|between:2,25|iunique:articles,cod_article',
            'name_article' => 'required|unique:articles,name_article'
        ];
    }

    public function messages()
    {
        return [
            'cod_article.required'   => 'El :attribute es obligatorio.',
            'cod_article.iunique'   => 'El :attribute es unico.',
        ];
    }

    public function attributes()
    {
        return [
            'cod_article' => 'codigo de articulo',
        ];
    }
}
