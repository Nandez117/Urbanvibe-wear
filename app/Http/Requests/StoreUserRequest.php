<?php

// Juan Manuel Hernandez Martelo

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            
        ];
    }
}
