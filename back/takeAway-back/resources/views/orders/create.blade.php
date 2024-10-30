@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4 text-center">Crear Nueva Comanda</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <h2 class="my-3">Selecciona Productos</h2>
        <div id="products-container" class="mb-4">
            <div class="product-item mb-3">
                <label for="product_0" class="form-label">Producto:</label>
                <select name="products[0][id]" class="form-select" required onchange="updatePrice(this)">
                    <option value="">Selecciona un producto</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                <label for="quantity_0" class="form-label">Cantidad:</label>
                <input type="number" name="products[0][quantity]" class="form-control" min="1" required onchange="updatePrice(this)">
                <span class="product-price" id="price_0">Precio: €<span class="price-value">0.00</span></span>
            </div>
        </div>

        <button type="button" id="add-product" class="btn btn-secondary mb-4">Agregar Otro Producto</button>
        <button type="submit" class="btn btn-primary">Crear Comanda</button>
    </form>

    <script>
        let productIndex = 1; // Inicializa el índice de producto

        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const newProductItem = `
                <div class="product-item mb-3">
                    <label for="product_${productIndex}" class="form-label">Producto:</label>
                    <select name="products[${productIndex}][id]" class="form-select" required onchange="updatePrice(this)">
                        <option value="">Selecciona un producto</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->title }}</option>
                        @endforeach
                    </select>
                    <label for="quantity_${productIndex}" class="form-label">Cantidad:</label>
                    <input type="number" name="products[${productIndex}][quantity]" class="form-control" min="1" required onchange="updatePrice(this)">
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
    </script>
</div>
@endsection
