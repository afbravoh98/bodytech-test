<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|string|email|max:255|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'password.required' => 'El campo contraseña es requerido.',
            'password.min' => 'El campo contraseña debe ser valido de 8 caracteres',
            'email.required' => 'El campo de correo electrónico es requerido',
            'email.email' => 'El campo correo electrónico debe ser valido',
            'email.unique' => 'Este correo electrónico, se encuentra en uso',
        ];
    }
}
