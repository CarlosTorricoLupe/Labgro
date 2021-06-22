<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;

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
            'nombre_articulo' => 'required|unique:articles,nombre_articulo|regex:/^[w-]*$/'
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
            'nombre_articulo.required'   => 'El :attribute es obligatorio.',
            'nombre_articulo.unique'   => 'El :attribute es unico.',
        ];
    }

    public function attributes()
    {
        return [
            'nombre_articulo' => 'nombre de articulo',
        ];
    }

}
