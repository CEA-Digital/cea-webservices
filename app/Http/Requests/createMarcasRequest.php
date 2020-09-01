<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createMarcasRequest extends FormRequest
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
            'name'=> 'unique:marcas,name|required|string|max:30',
            'description'=>'max:100'
            //
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'El nombre de la marca es requerido',
            'name.unique'=>'El nombre de la marca debe de ser unico',
            'name.max:30'=>'El nombre no puede exceder 30 caracteres',
            'name.string'=>'El nombre no deben de ser solamente numeros',
            'description.max:100'=>'La descripcion no debe de excceder de 100 caracteres'
        ];
    }
}
