<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'payer' => ['required', 'exists:users,id'],
            'payee' => ['required', 'exists:users,id'],
            'value' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'payer.required' => 'The payer field is required.',
            'payer.exists' => 'The selected payer is invalid.',
            'payee.required' => 'The payee field is required.',
            'payee.exists' => 'The selected payee is invalid.',
            'value.required' => 'The value field is required.',
            'value.numeric' => 'The value must be a number.',
            'value.min' => 'The value must be at least 0.01.',
        ];
    }
}
