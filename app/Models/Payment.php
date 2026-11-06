<?php

// Yan Frank Ríos López

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

/**
 * PAYMENT ATTRIBUTES
 * $this->attributes['id'] - int - contains the payment primary key (id)
 * $this->attributes['reference'] - string - contains the transaction reference
 * $this->attributes['method'] - string - contains the payment method
 * $this->attributes['amount'] - float - contains the payment amount
 * $this->attributes['status'] - string - contains the payment status
 * $this->attributes['order_id'] - int - contains the referenced order id
 * $this->attributes['created_at'] - datetime - contains the payment creation date
 * $this->attributes['updated_at'] - datetime - contains the payment update date
 * $this->order - Order - contains the associated Order
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'method',
        'amount',
        'status',
        'order_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'method' => 'required|in:credit_card,paypal',
            'amount' => 'required|numeric|min:0.01',
            'card_number' => 'nullable|string|min:13|max:19',
            'card_cvv' => 'nullable|string|min:3|max:4',
            'card_expiration' => 'nullable|string',
            'paypal_email' => 'nullable|email',
        ]);
    }

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getReference(): string
    {
        return $this->attributes['reference'];
    }

    public function setReference(string $reference): void
    {
        $this->attributes['reference'] = $reference;
    }

    public function getMethod(): string
    {
        return $this->attributes['method'];
    }

    public function setMethod(string $method): void
    {
        $this->attributes['method'] = $method;
    }

    public function getAmount(): float
    {
        return (float) $this->attributes['amount'];
    }

    public function setAmount(float $amount): void
    {
        $this->attributes['amount'] = $amount;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function getOrderId(): int
    {
        return (int) $this->attributes['order_id'];
    }

    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order()->associate($order);
    }
}
