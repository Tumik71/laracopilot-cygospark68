<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dvoufaktorové ověření</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center px-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">🔐</div>
        <h1 class="text-3xl font-bold text-white">Dvoufaktorové ověření</h1>
        <p class="text-blue-200 mt-2">Zadejte 6místný kód z e-mailu nebo SMS</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        @if(session('dev_2fa_code'))
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-lg mb-4">
                <p class="text-sm font-semibold">🧪 DEV kód (v produkci dorazí e-mailem):</p>
                <p class="text-2xl font-bold tracking-widest text-center mt-1">{{ session('dev_2fa_code') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ověřovací kód</label>
                <input type="text" name="code" maxlength="6" autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-4 text-center text-2xl font-bold tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="000000" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                Ověřit kód
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">← Zpět na přihlášení</a>
        </p>
    </div>
</div>

</body>
</html>
