<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMaterialOrderRequest extends FormRequest
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
            'request_amount'=>'required',
            'article_id'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'request_amount.required'=>'El :attribute es obligatorio',
            'article_id.required'=>'El :attribute es obligatorio'
        ];
    }
    public function attributes()
    {
        return [
            'request_amount' => 'CANTIDAD_REQUERIDA',
            'article_id' => 'ID_ARTICULO'
        ];
    }
}
