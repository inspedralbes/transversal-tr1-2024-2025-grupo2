@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Crear Producto</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen (URL)</label>
            <input type="text" class="form-control" name="image" id="image" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-select" name="category_id" id="category_id" required>
                <option value="">Selecciona una Categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_id }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="size_id" class="form-label">Tamaño</label>
            <select class="form-select" name="size_id" id="size_id" required>
                <option value="">Selecciona un Tamaño</option>
                @foreach ($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->size_id }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Crear Producto</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver a la lista de productos</a>
    </form>
</div>
@endsection
