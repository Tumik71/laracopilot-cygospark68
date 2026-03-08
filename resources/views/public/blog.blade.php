@extends('layouts.app')
@section('title', 'Blog – Elektro Portal')
@section('content')
<div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold">📝 Blog</h1>
        <p class="text-gray-400 mt-2">Odborné články, návody a novinky z elektrotechniky</p>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($posts as $post)
        <article class="bg-white rounded-2xl shadow hover:shadow-xl transition group overflow-hidden">
            <div class="h-48 bg-gradient-to-br from-gray-800 to-yellow-800 flex items-center justify-center">
                @if($post->image)
                    <img src="/storage/{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @else
                    <span class="text-5xl">⚡</span>
                @endif
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $post->category }}</span>
                    @if($post->vip_only)
                        <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-2 py-1 rounded-full">👑 VIP</span>
                    @endif
                </div>
                <h2 class="font-bold text-gray-800 text-lg mb-2 group-hover:text-yellow-600 transition">{{ $post->title }}</h2>
                <p class="text-gray-500 text-sm mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">{{ $post->created_at->format('d.m.Y') }} · 👁 {{ number_format($post->views) }}</span>
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-yellow-600 text-sm font-semibold hover:underline">Číst celý →</a>
                </div>
            </div>
        </article>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <p class="text-2xl mb-2">📄</p>
            <p>Zatím žádné články. Brzy přidáme první obsah.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection
