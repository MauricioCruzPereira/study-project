<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"        => "required|string",
            "description" => "required|string",
            "price"       => "required|string"
        ];
    }
}
