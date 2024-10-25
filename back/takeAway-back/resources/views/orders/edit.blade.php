@extends('layouts.app')

@section('content')
    <h1>Editar Comanda #{{ $order->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
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

        <h2>Selecciona Productos</h2>
        <div id="products-container">
            @foreach ($order->products as $index => $product)
                <div class="product-item">
                    <label for="product_{{ $index }}">Producto:</label>
                    <select name="products[{{ $index }}][id]" required onchange="updatePrice(this)">
                        <option value="">Selecciona un producto</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}" data-price="{{ $p->price }}" {{ $p->id == $product->id ? 'selected' : '' }}>{{ $p->title }}</option>
                        @endforeach
                    </select>
                    <label for="quantity_{{ $index }}">Cantidad:</label>
                    <input type="number" name="products[{{ $index }}][quantity]" min="1" required value="{{ $product->pivot->quantity }}" onchange="updatePrice(this)">
                    <span class="product-price" id="price_{{ $index }}">Precio: €<span class="price-value">{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</span></span>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-product">Agregar Otro Producto</button>
        <button type="submit">Actualizar Comanda</button>
    </form>

    <script>
        let productIndex = {{ count($order->products) }}; // Inicializa el índice de producto

        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const newProductItem = `
                <div class="product-item">
                    <label for="product_${productIndex}">Producto:</label>
                    <select name="products[${productIndex}][id]" required onchange="updatePrice(this)">
                        <option value="">Selecciona un producto</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    <label for="quantity_${productIndex}">Cantidad:</label>
                    <input type="number" name="products[${productIndex}][quantity]" min="1" required onchange="updatePrice(this)">
                    <span class="product-price" id="price_${productIndex}">Precio: €<span class="price-value">0.00</span></span>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newProductItem);
            productIndex++; // Incrementa el índice de producto
        });

        function updatePrice(element) {
            const productItem = element.closest('.product-item');
            const selectElement = productItem.querySelector('select');
            const quantityInput = productItem.querySelector('input[type="number"]');
            const priceDisplay = productItem.querySelector('.price-value');

            if (selectElement.value) {
                const price = selectElement.options[selectElement.selectedIndex].dataset.price;
                const quantity = quantityInput.value || 1; // Por defecto 1 si no hay cantidad

                const totalPrice = (price * quantity).toFixed(2);
                priceDisplay.innerText = totalPrice;
            } else {
                priceDisplay.innerText = '0.00'; // Si no se selecciona producto, mostrar 0
            }
        }

        // Actualizar precios al cargar la página
        document.querySelectorAll('.product-item').forEach(item => updatePrice(item.querySelector('select')));
    </script>
@endsection
