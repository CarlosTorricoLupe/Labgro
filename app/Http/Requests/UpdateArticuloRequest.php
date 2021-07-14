<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Iunique;

class UpdateArticuloRequest extends FormRequest
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
            'cod_article' => 'required|between:2,25|iunique:articles,cod_article,'.$this->article->id,
            'name_article' => 'required|between:2,25|unique:articles,name_article,'.$this->route('article')->id,

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
            'cod_article.required'   => 'El nombre para la :attribute es obligatorio.',
            'cod_article.iunique'   => 'Este :attribute ya existe, prueba otro nombre.',
            'name_article.required'   => 'El nombre para la :attribute es obligatorio.',
            'name_article.iunique'   => 'Este :attribute ya existe, prueba otro nombre.',
        ];
    }

    public function attributes()
    {
        return [
            'cod_article' => 'Codigo',
            'name_article' => 'Nombre'
        ];
    }
}
