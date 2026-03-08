<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin přihlášení – Elektro Portal CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen flex items-center justify-center">
<div class="w-full max-w-md px-4">
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-yellow-400 to-red-500 rounded-2xl mb-4">
            <span class="text-3xl">⚡</span>
        </div>
        <h1 class="text-3xl font-bold text-white">Elektro Portal</h1>
        <p class="text-gray-400 mt-1">CMS Administrace</p>
    </div>

    <div class="bg-white rounded-2xl shadow-2xl p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Přihlášení do administrace</h2>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mailová adresa</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition"
                    placeholder="admin@elektro-portal.cz">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Heslo</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition"
                    placeholder="••••••••">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold py-3 rounded-lg hover:opacity-90 transition">
                Přihlásit se do administrace
            </button>
        </form>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-xs font-semibold text-gray-500 mb-2">🔑 Testovací přihlašovací údaje:</p>
            <p class="text-xs text-gray-600"><strong>Správce:</strong> admin@elektro-portal.cz / Admin2024!</p>
            <p class="text-xs text-gray-600"><strong>Redaktor:</strong> redaktor@elektro-portal.cz / Redaktor2024!</p>
        </div>
    </div>
    <p class="text-center text-gray-500 text-sm mt-4">
        <a href="{{ route('home') }}" class="hover:text-gray-300 transition">← Zpět na web</a>
    </p>
</div>
</body>
</html>
