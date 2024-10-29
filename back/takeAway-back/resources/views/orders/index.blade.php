@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Lista de Comandas</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Precio Final</th>
                <th>Productos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>€{{ number_format($order->finalprice, 2) }}</td>
                    <td>
                        <ul>
                            @foreach ($order->products as $product)
                                <li>{{ $product->title }} - Cantidad: {{ $product->pivot->quantity }} - Precio: €{{ number_format($product->pivot->price, 2) }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta comanda?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center">
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Crear Nueva Comanda</a>
    </div>
</div>
@endsection
