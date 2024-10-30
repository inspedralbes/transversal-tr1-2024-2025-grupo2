@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Detalles del Producto</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">{{ $product->title }}</h2>
            <p class="card-text"><strong>Descripción:</strong> {{ $product->description }}</p>
            <p class="card-text"><strong>Precio:</strong> ${{ number_format($product->price, 2) }}</p>
            <p class="card-text"><strong>ID de Categoría:</strong> {{ $product->category_id }}</p>
            <p class="card-text"><strong>ID de Tamaño:</strong> {{ $product->size_id }}</p>
            <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="img-fluid" width="200">
        </div>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver a la lista de productos</a>
</div>
@endsection
