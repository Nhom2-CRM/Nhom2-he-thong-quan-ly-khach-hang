<?php

namespace App\Http\Requests\Activity;

use App\Enums\ActivityStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateActivityStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(ActivityStatusEnum::class)],
            'postpone_reason' => [
                'required_if:status,' . ActivityStatusEnum::POSTPONED->value,
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }
}