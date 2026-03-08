<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-900 flex items-center justify-center px-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white">⚡ Portál</h1>
        <p class="text-blue-200 mt-2">Přihlaste se ke svému účtu</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ $errors->first() }}</div>
        @endif

        @if(session('dev_2fa_code'))
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-lg mb-4 text-sm">
                🔐 <strong>DEV kód 2FA:</strong> {{ session('dev_2fa_code') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="vas@email.cz" required>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Heslo</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="••••••••" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                Přihlásit se
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-4">
            Nemáte účet? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Zaregistrovat se</a>
        </p>
    </div>

    <div class="mt-4 bg-white/10 rounded-xl p-4 text-sm text-white">
        <p class="font-semibold mb-1">🧪 Testovací přístupy:</p>
        <p>👤 uzivatel@portal.cz / Heslo1234!</p>
        <p>⭐ vip@portal.cz / Vip1234!</p>
    </div>
</div>

</body>
</html>
