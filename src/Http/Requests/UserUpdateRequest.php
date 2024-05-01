<?php

namespace CodeCoz\AimAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        return [
            //
            'emailAddress' => 'required|email',
            'fullName' => 'required|string',
            'userName' => 'required|string',
            'mobileNumber' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $pattern = '/^\+?8801[3-9]\d{8}$/';
                    if (!preg_match($pattern, $value)) {
                        $fail('Number is not a valid Bangladeshi mobile number.');
                    }
                },
            ],
            'roles' => 'required|array',
            'permissions' => 'sometimes|array',
        ];
    }
}
