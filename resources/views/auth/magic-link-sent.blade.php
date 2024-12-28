<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-full h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Check your inbox</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22><text y=%2222%22 font-size=%2222%22>📟</text></svg>">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-gradient-to-tr text-neutral-600 from-blue-100 to blue-200 flex items-center justify-between h-full min-h-full w-full">
    <div class="m-12 shadow bg-white p-6 py-12 text-center rounded border-b-2 border-blue-200 mx-auto">
        <h1 class="text-2xl font-bold text-blue-600 mb-6 decoration-wavy decoration-blue-100 underline-offset-8 underline">Check your inbox</h1>
        <p class="text-balance">A magical link has been sent to the provided email address. Open the link, and you’ll be logged in. ✨</p>
    </div>
</body>
</html>
