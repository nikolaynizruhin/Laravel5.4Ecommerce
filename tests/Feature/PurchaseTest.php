<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseTest extends TestCase
{
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
}
