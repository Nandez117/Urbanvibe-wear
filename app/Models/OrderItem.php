<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * OrderItem Attributes
 * $this->attributes['id'] - int - contains the order item primary key
 * $this->attributes['quantity'] - int - contains the purchased quantity
 * $this->attributes['subtotal'] - float - contains the calculated subtotal
 * $this->attributes['unitPrice'] - float - contains the product unit price
 * $this->attributes['product_id'] - int - contains the product foreign key
 * $this->attributes['order_id'] - int - contains the order foreign key
 * $this->attributes['created_at'] - datetime - contains the creation timestamp
 * $this->attributes['updated_at'] - datetime - contains the update timestamp
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'subtotal',
        'unitPrice',
        'product_id',
        'order_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'subtotal' => 'decimal:2',
            'unitPrice' => 'decimal:2',
        ];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function setQuantity(int $quantity): void
    {
        $this->attributes['quantity'] = $quantity;
    }

    public function setSubtotal(float $subtotal): void
    {
        $this->attributes['subtotal'] = $subtotal;
    }

    public function setUnitPrice(float $unitPrice): void
    {
        $this->attributes['unitPrice'] = $unitPrice;
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
    }

    public function getId(): int
    {
        return (int) $this->attributes['id'];
    }

    public function getQuantity(): int
    {
        return (int) $this->attributes['quantity'];
    }

    public function getSubtotal(): float
    {
        return (float) $this->attributes['subtotal'];
    }

    public function getUnitPrice(): float
    {
        return (float) $this->attributes['unitPrice'];
    }

    public function getProductId(): int
    {
        return (int) $this->attributes['product_id'];
    }

    public function getOrderId(): int
    {
        return (int) $this->attributes['order_id'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    public function calculateSubtotal(): float
    {
        return round($this->getQuantity() * $this->getUnitPrice(), 2);
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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order()->associate($order);
    }
}
