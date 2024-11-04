@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">Detalles del Pedido</h1>

    <div class="mb-4">
        <h2>Pedido ID: {{ $order->id }}</h2>
        <p><strong>Total de Productos:</strong> {{ $order->totalproducts }}</p>
        <p><strong>Precio Final:</strong> €{{ number_format($order->finalprice, 2) }}</p>
        <p><strong>Fecha de Creación:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <h3 class="mb-3">Productos en el Pedido</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio por Unidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>€{{ number_format($product->pivot->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Volver a la lista de pedidos</a>
        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Editar Pedido</a>

        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">Eliminar Pedido</button>
        </form>
    </div>
</div>
@endsection
