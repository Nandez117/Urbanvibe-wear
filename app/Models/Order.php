<?php

// Esteban Alvarez Garcia

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

/**
 * ORDER ATTRIBUTES
 * $this->attributes['id'] - int - contains the order primary key (id)
 * $this->attributes['order_number'] - string - contains the unique order number
 * $this->attributes['total_amount'] - float - contains the order total amount
 * $this->attributes['status'] - string - contains the order status
 * $this->attributes['user_id'] - int - contains the referenced user id
 * $this->attributes['created_at'] - datetime - contains the order creation date
 * $this->attributes['updated_at'] - datetime - contains the order update date
 * $this->user - User - contains the associated User
 * $this->items - Collection - contains the associated order items
 * $this->payment - Payment - contains the associated payment
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'total_amount',
        'status',
        'user_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
        ];
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'order_number' => 'nullable|string|max:50',
            'total_amount' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:pending,paid,cancelled',
            'user_id' => 'nullable|exists:users,id',
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

    public function getOrderNumber(): string
    {
        return $this->attributes['order_number'];
    }

    public function setOrderNumber(string $orderNumber): void
    {
        $this->attributes['order_number'] = $orderNumber;
    }

    public function getTotalAmount(): float
    {
        return (float) $this->attributes['total_amount'];
    }

    public function setTotalAmount(float $totalAmount): void
    {
        $this->attributes['total_amount'] = $totalAmount;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function getUserId(): int
    {
        return (int) $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
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

    public function setItems(Collection $items): void
    {
        $this->setRelation('items', $items);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): void
    {
        $this->setRelation('payment', $payment);
    }
}
