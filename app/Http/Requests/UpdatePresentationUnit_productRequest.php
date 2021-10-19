<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePresentationUnit_productRequest extends FormRequest
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
            'unit_cost_production' => 'numeric|min:0',
            'unit_price_sale' => 'numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'unit_cost_production.min' => 'El :attribute debe ser un numero positivo',
            'unit_price_sale.min' => 'El :attribute debe ser un numero positivo',
        ];
    }

    public function attributes()
    {
        return [
            'unit_cost_production' => 'costo Unitario de produccion',
            'unit_price_sale' => 'precio unitario de venta'
        ];
    }
}
