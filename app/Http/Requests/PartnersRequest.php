<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnersRequest extends FormRequest
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
     */public function rules()
{
    return [
        'name'=>'required|string|max:100',
        'descripcion'=>'max:192',

    ];
}
    public function messages()
    {
        return [
            'name.required' => 'El nombre del servicio es requerido.',
             'descripcion.max:192' => 'La descripción  no debe de llevar mas de 192 caracteres.',
         ];
    }
}
