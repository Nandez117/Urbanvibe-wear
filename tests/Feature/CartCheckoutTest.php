<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_pending_order_and_redirects_to_payment(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->getId(),
            'price' => 25.00,
            'stock' => 10,
        ]);

        $this->actingAs($user)
            ->post('/cart/add/'.$product->getId(), ['quantity' => 2])
            ->assertRedirect('/cart');

        $response = $this->post('/cart/checkout');
        $order = Order::query()->where('user_id', $user->getId())->firstOrFail();

        $response->assertRedirect(route('payment.create', ['id' => $order->getId()]));
        $this->assertSame('pending', $order->getStatus());
        $this->assertSame(50.0, $order->getTotalAmount());
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->getId(),
            'product_id' => $product->getId(),
            'quantity' => 2,
        ]);
        $this->assertSame(0, app(Cart::class)->getCount());
    }
}
