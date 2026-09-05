<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:0',
            'method' => 'required|string|max:255',
            'reference' => 'required|string|unique:payments,reference',
        ];
    }

    public function messages(): array
    {
        return [
            'reference.unique' => 'Esta referencia de transacción ya fue registrada.',
        ];
    }
}
