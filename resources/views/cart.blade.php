@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cart</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach(\Gloudemans\Shoppingcart\Facades\Cart::content() as $row)

                                <tr>
                                    <td>
                                        <p>{{ $row->name }}</p>
                                    </td>
                                    <td>{{ $row->qty }}</td>
                                    <td>${{ $row->price }}</td>
                                    <td>${{ $row->total }}</td>
                                </tr>

                            @endforeach

                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>Subtotal</td>
                                <td>{{ \Gloudemans\Shoppingcart\Facades\Cart::subtotal() }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>Tax</td>
                                <td>{{ \Gloudemans\Shoppingcart\Facades\Cart::tax() }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td><strong>Total</strong></td>
                                <td><strong>{{ \Gloudemans\Shoppingcart\Facades\Cart::total() }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <form action="/purchases" method="POST">
                        {{ csrf_field() }}

                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ config('services.stripe.key') }}"
                            data-amount="{{ str_replace('.', '', \Gloudemans\Shoppingcart\Facades\Cart::total()) }}"
                            data-email="{{ Auth::user()->email }}"
                            data-name="Products"
                            data-description="Description"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto"
                            data-zip-code="true">
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
