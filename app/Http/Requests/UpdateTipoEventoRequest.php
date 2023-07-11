<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoEventoRequest extends FormRequest
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
            'nombre'    => 'sometimes|required|max:50|unique:tipo_evento,id,'.$this->id.",id",
            'fondo'     => 'sometimes|required|max:10',
            'texto'     => 'sometimes|required|max:10',
            'borde'     => 'sometimes|required|max:10'
        ];
    }
}
