<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePromocionRequest extends FormRequest
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
             'id_servicio'=>'required|integer',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date',



        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la promoción es requerido.',
             'descripcion.max:192' => 'La descripción  no debe de llevar mas de 192 caracteres.',
             'id_servicio.required' => 'Se requiere un servicio para esta promoción.',
            'fecha_inicio.required' => 'Se requiere una fecha de inicio para esta promoción.',
            'fecha_fin.required' => 'Se requiere una fecha fin para esta promoción.',

        ];
    }
}
