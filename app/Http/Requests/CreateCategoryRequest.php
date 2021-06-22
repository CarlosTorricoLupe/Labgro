<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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

    public function rules()
    {

        $rules = [
            'name' => 'required|between:2,25|unique:categories,name|regex:/^[w-]*$/'
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
            'name.required'   => 'El :attribute es obligatorio.',
            'name.unique'   => 'El :attribute es unico.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre de categoria',
        ];
    }
}
