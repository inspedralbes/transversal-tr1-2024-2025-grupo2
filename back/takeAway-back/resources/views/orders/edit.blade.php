@extends('layouts.app')

@section('content')
    <h1>Editar Pedido #{{ $order->id }}</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="totalproducts">Total de Productos:</label>
            <input type="number" id="totalproducts" name="totalproducts" value="{{ old('totalproducts', $order->totalproducts) }}" required>
        </div>

        <div>
            <label for="finalprice">Precio Final:</label>
            <input type="number" id="finalprice" name="finalprice" step="0.01" value="{{ old('finalprice', $order->finalprice) }}" required>
        </div>

        <h2>Productos</h2>
        <div id="products-container">
            @foreach ($order->products as $index => $product)
                <div class="product-item">
                    <label for="product_{{ $index }}">Producto:</label>
                    <select name="products[{{ $index }}][id]" required>
                        @foreach ($products as $availableProduct)
                            <option value="{{ $availableProduct->id }}" {{ $availableProduct->id == $product->id ? 'selected' : '' }}>
                                {{ $availableProduct->title }}
                            </option>
                        @endforeach
                    </select>
                    <label for="quantity_{{ $index }}">Cantidad:</label>
                    <input type="number" name="products[{{ $index }}][quantity]" min="1" value="{{ $product->pivot->quantity }}" required>
                    <input type="hidden" name="products[{{ $index }}][price]" value="{{ $product->pivot->price }}">
                </div>
            @endforeach
        </div>

        <button type="button" id="add-product">Agregar Otro Producto</button>
        <button type="submit">Actualizar Pedido</button>
    </form>

    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const index = container.children.length; // Obtener el índice del nuevo producto
            const newProductItem = `
                <div class="product-item">
                    <label for="product_${index}">Producto:</label>
                    <select name="products[${index}][id]" required>
                        @foreach ($products as $availableProduct)
                            <option value="{{ $availableProduct->id }}">{{ $availableProduct->title }}</option>
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
