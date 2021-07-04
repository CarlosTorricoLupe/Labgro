<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUnitRequest extends FormRequest
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
            'unit_measure' => 'required|between:2,25|unique:units,unit_measure',
            'kind' => 'required|between:2,25|unique:units,kind'
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
            'unit_measure.required'   => 'El :attribute es obligatorio.',
            'unit_measure.unique'   => 'El :attribute es unico.',
            'kind'   => 'El :attribute es obligatorio.',
            'kind'   => 'El :attribute es unico.',
        ];
    }
}
