<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Product;

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

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $stripeToken = \Stripe\Token::create([
            "card" => [
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => 2018,
                "cvc" => "123"
            ]
        ]);

        $this->actingAs($user)->post('/cart', [
            'quantity' => 1,
            'product_id' => $product->id
        ]);

        $response = $this->actingAs($user)->post('/purchases', [
            'stripeToken' => $stripeToken,
            'stripeTokenType' => 'card',
            'stripeEmail' => $user->email
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('status', 'Purchase was successful!');
    }
}
