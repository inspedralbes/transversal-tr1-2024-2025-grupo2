<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ADMIN-takeoutfit')</title>
</head>
<body>
    <header>
        <h1>TakeOutFit</h1>
        <!-- hauriem d'afegir el menú de navegació -->
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>
