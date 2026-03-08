<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Portál'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link { @apply text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200; }
    </style>
    @php $theme = \App\Models\ThemeSetting::getSettings(); @endphp
    <style id="theme-css">
        :root {
            --color-primary: {{ $theme['primary_color'] ?? '#3B82F6' }};
            --color-secondary: {{ $theme['secondary_color'] ?? '#1E40AF' }};
            --color-accent: {{ $theme['accent_color'] ?? '#F59E0B' }};
        }
        .btn-primary { background-color: {{ $theme['primary_color'] ?? '#3B82F6' }}; color: white; }
        .btn-primary:hover { background-color: {{ $theme['secondary_color'] ?? '#1E40AF' }}; }
        {!! $theme['custom_css'] ?? '' !!}
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

<!-- Navigace -->
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                @if(!empty($theme['logo_path']))
                    <img src="{{ asset('storage/'.$theme['logo_path']) }}" alt="Logo" class="h-8">
                @else
                    <span class="text-xl font-bold text-blue-600">⚡ {{ $theme['site_name'] ?? config('app.name') }}</span>
                @endif
            </a>

            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="nav-link">Domů</a>
                @if($theme['show_gallery'] ?? '1')
                    <a href="{{ route('gallery.index') }}" class="nav-link">Galerie</a>
                @endif
                @if($theme['show_blog'] ?? '1')
                    <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>
                @endif
                <a href="{{ route('vip') }}" class="nav-link">VIP</a>
                <a href="{{ route('contact') }}" class="nav-link">Kontakt</a>
            </div>

            <div class="flex items-center space-x-3">
                @if(session('user_id'))
                    <span class="text-sm text-gray-600">{{ session('user_name') }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium">Odhlásit</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600">Přihlásit</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white btn-primary transition-all">Registrace</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Flash zprávy -->
@if(session('success'))
    <div class="max-w-7xl mx-auto mt-4 px-4">
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <span class="mr-2">✅</span> {{ session('success') }}
        </div>
    </div>
@endif
@if($errors->any())
    <div class="max-w-7xl mx-auto mt-4 px-4">
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <span class="mr-2">❌</span>
            @foreach($errors->all() as $error) {{ $error }} @endforeach
        </div>
    </div>
@endif

<!-- Obsah -->
<main>
    @yield('content')
</main>

<!-- Patička -->
<footer class="bg-gray-900 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <h3 class="text-lg font-bold mb-4">⚡ {{ $theme['site_name'] ?? config('app.name') }}</h3>
            <p class="text-gray-400 text-sm">{{ $theme['site_tagline'] ?? 'Váš online domov' }}</p>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Navigace</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-white">Domů</a></li>
                <li><a href="{{ route('gallery.index') }}" class="hover:text-white">Galerie</a></li>
                <li><a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-white">Kontakt</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Účet</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('login') }}" class="hover:text-white">Přihlásit se</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-white">Registrace</a></li>
                <li><a href="{{ route('vip') }}" class="hover:text-white">VIP členství</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold mb-3">Správce</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="{{ route('admin.login') }}" class="hover:text-white">Admin přihlášení</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-gray-800 py-6 text-center text-sm text-gray-500">
        <p>© {{ date('Y') }} {{ $theme['site_name'] ?? config('app.name') }}. Všechna práva vyhrazena.</p>
        <p class="mt-1">Vytvořeno s ❤️ pomocí <a href="https://laracopilot.com/" target="_blank" class="hover:text-white underline">LaraCopilot</a></p>
    </div>
</footer>

</body>
</html>
