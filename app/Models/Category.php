<?php

// Autor: Juan Manuel Hernandez Martelo

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Category Attributes
 * $this->attributes['id'] - int - contains the category primary key (id)
 * $this->attributes['name'] - string - contains the category name
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
 * $this->products - Collection - contains the products relation
 */
class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function setProducts(Collection $products): void
    {
        $this->products = $products;
    }
}
