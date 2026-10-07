<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'code' => ['required', 'string', 'max:50', 'unique:products,code'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:PRODUCT,SERVICE'],
            'unit' => ['nullable', 'string', 'max:100'],
            'listPrice' => ['required', 'numeric', 'min:0'],
            'floorPrice' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'isActive' => ['sometimes', 'boolean'],
        ];

        if ($this->user()?->role === 'SALES_DIRECTOR') {
            $rules['costPrice'] = ['nullable', 'numeric', 'min:0'];
        }

        return $rules;
    }
}