<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Platba zrušena – Elektro Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-red-900 min-h-screen flex items-center justify-center">
<div class="text-center max-w-md px-4">
    <div class="text-7xl mb-4">😔</div>
    <h1 class="text-3xl font-extrabold text-white mb-4">Platba byla zrušena</h1>
    <p class="text-gray-300 mb-8">Vaše platba nebyla dokončena. Pokud chcete zkusit znovu, klikněte na tlačítko níže.</p>
    <div class="space-y-3">
        <a href="{{ route('vip.subscribe') }}" class="block bg-yellow-400 text-gray-900 font-bold py-4 rounded-xl hover:bg-yellow-300 transition">Zkusit znovu</a>
        <a href="{{ route('vip.info') }}" class="block text-gray-400 hover:text-white text-sm">Více o VIP členství</a>
        <a href="{{ route('home') }}" class="block text-gray-500 hover:text-gray-300 text-sm">Zpět na hlavní stránku</a>
    </div>
</div>
</body>
</html>
