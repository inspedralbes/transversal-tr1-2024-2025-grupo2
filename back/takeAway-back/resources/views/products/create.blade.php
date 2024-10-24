@extends('layouts.app')

@section('content')
    <h1>Create Product</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description</label>
        <textarea name="description" id="description" required></textarea>

        <label for="price">Price</label>
        <input type="number" name="price" id="price" step="0.01" required>

        <label for="image">Image</label>
        <input type="text" name="image" id="image" required>

        <label for="category_id">Category ID</label>
        <select name="category_id" id="category_id">
            <option value="">Select a Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_id }}</option>
            @endforeach
        </select>

        <label for="size_id">Size ID</label>
        <select name="size_id" id="size_id">
            <option value="">Select a Size</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->size_id }}</option>
            @endforeach
        </select>

        <button type="submit">Create</button>
    </form>
@endsection
