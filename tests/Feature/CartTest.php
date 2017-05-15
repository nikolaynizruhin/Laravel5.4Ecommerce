<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Product;

class CartTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * User can add product to cart.
     *
     * @return void
     */
    public function testUserCanAddProductToCart()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $response = $this->actingAs($user)->post('/cart', [
            'quantity' => 1,
            'product_id' => $product->id
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('status', 'Product successfully added to cart!');
    }
}
