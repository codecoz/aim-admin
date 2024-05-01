<?php

namespace CodeCoz\AimAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPasswordRequest extends FormRequest
{
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
//      $rules['id'] = 'required';
        $rules['password'] = 'required|min:8|confirmed';
        $rules['password_confirmation'] = 'required';
        return $rules;
    }
}
