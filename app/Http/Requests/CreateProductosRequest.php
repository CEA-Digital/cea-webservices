<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductosRequest extends FormRequest
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
            'name'=>'required|string|max:100',
            'description'=>'max:192',
            'unit_price'=>'required|numeric|max:9',
            'lote_price'=>'required|numeric|max:9',
            'disponible'=>'required|boolean',
            'id_empresa'=>'required|integer',
            'id_categoria'=>'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre del producto es requerido.',
            'description.max:192' => 'La descripción  no debe de tener más de 192 caracteres.',
            'unit_price.numeric' => 'El precio debe ser un valor numérico.',
            'unit_price.max:9' =>'El precio unitario no debe de exceder de 9 caracteres',
            'id_empresa.required' => 'Se requiere una empresa para este producto.',
            'id_categoria.required' => 'Se requiere una categoria para este producto.',
        ];
    }
}
