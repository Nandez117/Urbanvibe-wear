<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Product Attributes
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
 * $this->attributes['category_id'] - int - contains the product category id
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
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

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }
}
