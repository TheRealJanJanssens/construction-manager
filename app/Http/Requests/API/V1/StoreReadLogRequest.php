<?php

namespace App\Http\Requests\API\V1;

use App\Traits\API\V1\PrepareForValidation;
use Illuminate\Foundation\Http\FormRequest;

class StoreReadLogRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
