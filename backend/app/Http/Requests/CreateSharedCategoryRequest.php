<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSharedCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                Rule::in([
                    'CUSTOMER_INDUSTRY',
                    'COMPANY_SIZE',
                    'LEAD_SOURCE',
                    'ACTIVITY_TYPE',
                ]),
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                'unique:shared_categories,code',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'sortOrder' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'isActive' => [
                'sometimes',
                'boolean',
            ],
        ];
    }
}