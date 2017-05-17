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

                            <?php foreach(\Gloudemans\Shoppingcart\Facades\Cart::content() as $row) :?>

                                <tr>
                                    <td>
                                        <p><?php echo $row->name; ?></p>
                                    </td>
                                    <td><?php echo $row->qty; ?></td>
                                    <td>$<?php echo $row->price; ?></td>
                                    <td>$<?php echo $row->total; ?></td>
                                </tr>

                            <?php endforeach;?>

                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>Subtotal</td>
                                <td><?php echo \Gloudemans\Shoppingcart\Facades\Cart::subtotal(); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td>Tax</td>
                                <td><?php echo \Gloudemans\Shoppingcart\Facades\Cart::tax(); ?></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td><strong>Total</strong></td>
                                <td><strong><?php echo \Gloudemans\Shoppingcart\Facades\Cart::total(); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
