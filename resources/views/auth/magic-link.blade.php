<!-- resources/views/auth/magic-link.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Link Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6">Login with Magic Link</h1>
    @if (session('status'))
        <div class="bg-green-100 border-green-200 text-green-800 rounded-xl p-4 mb-6">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('send.magic.link') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email:</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>
        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-lg">Send Magic Link</button>
    </form>
</div>
</body>
</html>
