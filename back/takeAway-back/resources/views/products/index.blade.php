@extends('layouts.app')

@section('content')
    <h1>Product List</h1>
    <a href="{{ route('products.create') }}">Crear un nou producte</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category ID</th>
                <th>Size ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td><img src="{{ asset($product->image) }}" alt="{{ $product->title }}" width="50"></td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->size_id }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}">Editar</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Estàs segur d\'eliminar el producte?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


<!-- http://127.0.0.1:8000/products -->