<?php

namespace App\Http\Requests\Activity;

use App\Enums\ActivityPriorityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date', 'after:now'],
            'priority' => ['required', new Enum(ActivityPriorityEnum::class)],
            'assigned_to_user_id' => ['required', 'exists:users,id'],
            'customer_id' => ['nullable', 'required_without:opportunity_id', 'exists:customers,id'],
            'opportunity_id' => ['nullable', 'required_without:customer_id', 'exists:opportunities,id'],
        ];
    }
}