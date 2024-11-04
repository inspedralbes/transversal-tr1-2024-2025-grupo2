@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Bienvenido al CRUD de TakeOutFit</h1>
        <p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Ir a Productos</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Ir a Comandas</a>
        </p>
    </div>
@endsection
