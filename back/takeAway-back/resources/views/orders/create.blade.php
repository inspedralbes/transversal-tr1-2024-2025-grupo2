@extends('layouts.app')

@section('content')
    <h1 class="mt-4 mb-4">Crear Nueva Comanda</h1>

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

        <h2>Selecciona Productos</h2>
        <div id="products-container">
            <div class="product-item">
                <label for="product_0">Producto:</label>
                <select name="products[0][id]" required onchange="updatePrice(this)">
                    <option value="">Selecciona un producto</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                <label for="quantity_0">Cantidad:</label>
                <input type="number" name="products[0][quantity]" min="1" required onchange="updatePrice(this)">
                <span class="product-price" id="price_0">Precio: €<span class="price-value">0.00</span></span>
            </div>
        </div>

        <button type="button" id="add-product">Agregar Otro Producto</button>
        <button type="submit">Crear Comanda</button>
    </form>

    <script>
        let productIndex = 1; // Inicializa el índice de producto

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
                    <span class="product-price" id="price_${productIndex}">Precio: $<span class="price-value">0.00</span></span>
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
    </script>
@endsection
