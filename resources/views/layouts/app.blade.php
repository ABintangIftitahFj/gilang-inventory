<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gilang Inventory</title>

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow p-4 mb-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">📦 Gilang Inventory</h1>
            <a href="/dashboard" class="text-blue-600 hover:underline">Dashboard</a>
        </div>
    </nav>

    <main class="container mx-auto px-4">
        @yield('content')
    </main>

    @vite('resources/js/app.js')
</body>
</html>
