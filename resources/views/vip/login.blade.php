<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP Přihlášení – Elektro Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-yellow-900 min-h-screen flex items-center justify-center">
<div class="w-full max-w-md px-4">
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">👑</div>
        <h1 class="text-3xl font-bold text-white">VIP Přihlášení</h1>
        <p class="text-gray-400 mt-1">Elektro Portal – Exkluzivní obsah</p>
    </div>
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4 text-sm">{{ $errors->first() }}</div>
        @endif
        @if(session('warning'))
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-4 text-sm">{{ session('warning') }}</div>
        @endif
        <form action="{{ route('vip.login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">E-mail</label>
                <input type="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Heslo</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold py-3 rounded-lg hover:opacity-90 transition">
                Přihlásit se do VIP sekce
            </button>
        </form>
        <div class="mt-4 p-4 bg-gray-50 rounded-lg text-sm text-center">
            <p class="text-gray-500 mb-1">Nemáte účet? <a href="{{ route('vip.register') }}" class="text-yellow-600 font-semibold hover:underline">Zaregistrovat se</a></p>
            <p class="text-gray-400 text-xs mt-2">Testovací VIP účet: <strong>vip@elektro-portal.cz</strong> / <strong>VipHeslo2024!</strong></p>
        </div>
    </div>
    <p class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-200 text-sm">← Zpět na hlavní stránku</a>
    </p>
</div>
</body>
</html>
