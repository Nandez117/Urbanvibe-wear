<?php

// Esteban Alvarez Garcia

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

/**
 * REVIEW ATTRIBUTES
 * $this->attributes['id'] - int - contains the review primary key (id)
 * $this->attributes['rating'] - int - contains the product rating
 * $this->attributes['comment'] - string - contains the review comment
 * $this->attributes['user_id'] - int - contains the referenced user id
 * $this->attributes['product_id'] - int - contains the referenced product id
 * $this->attributes['created_at'] - datetime - contains the review creation date
 * $this->attributes['updated_at'] - datetime - contains the review update date
 * $this->user - User - contains the associated User
 * $this->product - Product - contains the associated Product
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'product_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    public static function validate(Request $request): void
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
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

    public function getRating(): int
    {
        return (int) $this->attributes['rating'];
    }

    public function setRating(int $rating): void
    {
        $this->attributes['rating'] = $rating;
    }

    public function getComment(): ?string
    {
        return $this->attributes['comment'] ?? null;
    }

    public function setComment(?string $comment): void
    {
        $this->attributes['comment'] = $comment;
    }

    public function getUserId(): int
    {
        return (int) $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getProductId(): int
    {
        return (int) $this->attributes['product_id'];
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
