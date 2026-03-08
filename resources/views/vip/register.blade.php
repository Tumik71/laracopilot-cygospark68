<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP Registrace – Elektro Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-yellow-900 min-h-screen flex items-center justify-center py-8">
<div class="w-full max-w-md px-4">
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">👑</div>
        <h1 class="text-3xl font-bold text-white">VIP Registrace</h1>
        <p class="text-gray-400 mt-1">Vytvořte si účet a pokračujte k platbě</p>
    </div>
    <div class="bg-white rounded-2xl shadow-2xl p-8">
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif
        <form action="{{ route('vip.register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jméno a příjmení *</label>
                <input type="text" name="name" required value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">E-mail *</label>
                <input type="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Telefon</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+420 xxx xxx xxx" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Heslo * (min. 8 znaků)</label>
                <input type="password" name="password" required minlength="8" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Potvrzení hesla *</label>
                <input type="password" name="password_confirmation" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-bold py-4 rounded-xl hover:opacity-90 transition">
                Pokračovat k platbě →
            </button>
        </form>
        <p class="text-center text-sm text-gray-500 mt-4">Již máte účet? <a href="{{ route('vip.login') }}" class="text-yellow-600 hover:underline font-semibold">Přihlásit se</a></p>
    </div>
</div>
</body>
</html>
