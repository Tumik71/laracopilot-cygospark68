<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Elektro Portal – Elektroservis & Elektroinstalace')</title>
    <meta name="description" content="@yield('meta_description', 'Odborný portál pro elektrikáře a elektroinstalace. Blog, galerie, videa a VIP obsah pro profesionály.')">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #f59e0b, #ef4444); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-link { transition: all 0.2s; }
        .nav-link:hover { color: #f59e0b; }
    </style>
    @yield('head')
</head>
<body class="bg-gray-50">

<!-- NAVIGACE -->
<nav class="bg-gray-900 shadow-xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-red-500 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">⚡</span>
                </div>
                <div>
                    <span class="text-white font-bold text-xl">Elektro</span>
                    <span class="text-yellow-400 font-bold text-xl">Portal</span>
                </div>
            </a>

            <!-- Desktop menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="nav-link text-gray-300 hover:text-yellow-400 font-medium">Domů</a>
                <a href="{{ route('blog') }}" class="nav-link text-gray-300 hover:text-yellow-400 font-medium">Blog</a>
                <a href="{{ route('gallery') }}" class="nav-link text-gray-300 hover:text-yellow-400 font-medium">Galerie</a>
                <a href="{{ route('video.chat') }}" class="nav-link text-gray-300 hover:text-yellow-400 font-medium">Video Chat</a>
                <a href="{{ route('contact') }}" class="nav-link text-gray-300 hover:text-yellow-400 font-medium">Kontakt</a>
                @if(session('vip_logged_in'))
                    <a href="{{ route('vip.content') }}" class="bg-gradient-to-r from-yellow-400 to-red-500 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition">👑 VIP Sekce</a>
                    <form action="{{ route('vip.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white text-sm">Odhlásit</button>
                    </form>
                @else
                    <a href="{{ route('vip.info') }}" class="bg-gradient-to-r from-yellow-400 to-red-500 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition">👑 VIP Členství</a>
                @endif
            </div>

            <!-- Mobile menu button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-300 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden pb-4">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-yellow-400 py-2">Domů</a>
                <a href="{{ route('blog') }}" class="text-gray-300 hover:text-yellow-400 py-2">Blog</a>
                <a href="{{ route('gallery') }}" class="text-gray-300 hover:text-yellow-400 py-2">Galerie</a>
                <a href="{{ route('video.chat') }}" class="text-gray-300 hover:text-yellow-400 py-2">Video Chat</a>
                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-yellow-400 py-2">Kontakt</a>
                <a href="{{ route('vip.info') }}" class="text-yellow-400 font-semibold py-2">👑 VIP Členství</a>
            </div>
        </div>
    </div>
</nav>

<!-- FLASH ZPRÁVY -->
@if(session('success'))
    <div class="bg-green-500 text-white px-4 py-3 text-center text-sm">
        ✅ {{ session('success') }}
    </div>
@endif
@if(session('warning'))
    <div class="bg-yellow-500 text-white px-4 py-3 text-center text-sm">
        ⚠️ {{ session('warning') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-500 text-white px-4 py-3 text-center text-sm">
        ❌ {{ session('error') }}
    </div>
@endif

@yield('content')

<!-- PATIČKA -->
<footer class="bg-gray-900 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center space-x-2 mb-4">
                <span class="text-2xl">⚡</span>
                <span class="text-xl font-bold"><span class="text-white">Elektro</span><span class="text-yellow-400">Portal</span></span>
            </div>
            <p class="text-gray-400 text-sm">Odborný portál pro elektrikáře a elektroinstalace. Vzdělávání, galerie a VIP obsah pro profesionály.</p>
        </div>
        <div>
            <h4 class="font-semibold text-yellow-400 mb-3">Navigace</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-white transition">Domů</a></li>
                <li><a href="{{ route('blog') }}" class="hover:text-white transition">Blog</a></li>
                <li><a href="{{ route('gallery') }}" class="hover:text-white transition">Galerie</a></li>
                <li><a href="{{ route('video.chat') }}" class="hover:text-white transition">Video Chat</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold text-yellow-400 mb-3">VIP Sekce</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('vip.info') }}" class="hover:text-white transition">O VIP členství</a></li>
                <li><a href="{{ route('vip.register') }}" class="hover:text-white transition">Registrace</a></li>
                <li><a href="{{ route('vip.login') }}" class="hover:text-white transition">Přihlášení</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-white transition">Podpora</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold text-yellow-400 mb-3">Kontakt</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li>📧 info@elektro-portal.cz</li>
                <li>📞 +420 800 123 456</li>
                <li>🌐 elektro-portal.cz</li>
                <li>📍 Česká republika</li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-700 py-6 text-center text-sm text-gray-500">
        <p>© {{ date('Y') }} Elektro Portal. Všechna práva vyhrazena.</p>
        <p class="mt-1">Vytvořeno s ❤️ pro elektrotechniky | <a href="https://laracopilot.com/" target="_blank" class="text-yellow-400 hover:underline">LaraCopilot</a></p>
    </div>
</footer>

<script>
    document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@yield('scripts')
</body>
</html>
