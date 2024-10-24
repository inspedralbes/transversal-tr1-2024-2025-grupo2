<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    <!-- Aquí puedes incluir CSS o cualquier otro recurso -->
</head>
<body>
    <header>
        <h1>Mi Aplicación Laravel</h1>
        <!-- Aquí puedes incluir un menú de navegación -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© 2024 Mi Aplicación</p>
    </footer>
</body>
</html>
