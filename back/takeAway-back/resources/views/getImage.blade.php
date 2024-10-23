<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat Productes</title>
</head>

<style>
    img {
        width: 200px;
    }
</style>

<body>
    @foreach($products as $product)
        <div>
            <h2>ID: {{ $product['id'] }}</h2>
            <h3>Título: {{ $product['title'] }}</h3>
            <p>Descripción: {{ $product['description'] }}</p>
            <img src="{{ $product['image'] }}">
            <p>Precio: {{ $product['price'] }} €</p>
            <p>Categoría: {{ $product['category'] }}</p>
            <p>Tamaño: {{ $product['size'] }}</p>
        </div>
        <br>
    @endforeach
</body>

</html>