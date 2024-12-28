<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-full h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @googlefonts('sans')
    @googlefonts('mono')

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22><text y=%2222%22 font-size=%2222%22>📟</text></svg>">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="antialiased min-h-screen dark:bg-dark dark:text-gray-300 font-sans">
<div id="app" class="h-full min-h-screen flex flex-col justify-between">
    <nav class="navbar navbar-expand-md navbar-light dark:bg-dark bg-white drop-shadow dark:drop-shadow-lg dark:shadow-neutral-950 p-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <a href="/">
                    <h1 class="font-bold tracking-tight text-2xl lowercase">
                        {{ config('app.name') }}
                    </h1>
                </a>
            </div>

            <h2 class="text-neutral-600 font-mono">Ask Me Anything</h2>
        </div>
    </nav>

    <main class="p-6 h-full flex flex-col items-center grow lg:py-12 gap-6">
        @guest()
            <div class="w-32 h-32 rounded-full bg-yellow-400"></div>

            <h1 class="text-4xl lg:text-6xl lg:max-w-2xl font-bold tracking-tight mb-4 text-balance text-center">Your question, my expertise</h1>

            <h2 class="text-lg lg:text-xl lg:max-w-2xl text-neutral-600 dark:text-neutral-400 text-balance text-center"><span class="decoration-wavy decoration-blue-600 underline-offset-4 underline">Free</span> business development consulting via Chat</h2>

            <div class="bg-gray-100 dark:bg-neutral-800 border-b-2 border-gray-200 dark:border-neutral-900 p-9 rounded-lg flex flex-col gap-6 text-xl">
                <div class="flex flex-col gap-1">
                    <h3 class="w-full font-bold tracking-tight dark:text-neutral-400">Enter your name and email</h3>

                    <p class="dark:text-neutral-500">You will receive a link in your inbox to log in.</p>
                </div>

                <form action="{{ route('send.magic.link') }}" method="POST" class="flex gap-3 w-full dark:text-neutral-500">
                    @csrf
                    <input type="text" name="name" id="name" required class="block w-full py-2 rounded-md border-gray-300 shadow-sm border-b-2 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Name">

                    <input type="email" name="email" id="email" required class="block w-full py-2 rounded-md border-gray-300 border-b-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Email">

                    <button type="submit" class="bg-blue-600 border-b-2 border-blue-700 text-white px-4 py-2 rounded-md font-bold shrink-0">Login via e-mail</button>
                </form>
            </div>
        @endguest

        @yield('content')
    </main>
    <footer class="mb-4 text-center text-lg-start rounded-full">
        <div class="w-full h-8 shadow-inner dark:shadow-neutral-800 relative">
            <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-white dark:from-dark to-transparent w-1/4 h-full z-10"></div>

            <div class="absolute inset-y-0 right-0 bg-gradient-to-l from-white dark:from-dark to-transparent w-1/4 h-full z-10"></div>
        </div>

        <div class="flex flex-col items-center gap-6 md:gap-0 md:flex-row justify-between px-6 pb-3 text-neutral-500">
            <a href="mailto:sander@konstruktiv.nl">Support</a>

            @auth()
                <div class="w-full flex gap-3 text-center justify-center items-center text-neutral-400">
                    Logged in as {{ auth()->user()->name }}, your session will automatically expire 5 minutes after closing the browser.
                </div>
            @endauth

            <div class="flex items-center gap-2 text-md text-dark dark:text-neutral-500 shrink-0">
                <a class="text-black font-bold rounded-full px-3 bg-yellow-400 lowercase" href="{{ config('app.url') }}">{{ config('app.name') }}</a>

                <a href="https://konstruktiv.nl" target="_blank" class="flex gap-2">
                    built by

                    <div class="w-20 fill-current">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 793.157 107.17"><path d="M719.747,16.013H730.58l26.668,66.836,26.168-66.836h10.5l-37.168,91.67ZM181.922,39.181v64.335h-9.667V11.846l56,68.669v-64.5h9.667v91.67ZM463.085,72.515v-56.5h10V71.681c0,14.333,8.834,23.667,21.168,23.667s21.167-9.334,21.167-23.667V16.013h10v56.5c0,19.834-13,32.667-31.167,32.667S463.085,92.349,463.085,72.515Zm176.83,31V25.68H619.081l-2.334-9.667h56.336l-2.334,9.667H649.915v77.836Zm-43.162,0-32.334-44.5v44.5h-10v-87.5h10V57.681l32.667-41.668h11.167l-32.667,42,33,45.5Zm-168,0-27-37.167v37.167h-10v-87.5h17.833c18.834,0,30.668,11.167,30.668,29.335,0,14.834-8.167,24.667-22.168,27.334l22.667,30.834Zm-27-38h8.334c12,0,19.834-8,19.834-20,0-12.167-7.667-19.834-19.334-19.834h-8.834Zm-61.5,38V25.68H319.419l-2.334-9.667h56.336l-2.334,9.667H350.253v77.836Zm-79.666,0,2.334-9.667h18.167c9.667,0,15-4.833,15-11.667,0-6.333-2.833-9.5-7.834-13.334L274.421,58.181c-6.333-4.833-11.167-10.5-11.167-20.667,0-12.834,9.334-21.5,24.835-21.5h18l-2.333,9.667H288.588c-9.667,0-14.834,4.834-14.834,11.834,0,6.167,2.667,9.333,7.667,13.167l13.834,10.667c6.167,4.834,11.167,10.667,11.167,20.834,0,12.667-9.167,21.334-24.667,21.334Zm-187.5,0V93.848h69.835v9.667Zm-30,0-32.334-44.5v44.5h-10v-87.5h10V57.681L43.426,16.013H54.593l-32.667,42,33,45.5Zm648.317-.005V16.01h10v87.5ZM73.423,35.681C73.423,15.846,87.09.512,108.091.512s34.668,15.334,34.668,35.168c0,19.667-14,35.668-34.668,35.668S73.423,55.347,73.423,35.681Zm10.334.167c0,14.167,10,25.5,24.334,25.5s24.334-11.334,24.334-25.5-10-25.667-24.334-25.667S83.757,21.68,83.757,35.847Z" transform="translate(-0.759 -0.512)"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </footer>
</div>

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

        window.VAPID_PUBLIC_KEY = '{{ env('VAPID_PUBLIC_KEY') }}';
    </script>
@endpush
@stack('scripts')
</body>
</html>

