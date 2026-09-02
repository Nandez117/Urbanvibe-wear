<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Review Attributes
 * $this->attributes['id'] - int - contains the review primary key
 * $this->attributes['rating'] - int - contains the product rating
 * $this->attributes['comment'] - string - contains the review comment
 * $this->attributes['creationDate'] - date - contains the review creation date
 * $this->attributes['user_id'] - int - contains the reviewer foreign key
 * $this->attributes['product_id'] - int - contains the reviewed product foreign key
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'creationDate',
        'user_id',
        'product_id',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'creationDate' => 'date',
        ];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setRating(int $rating): void
    {
        $this->attributes['rating'] = $rating;
    }

    public function setComment(?string $comment): void
    {
        $this->attributes['comment'] = $comment;
    }

    public function setCreationDate(string $creationDate): void
    {
        $this->attributes['creationDate'] = $creationDate;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getRating(): int
    {
        return (int) $this->attributes['rating'];
    }

    public function getComment(): ?string
    {
        return $this->attributes['comment'] ?? null;
    }

    public function getCreationDate(): string
    {
        return $this->attributes['creationDate'];
    }

    public function getUserId(): int
    {
        return (int) $this->attributes['user_id'];
    }

    public function getProductId(): int
    {
        return (int) $this->attributes['product_id'];
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
        $this->product()->associate($product);
    }
}
