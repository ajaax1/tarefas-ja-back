<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules()
    {
        if($this->isMethod('POST')) {
            return $this->store();
        }else{
            return $this->update();
        }
    }

    protected $stopOnFirstFailure = true; 

    public function store(){
        return [
            'name' => 'required|string|max:80',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|max:255',
        ];
    }

    public function update()
    {
        return [
            'name' => 'string|max:80|required',
            'email' => 'email|unique:users,email|max:255|required',
            'password' => 'string|required|max:255'
        ];
    }

    public function messages(){
        return [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de e-mail válido.',
            'email.max' => 'O campo email deve ter mais de 80 caracteres.',
            'email.unique' => 'O email já está cadastrado.',
            'name.max' => 'O campo nome deve ter mais de 80 caracteres.',
            'name.required' => 'O campo nome deve ser preenchido.',
            'password.max' => 'O campo senha deve ter mais de 255 caracteres.',
            'password.required' => 'O campo senha é obrigatório.',
            'name.string' => 'O campo nome deve ser uma prenchido.',
        ];
    }

}
