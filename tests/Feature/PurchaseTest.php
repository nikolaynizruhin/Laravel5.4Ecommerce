<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Product;
use Facades\App\Billing\Stripe\{Charge, Customer};

class PurchaseTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Only auth user can make purchases.
     *
     * @return void
     */
    public function testOnlyAuthUserCanMakePurchases()
    {
        $this->post('/purchases')
            ->assertRedirect('/login');
    }

    /**
     * User can make purchases.
     *
     * @return void
     */
    public function testUserCanMakePurchases()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        Customer::shouldReceive('create')->once()->andReturn($user);
        Charge::shouldReceive('create')->once();

        $this->actingAs($user)->post('/cart', [
            'quantity' => 1,
            'product_id' => $product->id
        ]);

        $response = $this->actingAs($user)->post('/purchases', [
            'stripeToken' => 'token',
            'stripeTokenType' => 'card',
            'stripeEmail' => $user->email
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('status', 'Purchase was successful!');
    }
}
