<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'taxCode' => ['nullable', 'string', 'max:50', 'unique:customers,tax_code'],
            'isActive' => ['sometimes', 'boolean'],
        ];
    }
}