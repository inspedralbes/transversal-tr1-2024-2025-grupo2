@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Editar Producto</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $product->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" name="description" id="description" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen (URL)</label>
            <input type="text" class="form-control" name="image" id="image" value="{{ old('image', $product->image) }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-select" name="category_id" id="category_id" required>
                <option value="">Selecciona una Categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->category_id }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="size_id" class="form-label">Tamaño</label>
            <select class="form-select" name="size_id" id="size_id" required>
                <option value="">Selecciona un Tamaño</option>
                @foreach ($sizes as $size)
                    <option value="{{ $size->id }}" {{ $size->id == $product->size_id ? 'selected' : '' }}>
                        {{ $size->size_id }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Actualizar Producto</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver a la lista de productos</a>
    </form>
</div>
@endsection
