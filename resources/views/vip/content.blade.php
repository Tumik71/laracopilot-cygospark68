@extends('layouts.app')
@section('title', 'VIP Sekce – Elektro Portal')
@section('content')
<div class="bg-gradient-to-r from-gray-900 via-gray-800 to-yellow-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-yellow-400 text-sm font-semibold mb-1">👑 VIP SEKCE</div>
                <h1 class="text-4xl font-extrabold">Vítejte, {{ session('vip_user') }}!</h1>
                <p class="text-gray-400 mt-1">Exkluzivní obsah dostupný pouze pro VIP předplatitele</p>
            </div>
            <form action="{{ route('vip.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg text-sm transition">Odhlásit se</button>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($contents as $content)
        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden group">
            <div class="h-44 bg-gradient-to-br from-gray-800 to-yellow-900 flex items-center justify-center relative">
                @if($content->thumbnail)
                    <img src="/storage/{{ $content->thumbnail }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
                @else
                    <span class="text-5xl">{{ $content->type === 'video' ? '🎬' : ($content->type === 'tutorial' ? '📚' : ($content->type === 'guide' ? '📋' : ($content->type === 'download' ? '⬇️' : '🎥'))) }}</span>
                @endif
                <div class="absolute top-3 left-3">
                    <span class="bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded">{{ $content->getTypeLabel() }}</span>
                </div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-800 mb-2 group-hover:text-yellow-600 transition">{{ $content->title }}</h3>
                <div class="text-gray-500 text-sm mb-3 line-clamp-2">{!! strip_tags($content->content) !!}</div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">{{ $content->created_at->format('d.m.Y') }}</span>
                    <a href="{{ route('vip.video', $content->id) }}" class="bg-yellow-400 text-gray-900 text-sm font-semibold px-4 py-1.5 rounded-lg hover:bg-yellow-300 transition">Zobrazit →</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <p class="text-3xl mb-3">👑</p>
            <p>VIP obsah bude brzy přidán.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $contents->links() }}</div>
</div>
@endsection
