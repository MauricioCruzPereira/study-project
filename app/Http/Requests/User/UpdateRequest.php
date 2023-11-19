<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($userId = null): array
    {
        return [
            "name"     => "string|max:255",
            "email"    => "string|max:255|unique:users,email,".$userId,
            "password" => "string|max:255"
        ];
    }
}
