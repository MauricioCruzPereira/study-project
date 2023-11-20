<?php

namespace App\Http\Requests;

use App\Exceptions\AuthenticationException;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize($model): bool
    {
        $userId = auth()->id();
        $modelRequest = $model::findOrFail(request()->route('id'));
        if($modelRequest->user_id !== $userId){
            throw new AuthenticationException('Unauthorized', 403);
        }

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
            //
        ];
    }
}
