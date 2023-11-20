<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseUserRequest;

class StoreRequest extends BaseUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize($model = null): bool
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
            "name"     => "required|string|max:255",
            "email"    => "required|string|unique:users|max:255",
            "password" => "required|string|max:255"
        ];
    }
     /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'     => 'O campo nome é obrigatório.',
            'name.max'          => 'O campo nome não pode ter mais de 255 caracteres.',
            'email.required'    => 'O campo email é obrigatório.',
            'email.unique'      => 'Este email já está em uso.',
            'email.max'         => 'O campo email não pode ter mais de 255 caracteres.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.max'      => 'O campo senha não pode ter mais de 255 caracteres.',
        ];
    }
}
