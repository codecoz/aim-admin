<?php

namespace CodeCoz\AimAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuCreateRequest extends FormRequest
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
            'display_order' => 'required|numeric',
            'parentID' => 'required',
            'title' => 'required|string',
            'name' => 'required|string',
            'iconName' => 'sometimes',
            'target' => 'sometimes',
        ];
    }
}
