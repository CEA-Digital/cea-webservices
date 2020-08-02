<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiciosRequest extends FormRequest
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
            'descripcion'=>'max:192',
            'condiciones'=>'required|string|max:100',
             'precio'=>'required|numeric',
            'id_empresa'=>'required|integer',
            'id_categoria'=>'required|integer',


        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre del servicio es requerido.',
            'condiciones.required' => 'Escriba una condición para este servivio.',
            'descripcion.max:192' => 'La descripción  no debe de llevar mas de 192 caracteres.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.required' => 'El precio es requerido.',

            'id_empresa.required' => 'Se requiere una empresa para este servivio.',
            'id_categoria.required' => 'Se requiere una categoria para este servivio.',
         ];
    }
}
