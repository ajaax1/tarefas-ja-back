<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarefaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected $stopOnFirstFailure = true;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->isMethod('POST') ? $this->store() : $this->update();
    }

    public function store()
    {
        return [
            "objetivo" => "required|max:190",
            "descricao" => "required",
            "completo" => "in:SIM,PENDENTE",
            "user_id" => "required|exists:users,id",
        ];
    }

    public function update()
    {
        return [
            "objetivo" => "required|max:190",
            "descricao" => "required",
            "completo" => "in:SIM,PENDENTE",
        ];
    }

    public function messages(): array
    {
        return [
            "objetivo.required" => "O campo Objetivo deve ser prenchido",
            "objetivo.max" => "O campo Objetivo deve ter 190 caracteres",
            "completo.required" => "O campo Completo deve ser prenchido",
            "completo.in" => "O campo Completo deve ter SIM ou NÃO",
            "categoria_id.required" => "O campo Categoria deve ser prenchido",
            "categoria.exists" => "A categoria deve ser valida",
            "descricao.required" => "O campo Descrição deve ser prenchido",
        ];
    }
}
