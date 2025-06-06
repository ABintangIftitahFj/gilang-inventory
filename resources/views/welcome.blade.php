<script>
    // Redirect to dashboard on page load
    window.location.href = "/dashboard";
</script>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gilang Inventory</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
            <div class="text-center p-8">
                <div class="spinner mb-4 mx-auto w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Sedang Mengarahkan...</h1>
                <p class="text-gray-600">Menuju Dashboard Gilang Inventory</p>
            </div>
        </div>
    </body>
</html>
