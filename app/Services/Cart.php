<?php

// Yan Frank Ríos López

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart
{
    private const SESSION_KEY = 'cart';

    public function addProduct(int $productId, int $quantity): void
    {
        $items = $this->getRawItems();
        $currentQuantity = $items[$productId] ?? 0;
        $items[$productId] = $currentQuantity + $quantity;
        Session::put($this->getSessionKey(), $items);
    }

    public function updateQuantity(int $productId, int $quantity): void
    {
        $items = $this->getRawItems();

        if (! array_key_exists($productId, $items)) {
            return;
        }

        $items[$productId] = $quantity;
        Session::put($this->getSessionKey(), $items);
    }

    public function removeProduct(int $productId): void
    {
        $items = $this->getRawItems();
        unset($items[$productId]);
        Session::put($this->getSessionKey(), $items);
    }

    public function clear(): void
    {
        Session::forget($this->getSessionKey());
    }

    public function getItems(): array
    {
        $cartItems = [];

        foreach ($this->getRawItems() as $productId => $quantity) {
            $product = Product::find($productId);

            if (! $product) {
                continue;
            }

            $cartItems[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => round($product->getPrice() * $quantity, 2),
            ];
        }

        return $cartItems;
    }

    public function getTotal(): float
    {
        $total = 0.0;

        foreach ($this->getItems() as $item) {
            $total += $item['subtotal'];
        }

        return round($total, 2);
    }

    public function getCount(): int
    {
        return array_sum($this->getRawItems());
    }

    private function getRawItems(): array
    {
        return Session::get($this->getSessionKey(), []);
    }

    private function getSessionKey(): string
    {
        return Auth::check()
            ? self::SESSION_KEY.'_user_'.Auth::id()
            : self::SESSION_KEY.'_guest';
    }
}
