@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Přehled – Dashboard</h1>
    <p class="text-gray-500">Vítejte, <strong>{{ session('admin_user') }}</strong>! Zde je přehled vašeho portálu.</p>
</div>

<!-- KPI Karty -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-yellow-400">
        <div class="text-2xl font-bold text-gray-800">{{ $stats['blog_posts'] }}</div>
        <div class="text-sm text-gray-500">Celkem článků</div>
        <div class="text-xs text-green-600 mt-1">{{ $stats['published_posts'] }} publikovaných</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
        <div class="text-2xl font-bold text-gray-800">{{ $stats['gallery_items'] }}</div>
        <div class="text-sm text-gray-500">Fotografie v galerii</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500">
        <div class="text-2xl font-bold text-gray-800">{{ $stats['videos'] }}</div>
        <div class="text-sm text-gray-500">Videa</div>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-l-4 border-purple-500">
        <div class="text-2xl font-bold text-gray-800">{{ $stats['subscribers'] }}</div>
        <div class="text-sm text-gray-500">VIP Předplatitelé</div>
        <div class="text-xs text-green-600 mt-1">{{ number_format($stats['monthly_revenue'], 0, ',', ' ') }} Kč/měsíc</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Poslední články -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-gray-800">📝 Poslední články</h2>
            <a href="{{ route('admin.blog.create') }}" class="text-xs bg-yellow-400 text-gray-900 px-3 py-1 rounded-full font-semibold hover:bg-yellow-500 transition">+ Nový článek</a>
        </div>
        <div class="space-y-3">
            @foreach($recentPosts as $post)
            <div class="flex justify-between items-start border-b pb-2 last:border-0">
                <div>
                    <p class="text-sm font-medium text-gray-700 line-clamp-1">{{ $post->title }}</p>
                    <p class="text-xs text-gray-400">{{ $post->category }} · {{ $post->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center space-x-1">
                    @if($post->published)
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">Publikováno</span>
                    @else
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded">Koncept</span>
                    @endif
                    @if($post->vip_only)
                        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">VIP</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('admin.blog.index') }}" class="block mt-3 text-sm text-center text-yellow-600 hover:underline">Zobrazit všechny →</a>
    </div>

    <!-- Poslední předplatitelé -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-gray-800">👑 Noví předplatitelé</h2>
            <a href="{{ route('admin.subscribers.index') }}" class="text-xs text-gray-500 hover:text-gray-700">Zobrazit vše</a>
        </div>
        <div class="space-y-3">
            @forelse($recentSubscribers as $sub)
            <div class="flex justify-between items-center border-b pb-2 last:border-0">
                <div>
                    <p class="text-sm font-medium text-gray-700">{{ $sub->name }}</p>
                    <p class="text-xs text-gray-400">{{ $sub->email }}</p>
                </div>
                <div>
                    @if($sub->active)
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">Aktivní</span>
                    @else
                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded">Neaktivní</span>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Zatím žádní předplatitelé.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
