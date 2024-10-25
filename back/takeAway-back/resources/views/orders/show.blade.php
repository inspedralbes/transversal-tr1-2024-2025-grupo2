@extends('layouts.app')

@section('content')
    <h1>Detalles del Pedido</h1>

    <div>
        <h2>Pedido ID: {{ $order->id }}</h2>
        <p><strong>Total de Productos:</strong> {{ $order->totalproducts }}</p>
        <p><strong>Precio Final:</strong> {{ $order->finalprice }}</p>
        <p><strong>Fecha de Creación:</strong> {{ $order->created_at }}</p>

        <h3>Productos en el Pedido</h3>
        <table>
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
                        <td>{{ $product->pivot->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <a href="{{ route('orders.index') }}">Volver a la lista de pedidos</a>
        <a href="{{ route('orders.edit', $order->id) }}">Editar Pedido</a>

        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">Eliminar Pedido</button>
        </form>
    </div>
@endsection
