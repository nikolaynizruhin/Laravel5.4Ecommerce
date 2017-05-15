@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @foreach ($products->chunk(3) as $productChunk)
        <div class="row">
            @foreach ($productChunk as $product)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        <div class="caption">
                            <h4>
                                {{ ucfirst($product->name) }}
                                <span class="pull-right">
                                    ${{ $product->price }}
                                </span>
                            </h4>
                            <p>{{ $product->description }}</p>
                            <p>
                                <form class="form-inline" method="POST" action="/cart">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <select class="form-control" name="quantity">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-default">Add to cart</button>
                                </form>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection
