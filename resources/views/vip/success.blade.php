<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Platba úspěšná – Elektro Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-green-900 min-h-screen flex items-center justify-center">
<div class="text-center max-w-md px-4">
    <div class="text-7xl mb-4">🎉</div>
    <h1 class="text-4xl font-extrabold text-white mb-4">Vítejte ve VIP sekci!</h1>
    <p class="text-gray-300 text-lg mb-8">Vaše platba byla úspěšně zpracována. Nyní máte přístup ke všemu exkluzivnímu obsahu.</p>
    <div class="space-y-3">
        <a href="{{ route('vip.content') }}" class="block bg-yellow-400 text-gray-900 font-bold py-4 rounded-xl text-lg hover:bg-yellow-300 transition">👑 Přejít do VIP sekce</a>
        <a href="{{ route('home') }}" class="block text-gray-400 hover:text-white transition text-sm">Zpět na hlavní stránku</a>
    </div>
</div>
</body>
</html>
