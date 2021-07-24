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
            'receipt' => 'required|iunique:incomes,receipt'
        ];
    }
    public function messages()
    {
        return [
            'receipt.required'   => 'El numero para el :attribute es obligatorio.',
            'receipt.iunique'   => 'Esta :attribute ya existe, prueba otro numero.',
        ];
    }

    public function attributes()
    {
        return [
            'receipt' => 'Comprobante',
        ];
    }
}
