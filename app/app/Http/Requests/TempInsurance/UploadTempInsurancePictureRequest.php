<?php

namespace App\Http\Requests\TempInsurance;

use Illuminate\Foundation\Http\FormRequest;

class UploadTempInsurancePictureRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'picture' => 'required|image',
        ];
    }

    public function attributes()
    {
        return [
            'picture' => 'Picture',
        ];
    }
}
