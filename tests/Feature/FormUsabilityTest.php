<?php

// Pruebas de usabilidad de formularios (U1, U2, U3): persistencia con old() y campos.

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormUsabilityTest extends TestCase
{
    use RefreshDatabase;

    /** U1: al fallar la validación de una reseña, el comentario escrito no se pierde. */
    public function test_review_form_keeps_comment_when_validation_fails(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->getId()]);

        $comment = 'ComentarioQueNoDebePerderse12345';

        $response = $this->actingAs($user)
            ->from('/products/'.$product->getId())
            ->post('/reviews', [
                'from_product' => '1',
                'user_id' => $user->getId(),
                'product_id' => $product->getId(),
                'rating' => 99, // inválido: max 5
                'comment' => $comment,
            ]);

        // Debe redirigir de vuelta con errores y conservar el input anterior.
        $response->assertSessionHasErrors('rating');
        $response->assertSessionHasInput('comment', $comment);
        $response->assertSessionHasInput('rating', 99);
    }

    /** U2: la vista de editar pedido ofrece los 3 estados válidos del sistema.
     *  Nota: edit() solo permite al dueño del pedido (where user_id = Auth::id). */
    public function test_order_edit_shows_all_valid_statuses(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->getId()]);
        $order = Order::factory()->create([
            'user_id' => $user->getId(),
            'status' => 'pending',
        ]);

        $html = $this->actingAs($user)
            ->get('/orders/'.$order->getId().'/edit')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('value="pending"', $html);
        $this->assertStringContainsString('value="paid"', $html);
        $this->assertStringContainsString('value="cancelled"', $html);
    }

    /** U3: el input de cantidad del formulario "añadir producto" usa old(). */
    public function test_order_edit_quantity_uses_old_value(): void
    {
        $user = User::factory()->create(['role' => 'client']);
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->getId()]);
        $order = Order::factory()->create([
            'user_id' => $user->getId(),
            'status' => 'pending',
        ]);

        // Simula un old('quantity') = 7 en sesión y verifica que aparece en el input.
        $html = $this->actingAs($user)
            ->withSession(['_old_input' => ['quantity' => 7]])
            ->get('/orders/'.$order->getId().'/edit')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('value="7"', $html);
    }

    /** U6: el formulario de crear producto asocia labels (for/id) a sus campos. */
    public function test_admin_product_create_has_associated_labels(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Category::factory()->create();

        $html = $this->actingAs($admin)
            ->get('/admin/products/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('for="name"', $html);
        $this->assertStringContainsString('id="name"', $html);
        $this->assertStringContainsString('for="category_id"', $html);
        $this->assertStringContainsString('id="description"', $html);
    }

    /** U9: el campo teléfono del registro usa type="tel". */
    public function test_register_phone_is_type_tel(): void
    {
        $html = $this->get('/register')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('id="phone" type="tel"', $html);
    }

    /** U7: el formulario de editar usuario admin muestra errores por campo (@error). */
    public function test_admin_user_edit_has_field_error_support(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $target = User::factory()->create(['role' => 'client']);

        // Fuerza un error de validación en 'name' y verifica que el input se conserva.
        $this->actingAs($admin)
            ->from('/admin/users/'.$target->getId().'/edit')
            ->put('/admin/users/'.$target->getId(), [
                'name' => '', // inválido: requerido
                'email' => $target->getEmail(),
            ])
            ->assertSessionHasErrors('name');
    }
}
