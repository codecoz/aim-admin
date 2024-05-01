<?php

namespace CodeCoz\AimAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class FileUploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */

    public function rules(): array
    {
        return [
            'upload' => [
                'required',
                File::types(config('aim-admin.upload_file_type'))
                    ->max(config('aim-admin.upload_file_size'))
            ],
        ];
    }

}
