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
     * User, Product 
     *
     * @var User $user
     * @var Product $product
     */
    protected $user, $product;

    /**
     * Set up
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->product = factory(Product::class)->create();
    }

    /**
     * User can add product to cart.
     *
     * @return void
     */
    public function testUserCanAddProductToCart()
    {
        $response = $this->actingAs($this->user)->post('/cart', [
            'quantity' => 1,
            'product_id' => $this->product->id
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
        $response = $this->post('/cart', [
            'quantity' => 1,
            'product_id' => $this->product->id
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
        $this->actingAs($this->user)->post('/cart', [
            'quantity' => 1,
            'product_id' => $this->product->id
        ]);

        $response = $this->actingAs($this->user)->get('/cart');

        $response->assertSee($this->product->name);
    }
}
