<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP Předplatné – Elektro Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-yellow-900 min-h-screen flex items-center justify-center py-8">
<div class="w-full max-w-md px-4">
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-400 to-red-500 p-8 text-center">
            <div class="text-5xl mb-2">👑</div>
            <h1 class="text-2xl font-extrabold text-white">VIP Předplatné</h1>
            <p class="text-white/80 mt-1">Elektro Portal</p>
        </div>
        <div class="p-8">
            <div class="text-center mb-6">
                <div class="text-5xl font-extrabold text-gray-900">{{ $price }} Kč</div>
                <div class="text-gray-500">/měsíc · Kdykoli zrušitelné</div>
            </div>
            <ul class="space-y-2 mb-8">
                @foreach(['Exkluzivní video tutoriály', 'PDF průvodce ke stažení', 'Live webináře s odborníky', 'VIP galerie realizací', 'VIP blog články', 'Prioritní podpora'] as $feature)
                <li class="flex items-center text-sm text-gray-600">
                    <span class="text-green-500 mr-2 font-bold">✓</span> {{ $feature }}
                </li>
                @endforeach
            </ul>
            <form action="{{ route('vip.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-bold py-4 rounded-xl text-lg hover:opacity-90 transition">
                    💳 Zaplatit přes Stripe
                </button>
            </form>
            <div class="flex items-center justify-center mt-4 text-xs text-gray-400 space-x-2">
                <span>🔒 SSL Šifrování</span>
                <span>·</span>
                <span>⚡ Powered by Stripe</span>
            </div>
        </div>
    </div>
    <p class="text-center mt-4">
        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-200 text-sm">← Zpět na hlavní stránku</a>
    </p>
</div>
</body>
</html>
