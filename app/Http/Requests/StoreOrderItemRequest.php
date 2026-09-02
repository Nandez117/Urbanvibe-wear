<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|integer|exists:products,id',
            'order_id' => 'required|integer|exists:orders,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('quantity') && $this->filled('product_id')) {
            $product = Product::find($this->input('product_id'));

            if ($product !== null && (int) $this->input('quantity') > $product->getStock()) {
                $this->merge(['quantity' => null]);
            }
        }
    }
}
