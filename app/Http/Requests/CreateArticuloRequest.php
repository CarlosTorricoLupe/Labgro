<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticuloRequest extends FormRequest
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

        $rules = [
            'cod_article' => 'required|between:2,25|iunique:articles,cod_article',
            'name_article' => 'required|unique:articles,name_article'
        ];

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                    return [];
                }
            case 'POST': {
                    return $rules;
                }
            case 'PUT':
            case 'PATCH': {
                    return $rules;
                }
            default:
                break;
        }
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
