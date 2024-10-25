@extends('layouts.app')

@section('content')
    <h1>Crear Nuevo Pedido</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div>
            <label for="totalproducts">Total de Productos:</label>
            <input type="number" id="totalproducts" name="totalproducts" required>
        </div>

        <div>
            <label for="finalprice">Precio Final:</label>
            <input type="number" id="finalprice" name="finalprice" step="0.01" required>
        </div>

        <h2>Productos</h2>
        <div id="products-container">
            <div class="product-item">
                <label for="product_0">Producto:</label>
                <select name="products[0][id]" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                <label for="quantity_0">Cantidad:</label>
                <input type="number" name="products[0][quantity]" min="1" required>
            </div>
        </div>

        <button type="button" id="add-product">Agregar Otro Producto</button>
        <button type="submit">Crear Pedido</button>
    </form>

    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const index = container.children.length; // Obtener el índice del nuevo producto
            const newProductItem = `
                <div class="product-item">
                    <label for="product_${index}">Producto:</label>
                    <select name="products[${index}][id]" required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    <label for="quantity_${index}">Cantidad:</label>
                    <input type="number" name="products[${index}][quantity]" min="1" required>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newProductItem);
        });
    </script>
@endsection
