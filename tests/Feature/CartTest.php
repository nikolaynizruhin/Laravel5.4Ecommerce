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

    /**
     * Only auth user can add product to cart.
     *
     * @return void
     */
    public function testOnlyAuthUserCanAddProductToCart()
    {
        $product = factory(Product::class)->create();

        $response = $this->post('/cart', [
            'quantity' => 1,
            'product_id' => $product->id
        ]);

        $response->assertRedirect('/login');
    }

    /**
     * User can see products in the cart.
     *
     * @return void
     */
    public function testUserCanSeeProductsInTheCart()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $this->actingAs($user)->post('/cart', [
            'quantity' => 1,
            'product_id' => $product->id
        ]);

        $response = $this->actingAs($user)->get('/cart');

        $response->assertSee($product->name);
    }
}
