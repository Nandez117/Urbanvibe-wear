<?php

// Juan Manuel Hernandez Martelo

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * CATEGORY ATTRIBUTES
 * $this->attributes['id'] - int - contains the category primary key (id)
 * $this->attributes['name'] - string - contains the category name
 * $this->attributes['created_at'] - datetime - contains the category creation date
 * $this->attributes['updated_at'] - datetime - contains the category update date
 * $this->products - Collection - contains the associated products
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public static function validate(Request $request): void
    {
        $id = $request->route('id');
        $uniqueRule = $id ? 'unique:categories,name,'.$id : 'unique:categories,name';

        $request->validate([
            'name' => 'required|string|max:255|'.$uniqueRule,
        ]);
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

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
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
        $this->setRelation('products', $products);
    }
}
