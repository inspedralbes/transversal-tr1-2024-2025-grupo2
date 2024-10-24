@extends('layouts.app')

@section('content')
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" required>{{ old('description', $product->description) }}</textarea>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" required>

        <label for="image">Image</label>
        <input type="text" name="image" id="image" value="{{ old('image', $product->image) }}" required>

        <label for="category_id">Category ID</label>
        <select name="category_id" id="category_id">
            <option value="">Select a Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                    {{ $category->category_id }}
                </option>
            @endforeach
        </select>

        <label for="size_id">Size ID</label>
        <select name="size_id" id="size_id">
            <option value="">Select a Size</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}" {{ $size->id == $product->size_id ? 'selected' : '' }}>
                    {{ $size->size_id }}
                </option>
            @endforeach
        </select>

        <button type="submit">Update</button>
    </form>
@endsection
