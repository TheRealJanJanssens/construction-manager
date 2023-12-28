<?php

namespace App\Http\Requests\API\V1;

use App\Traits\API\V1\PrepareForValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConversationRequest extends FormRequest
{
    use PrepareForValidation;

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
        if($this->method == 'PUT'){
            return [
                'name' => ['required'],
                'users' => ['required', 'array', 'min:2']
            ];
        }else{
            return [
                'name' => ['sometimes'],
                'users' => ['sometimes', 'array', 'min:2']
            ];
        }
    }
}
