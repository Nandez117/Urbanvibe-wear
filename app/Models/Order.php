<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Order Attributes
 * $this->attributes['id'] - int - contains the order primary key
 * $this->attributes['orderNumber'] - string - contains the unique order number
 * $this->attributes['creationDate'] - date - contains the order creation date
 * $this->attributes['totalAmount'] - float - contains the order total amount
 * $this->attributes['status'] - string - contains the order status
 * $this->attributes['user_id'] - int - contains the customer foreign key
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderNumber',
        'creationDate',
        'totalAmount',
        'status',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'creationDate' => 'date',
            'totalAmount' => 'decimal:2',
        ];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setOrderNumber(string $orderNumber): void
    {
        $this->attributes['orderNumber'] = $orderNumber;
    }

    public function setCreationDate(string $creationDate): void
    {
        $this->attributes['creationDate'] = $creationDate;
    }

    public function setTotalAmount(float $totalAmount): void
    {
        $this->attributes['totalAmount'] = $totalAmount;
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
        return $this->attributes['orderNumber'];
    }

    public function getCreationDate(): string
    {
        return $this->attributes['creationDate'];
    }

    public function getTotalAmount(): float
    {
        return (float) $this->attributes['totalAmount'];
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
