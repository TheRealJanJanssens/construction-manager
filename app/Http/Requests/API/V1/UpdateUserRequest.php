<?php

namespace App\Http\Requests\API\V1;

use App\Enums\Role;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\API\V1\PrepareForValidation;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if($this->method == 'PUT'){
            return [
                'first_name' => ['required'],
                'last_name' => ['required'],
                'email' => ['required','email'],
                //'role' => ['required', Rule::in(Role::optionsWithoutLabel())]
            ];
        }else{
            return [
                'first_name' => ['sometimes','required'],
                'last_name' => ['sometimes','required'],
                'email' => ['sometimes','required','email'],
                //'role' => ['sometimes','required', Rule::in(Role::optionsWithoutLabel())]
            ];
        }
    }
}
