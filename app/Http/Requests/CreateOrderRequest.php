<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'receipt' => 'required|iunique:orders,receipt',
            'order_number' => 'required',
            'date_issue' => 'required',
            'section_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'receipt.required'   => 'El  :attribute es obligatorio.',
            'receipt.iunique'   => 'Este :attribute ya existe, intente de nuevo.',
            'order_number'  => 'El :attribute es obligatorio.',
            'date_issue'  => 'la :attribute es obligatorio.',
            'section_id'  => 'La :attribute es obligatorio.',
        ];
    }

    public function attributes()
    {
        return [
            'receipt' => 'Comprobante',
            'order_number' => 'Número de orden',
            'date_issue' => 'Fecha de emision',
            'section_id' => 'Seccion',
        ];
    }
}
