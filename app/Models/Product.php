<?php

// Juan Manuel Hernandez Martelo

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * PRODUCT ATTRIBUTES
 * $this->attributes['id'] - int - contains the product primary key (id)
 * $this->attributes['name'] - string - contains the product name
 * $this->attributes['description'] - string - contains the product description
 * $this->attributes['price'] - float - contains the product price
 * $this->attributes['discount'] - float - contains the product discount
 * $this->attributes['size'] - string - contains the product size
 * $this->attributes['color'] - string - contains the product color
 * $this->attributes['material'] - string - contains the product material
 * $this->attributes['stock'] - int - contains the product stock
 * $this->attributes['image'] - string - contains the product image
 * $this->attributes['category_id'] - int - contains the referenced category id
 * $this->attributes['created_at'] - datetime - contains the product creation date
 * $this->attributes['updated_at'] - datetime - contains the product update date
 * $this->category - Category - contains the associated Category
 * $this->reviews - Collection - contains the associated reviews
 * $this->orderItems - Collection - contains the associated order items
 * $this->wishlists - Collection - contains the associated wishlists
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount',
        'size',
        'color',
        'material',
        'stock',
        'image',
        'category_id',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public static function validate(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|gt:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'size' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:50',
            'material' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    }

    public static function sumPricesByQuantities(iterable $products, array $productsInSession): float
    {
        $total = 0;
        foreach ($products as $product) {
            $quantity = $productsInSession[$product->getId()] ?? 0;
            $total += ($product->getFinalPrice() * $quantity);
        }

        return round($total, 2);
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getPrice(): float
    {
        return (float) $this->attributes['price'];
    }

    public function setPrice(float $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getDiscount(): float
    {
        return (float) $this->attributes['discount'];
    }

    public function setDiscount(float $discount): void
    {
        $this->attributes['discount'] = $discount;
    }

    public function getSize(): ?string
    {
        return $this->attributes['size'] ?? null;
    }

    public function setSize(?string $size): void
    {
        $this->attributes['size'] = $size;
    }

    public function getColor(): ?string
    {
        return $this->attributes['color'] ?? null;
    }

    public function setColor(?string $color): void
    {
        $this->attributes['color'] = $color;
    }

    public function getMaterial(): ?string
    {
        return $this->attributes['material'] ?? null;
    }

    public function setMaterial(?string $material): void
    {
        $this->attributes['material'] = $material;
    }

    public function getStock(): int
    {
        return (int) $this->attributes['stock'];
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function getImage(): ?string
    {
        return $this->attributes['image'] ?? null;
    }

    public function setImage(?string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getCategoryId(): int
    {
        return (int) $this->attributes['category_id'];
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->attributes['category_id'] = $categoryId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function getFinalPrice(): float
    {
        $price = $this->getPrice();
        $discount = $this->getDiscount();

        if ($discount > 0) {
            return round($price - ($price * ($discount / 100)), 2);
        }

        return $price;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category()->associate($category);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function setReviews(Collection $reviews): void
    {
        $this->setRelation('reviews', $reviews);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function setOrderItems(Collection $orderItems): void
    {
        $this->setRelation('orderItems', $orderItems);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function getWishlists(): Collection
    {
        return $this->wishlists;
    }

    public function setWishlists(Collection $wishlists): void
    {
        $this->setRelation('wishlists', $wishlists);
    }
}
