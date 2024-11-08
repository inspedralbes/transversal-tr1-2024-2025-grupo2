<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ADMIN-takeoutfit')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-light p-3">
        <div class="container">
            <h1 class="text-center">TakeOutFit</h1>
            <nav>
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Comandas</a>
                    </li>
                    <li>
                        <a href="{{ env('BASE_URL') }}" class="nav-link">Tornar a la botiga</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container my-4">
        @yield('content')
    </main>

</body>
</html>
