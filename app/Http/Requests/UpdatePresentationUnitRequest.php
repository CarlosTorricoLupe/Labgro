<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class UpdatePresentationUnitRequest extends FormRequest
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
             /* 'name' => 'required|iunique:presentation_units,name,'.$this->presentation_units->id, */ 
            'name' => ['required',ValidationRule::unique('presentation_units')->ignore($this->presentation)],
            'quantity' => 'required',
            'stock_min' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'   => 'El nombre para la :attribute es obligatorio.',
            'name.iunique'   => 'Esta :attribute ya existe, prueba otro nombre.',
            'quantity.required' => 'La :attribute de una presentacion es obligatoria',
            'stock_min.required' => 'El :attribute de una presentacion es obligatorio'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Unidad de presentacion',
            'quantity' => 'cantidad',
            'stock_min' => 'cantidad minima'
        ];
    }
}
