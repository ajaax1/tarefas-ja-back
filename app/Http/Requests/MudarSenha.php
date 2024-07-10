<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MudarSenha extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
            'password' => 'required',
            'password_confirmation' => 'required',
            'token' => 'required'
        ];
    }

    public function messages(){
        return [
            'password.required' => 'O campo senha é obrigatório',
            'password_confirmation.required' => 'O campo confirmação de senha é     obrigatório',
            'token.required' => 'O token é obrigatório'
        ];
    }
}
