<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            {{-- Tambahkan elemen ini untuk pengujian Tailwind --}}
            <h1 class="text-4xl font-bold text-blue-600 bg-yellow-200 p-4 rounded-lg shadow-lg">
                Hello Tailwind!
            </h1>

            {{-- Anda juga bisa mencoba mengubah kelas pada elemen yang sudah ada, misalnya body --}}
            {{-- <body class="antialiased bg-purple-200 text-green-700"> --}}

            {{-- ... Konten Laravel default lainnya ... --}}
        </div>
    </body>
</html>
