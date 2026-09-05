<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Payment Attributes
 * $this->attributes['id'] - int - contains the payment primary key
 * $this->attributes['reference'] - string - contains the unique transaction reference
 * $this->attributes['method'] - string - contains the payment method
 * $this->attributes['amount'] - float - contains the payment amount
 * $this->attributes['status'] - string - contains the payment status
 * $this->attributes['order_id'] - int - contains the order foreign key
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
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

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setReference(string $reference): void
    {
        $this->attributes['reference'] = $reference;
    }

    public function setMethod(string $method): void
    {
        $this->attributes['method'] = $method;
    }

    public function setAmount(float $amount): void
    {
        $this->attributes['amount'] = $amount;
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
    }

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getReference(): string
    {
        return $this->attributes['reference'];
    }

    public function getMethod(): string
    {
        return $this->attributes['method'];
    }

    public function getAmount(): float
    {
        return (float) $this->attributes['amount'];
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function getOrderId(): int
    {
        return (int) $this->attributes['order_id'];
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