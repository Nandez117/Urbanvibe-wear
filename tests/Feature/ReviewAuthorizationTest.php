<?php

// Autorización de reseñas: cada cliente ve/edita/borra solo las suyas; el admin, todas.

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function makeProduct(): Product
    {
        $category = Category::factory()->create();

        return Product::factory()->create(['category_id' => $category->getId()]);
    }

    private function makeReview(User $user, Product $product): Review
    {
        $review = new Review;
        $review->setRating(5);
        $review->setComment('Reseña de '.$user->getName());
        $review->setUserId($user->getId());
        $review->setProductId($product->getId());
        $review->save();

        return $review;
    }

    /** Las rutas de reseñas exigen autenticación. */
    public function test_reviews_index_requires_authentication(): void
    {
        $this->get('/reviews')->assertRedirect(route('login.index'));
    }

    /** Un cliente solo ve sus propias reseñas en el listado. */
    public function test_client_sees_only_their_own_reviews(): void
    {
        $product = $this->makeProduct();
        $owner = User::factory()->create(['role' => 'client']);
        $other = User::factory()->create(['role' => 'client']);

        $ownReview = $this->makeReview($owner, $product);
        $otherReview = $this->makeReview($other, $product);

        $html = $this->actingAs($owner)->get('/reviews')->assertOk()->getContent();

        // La fila de edición de su reseña está presente y la ajena no.
        $this->assertStringContainsString('/reviews/'.$ownReview->getId().'/edit', $html);
        $this->assertStringNotContainsString('/reviews/'.$otherReview->getId().'/edit', $html);
    }

    /** Un admin ve todas las reseñas en el listado. */
    public function test_admin_sees_all_reviews(): void
    {
        $product = $this->makeProduct();
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $adminReview = $this->makeReview($admin, $product);
        $clientReview = $this->makeReview($client, $product);

        $html = $this->actingAs($admin)->get('/reviews')->assertOk()->getContent();

        $this->assertStringContainsString('/reviews/'.$adminReview->getId().'/edit', $html);
        $this->assertStringContainsString('/reviews/'.$clientReview->getId().'/edit', $html);
    }

    /** Un cliente NO puede borrar la reseña de otro (403). */
    public function test_client_cannot_delete_another_users_review(): void
    {
        $product = $this->makeProduct();
        $owner = User::factory()->create(['role' => 'client']);
        $attacker = User::factory()->create(['role' => 'client']);

        $review = $this->makeReview($owner, $product);

        $this->actingAs($attacker)
            ->delete('/reviews/'.$review->getId())
            ->assertForbidden();

        $this->assertDatabaseHas('reviews', ['id' => $review->getId()]);
    }

    /** Un cliente SÍ puede borrar su propia reseña. */
    public function test_client_can_delete_own_review(): void
    {
        $product = $this->makeProduct();
        $owner = User::factory()->create(['role' => 'client']);

        $review = $this->makeReview($owner, $product);

        $this->actingAs($owner)
            ->delete('/reviews/'.$review->getId())
            ->assertRedirect(route('review.index'));

        $this->assertDatabaseMissing('reviews', ['id' => $review->getId()]);
    }

    /** Un admin puede borrar la reseña de cualquier usuario. */
    public function test_admin_can_delete_any_review(): void
    {
        $product = $this->makeProduct();
        $admin = User::factory()->create(['role' => 'admin']);
        $client = User::factory()->create(['role' => 'client']);

        $review = $this->makeReview($client, $product);

        $this->actingAs($admin)
            ->delete('/reviews/'.$review->getId())
            ->assertRedirect(route('review.index'));

        $this->assertDatabaseMissing('reviews', ['id' => $review->getId()]);
    }

    /** Al crear una reseña, el user_id siempre es el del usuario autenticado. */
    public function test_store_binds_review_to_authenticated_user(): void
    {
        $product = $this->makeProduct();
        $owner = User::factory()->create(['role' => 'client']);
        $other = User::factory()->create(['role' => 'client']);

        $this->actingAs($owner)->post('/reviews', [
            // Intento de suplantar a otro usuario: debe ignorarse.
            'user_id' => $other->getId(),
            'product_id' => $product->getId(),
            'rating' => 4,
            'comment' => 'Reseña honesta',
        ]);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $owner->getId(),
            'product_id' => $product->getId(),
            'comment' => 'Reseña honesta',
        ]);
        $this->assertDatabaseMissing('reviews', [
            'user_id' => $other->getId(),
            'comment' => 'Reseña honesta',
        ]);
    }
}
