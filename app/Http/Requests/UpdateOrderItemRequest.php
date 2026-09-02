<?php

namespace App\Http\Requests;

use App\Models\OrderItem;
use Illuminate\Contracts\Validation\Validator;

class UpdateOrderItemRequest extends StoreOrderItemRequest
{
    public function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1',
            'order_id' => 'required|integer|exists:orders,id',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $orderItem = OrderItem::with('product')->find($this->route('id'));

                if ($orderItem !== null && $this->filled('quantity')) {
                    $availableStock = $orderItem->getProduct()->getStock() + $orderItem->getQuantity();

                    if ((int) $this->input('quantity') > $availableStock) {
                        $validator->errors()->add('quantity', 'La cantidad supera el stock disponible.');
                    }
                }
            },
        ];
    }
}
