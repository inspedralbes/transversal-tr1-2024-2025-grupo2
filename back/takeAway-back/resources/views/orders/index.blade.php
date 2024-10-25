@extends('layouts.app')

@section('content')
    <h1>Lista de Pedidos</h1>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Total de Productos</th>
                <th>Precio Final</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->totalproducts }}</td>
                    <td>{{ $order->finalprice }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}">Ver</a>
                        <a href="{{ route('orders.edit', $order->id) }}">Editar</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.create') }}">Crear Nuevo Pedido</a>
@endsection
