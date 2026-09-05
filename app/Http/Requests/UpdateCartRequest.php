<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = Product::find($this->route('id'));
        $maxStock = $product ? $product->getStock() : 1;

        return [
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$maxStock],
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.max' => 'No hay suficiente stock disponible para esa cantidad.',
        ];
    }
}
