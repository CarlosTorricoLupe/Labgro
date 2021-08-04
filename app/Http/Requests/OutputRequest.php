<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutputRequest extends FormRequest
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
            'receipt' => 'required|unique:outputs,receipt',
            'section_id' => 'required',
            'order_number' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'total' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'receipt.required'   => 'El numero para el :attribute es obligatorio.',
            'receipt.unique'   => 'Esta :attribute ya existe, prueba otro numero.',
            'section_id'  => 'El numero para el :attribute es obligatorio.',
            'order_date'  => 'El :attribute es obligatorio.',
            'delivery_date'  => 'El :attribute es obligatorio.',
            'total'  => 'El :attribute es obligatorio.',

        ];
    }

    public function attributes()
    {
        return [
            'receipt' => 'Comprobante',
            'section_id' => 'id seccion',
            'order_number' => 'Numero de pedido',
            'order_date' => 'Fecha de pedido',
            'delivery_date' => 'Fecha de entrega',
            'total' => 'Total',
        ];
    }
}
