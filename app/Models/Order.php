<?php

// Autor: Esteban Alvarez Garcia

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Order Attributes
 * $this->attributes['id'] - int - contains the order primary key
 * $this->attributes['order_number'] - string - contains the unique order number
 * $this->attributes['total_amount'] - float - contains the order total amount
 * $this->attributes['status'] - string - contains the order status
 * $this->attributes['user_id'] - int - contains the customer foreign key
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
 */
class Order extends Model
{
    protected $fillable = [
        'order_number',
        'total_amount',
        'status',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    public function setOrderNumber(string $orderNumber): void
    {
        $this->attributes['order_number'] = $orderNumber;
    }

    public function setTotalAmount(float $totalAmount): void
    {
        $this->attributes['total_amount'] = $totalAmount;
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getOrderNumber(): string
    {
        return $this->attributes['order_number'];
    }

    public function getTotalAmount(): float
    {
        return (float) $this->attributes['total_amount'];
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function getUserId(): int
    {
        return (int) $this->attributes['user_id'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user()->associate($user);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }
}
