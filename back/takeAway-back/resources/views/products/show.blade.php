@extends('layouts.app')

@section('content')
    <h1>Product Details</h1>

    <div>
        <h2>{{ $product->title }}</h2>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
        <p><strong>Category ID:</strong> {{ $product->category_id }}</p>
        <p><strong>Size ID:</strong> {{ $product->size_id }}</p>
        <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" width="200">
    </div>

    <a href="{{ route('products.index') }}">Tornar a la llista de productes</a>
@endsection

