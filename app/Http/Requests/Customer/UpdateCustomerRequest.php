<?php

namespace App\Http\Requests\Customer;

<<<<<<< HEAD
use Illuminate\Contracts\Validation\ValidationRule;
=======
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
<<<<<<< HEAD
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
=======
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('customer');

        return [
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:customers,email,' . $customerId,
            'phone'    => 'nullable|string|max:20',
            'tax_code' => 'nullable|string|max:50',
            'address'  => 'nullable|string|max:500',
        ];
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
