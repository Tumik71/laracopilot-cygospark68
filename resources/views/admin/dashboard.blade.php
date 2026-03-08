@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="space-y-6">
    <!-- KPI Karty -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['users'] }}</div>
            <div class="text-sm text-gray-500 mt-1">👥 Celkem uživatelů</div>
            <div class="text-xs text-green-500 mt-1">+{{ $stats['users_today'] }} dnes</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['active_subs'] }}</div>
            <div class="text-sm text-gray-500 mt-1">💳 Aktivní předplatné</div>
            <div class="text-xs text-gray-400 mt-1">{{ number_format($stats['revenue_month'], 0, ',', ' ') }} Kč / měsíc</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['gallery_pending'] }}</div>
            <div class="text-sm text-gray-500 mt-1">⏳ Čeká na schválení</div>
            <div class="text-xs text-gray-400 mt-1">{{ $stats['gallery_total'] }} celkem fotek</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['comments_pending'] }}</div>
            <div class="text-sm text-gray-500 mt-1">💬 Komentáře ke schválení</div>
            <div class="text-xs text-gray-400 mt-1">{{ $stats['blog_posts'] }} článků</div>
        </div>
    </div>

    <!-- Rychlé akce -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-semibold text-gray-700 mb-4">⚡ Rychlé akce</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.gallery.pending') }}" class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-medium hover:bg-yellow-200">⏳ Schválit fotky ({{ $stats['gallery_pending'] }})</a>
            <a href="{{ route('admin.comments.index') }}?status=pending" class="px-4 py-2 bg-purple-100 text-purple-800 rounded-lg text-sm font-medium hover:bg-purple-200">💬 Schválit komentáře ({{ $stats['comments_pending'] }})</a>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm font-medium hover:bg-blue-200">👥 Správa uživatelů</a>
            <a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium hover:bg-green-200">📝 Nový článek</a>
            <a href="{{ route('admin.theme.index') }}" class="px-4 py-2 bg-pink-100 text-pink-800 rounded-lg text-sm font-medium hover:bg-pink-200">🎨 Upravit vzhled</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Noví uživatelé -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-700 mb-4">👥 Noví uživatelé</h2>
            <div class="space-y-3">
                @foreach($recentUsers as $user)
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $user->name }}</div>
                        <div class="text-xs text-gray-400">{{ $user->email }}</div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $user->role === 'vip' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' }}">{{ $user->role }}</span>
                </div>
                @endforeach
            </div>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline mt-4 block">Zobrazit vše →</a>
        </div>

        <!-- Galerie ke schválení -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-700 mb-4">⏳ Galerie ke schválení</h2>
            <div class="space-y-3">
                @forelse($recentGallery as $item)
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $item->title }}</div>
                        <div class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="flex gap-1">
                        <form method="POST" action="{{ route('admin.gallery.approve', $item->id) }}">
                            @csrf
                            <button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">✓</button>
                        </form>
                        <form method="POST" action="{{ route('admin.gallery.zamítnout', $item->id) }}">
                            @csrf
                            <button class="px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600">✗</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400">Žádné fotky ke schválení.</p>
                @endforelse
            </div>
            <a href="{{ route('admin.gallery.pending') }}" class="text-sm text-blue-600 hover:underline mt-4 block">Zobrazit vše →</a>
        </div>

        <!-- Komentáře ke schválení -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-700 mb-4">💬 Nové komentáře</h2>
            <div class="space-y-3">
                @forelse($recentComments as $comment)
                <div class="border-b pb-2">
                    <div class="text-sm text-gray-700">{{ Str::limit($comment->content, 60) }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ $comment->user?->name ?? 'Anonym' }} • {{ $comment->created_at->diffForHumans() }}</div>
                    <div class="flex gap-1 mt-1">
                        <form method="POST" action="{{ route('admin.comments.approve', $comment->id) }}">
                            @csrf
                            <button class="px-2 py-0.5 bg-green-500 text-white rounded text-xs">Schválit</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}">
                            @csrf @method('DELETE')
                            <button class="px-2 py-0.5 bg-red-500 text-white rounded text-xs">Smazat</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400">Žádné komentáře ke schválení.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
