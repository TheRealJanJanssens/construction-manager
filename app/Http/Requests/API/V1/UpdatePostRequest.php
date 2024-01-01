<?php

namespace App\Http\Requests\API\V1;

use App\Traits\API\V1\PrepareForValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
                'project_uuid' => ['required'],
                'user_uuid' => ['required'],
                'content' => ['required']
            ];
        }else{
            return [
                'project_uuid' => ['sometimes','required'],
                'user_uuid' => ['sometimes','required'],
                'content' => ['sometimes','required']
            ];
        }
    }
}
