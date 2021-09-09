<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductMaterialRequest extends FormRequest
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
            'quantity' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'quantity.required'   => 'La :attribute es obligatorio.',
        ];
    }

    public function attributes()
    {
        return [
            'quantity' => 'Cantidad',
        ];
    }
}
