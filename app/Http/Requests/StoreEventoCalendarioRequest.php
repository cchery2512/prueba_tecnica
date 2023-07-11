<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoCalendarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'titulo'            => 'required|max:100',
            'tipo_evento_id'    => 'required|integer|exists:tipo_evento,id',
            'fecha_hora_inicio' => 'required|iso_date',
            'fecha_hora_fin'    => 'required|iso_date|after:fecha_hora_inicio'
        ];
    }

    public function messages()
    {
        return [
            'tipo_evento_id' => 'There is no event type with this id.',
        ];
    }
}
