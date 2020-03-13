<?php

namespace App\Http\Requests;

class ReferenceFilterRequest extends AuthFormRequest
{
    public function rules(): array
    {
        return [
            'reference_values' => 'array',
            'reference_values.*' => 'exists:reference_values,id',
        ];
    }

    public function getReferenceValueIds(): array
    {
        return $this->get('reference_values', []);
    }
}
