<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <!-- Header Component -->
    <x-header />

    <!-- FULL PAGE PROFESSIONAL BACKGROUND -->
    <!-- MAIN CONTAINER -->
    <div
        class="min-h-screen flex flex-col justify-center items-center
    bg-gradient-to-br from-blue-100 via-white to-blue-50 relative overflow-hidden">

        <!-- Decoration -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-10 left-10 w-72 h-72 bg-blue-200 blur-3xl opacity-20 rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-80 h-80 bg-pink-200 blur-3xl opacity-25 rounded-full"></div>
        </div>

        <!-- CARD (WIDER NOW) -->
        <div
            class="relative px-3 lg:max-w-7xl mt-16 lg:px-10 py-10 bg-white/80 backdrop-blur-xl 
                shadow-2xl rounded-2xl border border-gray-100">
            {{ $slot }}
        </div>

    </div>


</body>

</html>
