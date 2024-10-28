<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat de Productes</title>
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
            <h3>Títol: {{ $product['title'] }}</h3>
            <p>Descripció: {{ $product['description'] }}</p>
            <img src="{{ $product['image'] }}">
            <p>Preu: {{ $product['price'] }} €</p>
            <p>Categoria: {{ $product['category_id'] }}</p>
            <p>Talla: {{ $product['size_id'] }}</p>
        </div>
        <br>
    @endforeach
</body>

</html>