<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('customer')?->id;

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'taxCode' => [
                'sometimes',
                'nullable',
                'string',
                'max:50',
                Rule::unique('customers', 'tax_code')->ignore($customerId),
            ],
            'isActive' => ['sometimes', 'boolean'],
        ];
    }
}