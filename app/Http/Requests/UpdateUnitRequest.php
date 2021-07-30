<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
            'unit_measure' => 'required|between:2,25|iunique:units,unit_measure,'.$this->unit->id,

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
            'unit_measure.required'   => 'El nombre para la :attribute es obligatorio.',
            'unit_measure.iunique'   => 'Esta :attribute ya existe, prueba otro nombre.',
        ];
    }

    public function attributes()
    {
        return [
            'unit_measure' => 'Unidad',
        ];
    }


}
