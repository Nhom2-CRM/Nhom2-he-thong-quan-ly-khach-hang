<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSharedCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('shared_category');

        return [
            'type' => [
                'sometimes',
                'string',
                Rule::in([
                    'CUSTOMER_INDUSTRY',
                    'COMPANY_SIZE',
                    'LEAD_SOURCE',
                    'ACTIVITY_TYPE',
                ]),
            ],

            'code' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('shared_categories', 'code')
                    ->ignore($categoryId),
            ],

            'name' => [
                'sometimes',
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