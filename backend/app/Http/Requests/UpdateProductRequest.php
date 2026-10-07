<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'code' => [
                'sometimes',
                'string',
                'max:50',
                'unique:products,code,' . $this->route('id'),
            ],
            'name' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', 'in:PRODUCT,SERVICE'],
            'unit' => ['nullable', 'string', 'max:100'],
            'listPrice' => ['sometimes', 'numeric', 'min:0'],
            'floorPrice' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'isActive' => ['sometimes', 'boolean'],
        ];

        if ($this->user()?->role === 'SALES_DIRECTOR') {
            $rules['costPrice'] = ['sometimes', 'nullable', 'numeric', 'min:0'];
        }

        return $rules;
    }
}