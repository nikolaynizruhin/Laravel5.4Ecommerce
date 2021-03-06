<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Product;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * User can see products.
     *
     * @return void
     */
    public function testUserCanSeeProducts()
    {
        $product = factory(Product::class)->create();

        $response = $this->get('/products');

        $response->assertSee($product->name);
        $response->assertSee($product->description);
        $response->assertStatus(200);
    }
}
