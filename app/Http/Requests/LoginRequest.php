<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'Tu correo electrónico debe ser valido',
            'password.required' => 'El campo contraseña es requerido',
            'password.min' => 'El campo contraseña debe tener mínimo 8 caracteres',
        ];
    }
}
