@extends('layouts.app')
@section('title', $post->title . ' – Elektro Portal')
@section('meta_description', $post->meta_description ?? $post->excerpt)
@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-6">
        <a href="{{ route('blog') }}" class="text-yellow-600 hover:underline text-sm">← Zpět na Blog</a>
    </div>
    <article class="bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($post->image)
        <div class="h-72">
            <img src="/storage/{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
        @endif
        <div class="p-8">
            <div class="flex items-center gap-3 mb-4">
                <span class="bg-yellow-100 text-yellow-700 text-sm font-semibold px-3 py-1 rounded-full">{{ $post->category }}</span>
                @if($post->vip_only)
                    <span class="bg-purple-100 text-purple-700 text-sm font-semibold px-3 py-1 rounded-full">👑 VIP Obsah</span>
                @endif
                <span class="text-gray-400 text-sm">{{ $post->created_at->format('d. m. Y') }}</span>
                <span class="text-gray-400 text-sm">· 👁 {{ number_format($post->views) }} zobrazení</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">{{ $post->title }}</h1>
            <div class="flex items-center mb-8 text-sm text-gray-500">
                <span>✍️ Autor: <strong>{{ $post->author }}</strong></span>
            </div>
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>
    </article>

    @if($related->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📖 Další články v kategorii {{ $post->category }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $r)
            <a href="{{ route('blog.show', $r->slug) }}" class="bg-white rounded-xl shadow p-4 hover:shadow-lg transition group">
                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">{{ $r->category }}</span>
                <h3 class="font-semibold text-gray-800 mt-2 group-hover:text-yellow-600">{{ $r->title }}</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $r->created_at->format('d.m.Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
