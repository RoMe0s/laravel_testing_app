<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AuthFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false === is_null($this->user());
    }
}
