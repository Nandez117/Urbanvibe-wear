<?php

// Autor: Juan Manuel Hernandez Martelo

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Wishlist Attributes
 * $this->attributes['id'] - int - contains the wishlist primary key
 * $this->attributes['user_id'] - int - contains the user foreign key
 * $this->attributes['product_id'] - int - contains the product foreign key
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
 *
 * user: User
 * product: Product
 * $this->user - User - contains the user relation
 * $this->product - Product - contains the product relation
 */
class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function getProductId(): int
    {
        return $this->attributes['product_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
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
        $this->user = $user;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}
