<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') – Elektro Portal CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">
        <div class="p-4 border-b border-gray-700">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                <span class="text-2xl">⚡</span>
                <div>
                    <div class="font-bold text-sm">Elektro Portal</div>
                    <div class="text-xs text-gray-400">CMS Administrace</div>
                </div>
            </a>
        </div>

        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-sm font-bold text-gray-900">
                    {{ strtoupper(substr(session('admin_user', 'A'), 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-medium">{{ session('admin_user', 'Admin') }}</div>
                    <div class="text-xs text-gray-400">{{ session('admin_role', 'Správce') }}</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-500 text-gray-900 font-semibold' : 'text-gray-300 hover:bg-gray-700' }} transition">
                <span>📊</span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.blog.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.blog*') ? 'bg-yellow-500 text-gray-900 font-semibold' : 'text-gray-300 hover:bg-gray-700' }} transition">
                <span>📝</span><span>Blog & Články</span>
            </a>
            <a href="{{ route('admin.gallery.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.gallery*') ? 'bg-yellow-500 text-gray-900 font-semibold' : 'text-gray-300 hover:bg-gray-700' }} transition">
                <span>🖼️</span><span>Galerie</span>
            </a>
            <a href="{{ route('admin.video.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.video*') ? 'bg-yellow-500 text-gray-900 font-semibold' : 'text-gray-300 hover:bg-gray-700' }} transition">
                <span>🎬</span><span>Videa</span>
            </a>
            <a href="{{ route('admin.vip.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.vip*') ? 'bg-yellow-500 text-gray-900 font-semibold' : 'text-gray-300 hover:bg-gray-700' }} transition">
                <span>👑</span><span>VIP Obsah</span>
            </a>
            <a href="{{ route('admin.subscribers.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.subscribers*') ? 'bg-yellow-500 text-gray-900 font-semibold' : 'text-gray-300 hover:bg-gray-700' }} transition">
                <span>👥</span><span>Předplatitelé</span>
            </a>
            <div class="pt-4 border-t border-gray-700">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-gray-300 hover:bg-gray-700 transition">
                    <span>🌐</span><span>Zobrazit web</span>
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-red-400 hover:bg-red-900/20 transition">
                        <span>🚪</span><span>Odhlásit se</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- HLAVNÍ OBSAH -->
    <main class="flex-1 overflow-y-auto">
        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">❌ {{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
@yield('scripts')
</body>
</html>
