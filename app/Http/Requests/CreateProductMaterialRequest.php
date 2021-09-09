<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductMaterialRequest extends FormRequest
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
            'material_id' => 'required|iunique:material_products,material_id',
            'quantity' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'material_id.required'   => 'El :attribute es obligatorio.',
            'material_id.iunique'   => 'Este :attribute ya existe, intente de nuevo.',
            'quantity.required'   => 'La :attribute es obligatorio.',
        ];
    }

    public function attributes()
    {
        return [
            'material_id' => 'Materia',
            'quantity' => 'Cantidad',
        ];
    }
}
