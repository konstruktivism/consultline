<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-full h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22><text y=%2222%22 font-size=%2222%22>📟</text></svg>">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="font-sans antialiased flex flex-col text-neutral-700 items-center justify-between min-h-full h-full bg-white">
<div class="bg-white w-full flex justify-center items-center pb-6">
    <div class="grow px-3 md:px-24 flex mx-auto">
        <div class="flex flex-col gap-3 items-center justify-between w-full">
            <div class="flex items-center justify-between w-full">
                <a href="/"><h1 class="text-xl font-bold bg-blue-600 text-white px-3 py-2 pb-3 border-b-2  border-blue-700 tracking-tight flex items-center gap-2">
                        <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#ffffff" class="rotate-180"><path d="M15 21.5C19 16 19 8 15 2.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.5 20C15 15 15 9 11.5 4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.5 18C11.1667 14.25 11.1667 9.75 8.5 6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M5.5 16C7 13.5 7 10.5 5.5 8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>

                        {{ config('app.name') }}

                        <svg width="24px" height="24px" viewBox="0 0 24 24" stroke-width="1.5" fill="none" xmlns="http://www.w3.org/2000/svg" color="#ffffff"><path d="M15 21.5C19 16 19 8 15 2.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M11.5 20C15 15 15 9 11.5 4" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.5 18C11.1667 14.25 11.1667 9.75 8.5 6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M5.5 16C7 13.5 7 10.5 5.5 8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </h1>
                </a>

                <h2 class="text-neutral-600">Direct in contact, altijd dichtbij</h2>
            </div>

            @guest()
                <div class="w-full text-xl mt-6">Maak een <span class="text-blue-600 font-bold">gratis</span> account aan</div>

                <form action="{{ route('send.magic.link') }}" method="POST" class="flex gap-3 w-full">
                    @csrf
                    <div>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Naam">
                    </div>
                    <div>
                        <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="E-mail">
                    </div>

                    <button type="submit" class="bg-blue-600 border-b-2 border-blue-700 text-white px-4 py-2 rounded-md font-bold">Registreren</button>
                </form>
            @endguest

            @yield('content')
        </div>
    </div>
</div>

@auth()
    <div class="bg-blue-600 p-3 w-full text-white flex justify-between gap-3">
        Ingelogd als {{ auth()->user()->name }}

        <a class="underline" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
@endauth

@push('scripts')
    <script>
        function setDuration(minutes, button) {
            document.getElementById('duration').value = minutes;
            document.querySelectorAll('button[type="button"]').forEach(btn => {
                btn.classList.remove('border-blue-600', 'text-neutral-700');
                btn.classList.add('border', 'text-neutral-800');
            });
            button.classList.add('border-blue-600', 'text-neutral-780');
        }
    </script>
@endpush
@stack('scripts')
</body>
</html>

