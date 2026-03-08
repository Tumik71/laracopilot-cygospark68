<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – @yield('title', 'Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">
        <div class="p-5 border-b border-gray-700">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-blue-400">⚡ Admin Panel</a>
            <p class="text-xs text-gray-400 mt-1">{{ session('admin_name') }}</p>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',            'icon' => '📊', 'label' => 'Dashboard'],
                    ['route' => 'admin.users.index',          'icon' => '👥', 'label' => 'Uživatelé'],
                    ['route' => 'admin.subscriptions.index',  'icon' => '💳', 'label' => 'Předplatné'],
                    ['route' => 'admin.plans.index',          'icon' => '📋', 'label' => 'Plány'],
                    ['route' => 'admin.gallery.index',        'icon' => '🖼️', 'label' => 'Galerie'],
                    ['route' => 'admin.gallery.pending',      'icon' => '⏳', 'label' => 'Ke schválení'],
                    ['route' => 'admin.blog.index',           'icon' => '📝', 'label' => 'Blog'],
                    ['route' => 'admin.comments.index',       'icon' => '💬', 'label' => 'Komentáře'],
                    ['route' => 'admin.theme.index',          'icon' => '🎨', 'label' => 'Vzhled'],
                    ['route' => 'admin.extensions.index',     'icon' => '🧩', 'label' => 'Rozšíření'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center space-x-3 px-3 py-2 rounded-lg text-sm transition-all
                          {{ request()->routeIs($item['route'].'*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <span>{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-sm text-gray-400 hover:text-red-400 flex items-center space-x-2">
                    <span>🚪</span><span>Odhlásit se</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Hlavní obsah -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top bar -->
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
            <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center space-x-4 text-sm text-gray-500">
                <a href="{{ route('home') }}" target="_blank" class="hover:text-blue-600">🌐 Zobrazit web</a>
                <span>{{ session('admin_email') }}</span>
            </div>
        </header>

        <!-- Flash -->
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">✅ {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                @foreach($errors->all() as $e) ❌ {{ $e }}<br> @endforeach
            </div>
        @endif

        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
