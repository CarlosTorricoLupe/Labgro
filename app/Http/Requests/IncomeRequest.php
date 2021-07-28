<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
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
            'receipt' => 'required|unique:incomes,receipt'
        ];
    }
    public function messages()
    {
        return [
            'receipt.required'   => 'El numero para el :attribute es obligatorio.',
            'receipt.unique'   => 'El nro de :attribute ya existe, pruebe con otro.',
        ];
    }

    public function attributes()
    {
        return [
            'receipt' => 'Comprobante',
        ];
    }
}
