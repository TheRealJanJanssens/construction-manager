<?php

namespace App\Http\Requests\API\V1;

use App\Enums\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\API\V1\PrepareForValidation;

class StoreUserRequest extends FormRequest
{
    use PrepareForValidation{
        PrepareForValidation::prepareForValidation as parentPrepareForValidation;
    }

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
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required','email'],
            //'role' => ['required', Rule::in(Role::optionsWithoutLabel())]
        ];
    }

    /**
     * Custom preparation
     * Fill password if empty
     */
    protected function prepareForValidation() {
        if(!isset($this->password)){
            $this->merge(['password' => Str::random(40)]);
        }

        $this->parentPrepareForValidation();
    }
}
