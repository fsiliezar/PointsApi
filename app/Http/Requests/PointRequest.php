<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;

class PointRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'latitud' => ['required','numeric','between:-90,90'],
            'longitud' => ['required','numeric','between:-180,180'],
            'tipo' => ['required', 'in:accidente,congestion,obstruccion,otro'],
            'descripcion' => ['nullable','string','max:1000'],
        ];
    }

    public function messages(): array
    {
        return[
            'latitud.required' => 'La latitud es obligatorio.',
            'longitud.required' => 'La longitud es obligatorio.',
            'tipo.required' => 'El tipo de evento es obligatorio.',
            'tipo.in' => 'El tipo de evento no es valido',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Datos inválidos',
            'errors' => $validator->errors()
        ],422));
    }
}
