<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'type' => ['required', Rule::in(['leave', 'reimbursement', 'other'])],
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'Type must be one of: leave, reimbursement, other.',
        ];
    }
}
