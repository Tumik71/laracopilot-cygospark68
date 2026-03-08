@extends('layouts.app')
@section('title', 'Video Chat – Elektro Portal')
@section('content')
<div class="bg-gradient-to-r from-gray-900 to-red-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold">🎬 Video Chat</h1>
        <p class="text-gray-400 mt-2">Video tutoriály a odborné záznamy z praxe elektrikáře</p>
        @if(!$isVip)
        <div class="mt-4 inline-flex items-center bg-yellow-400/20 border border-yellow-400/30 rounded-full px-4 py-2 text-yellow-400 text-sm">
            👑 VIP videa jsou dostupná pouze předplatitelům.
            <a href="{{ route('vip.info') }}" class="ml-2 underline font-semibold">Zjistit více →</a>
        </div>
        @endif
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
        <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">
            <div class="aspect-video bg-gray-900 relative flex items-center justify-center">
                @if($video->youtube_id)
                    @if($video->vip_only && !$isVip)
                        <div class="absolute inset-0 bg-gray-900/90 flex flex-col items-center justify-center">
                            <span class="text-4xl mb-2">🔒</span>
                            <span class="text-white font-semibold">VIP Obsah</span>
                            <a href="{{ route('vip.info') }}" class="text-yellow-400 text-sm mt-2 hover:underline">Odemknout →</a>
                        </div>
                    @else
                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg" alt="{{ $video->title }}" class="w-full h-full object-cover">
                        <a href="{{ $video->youtube_url }}" target="_blank" class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                                <span class="text-white text-3xl ml-1">▶</span>
                            </div>
                        </a>
                    @endif
                @else
                    <span class="text-5xl">🎬</span>
                @endif
            </div>
            <div class="p-5">
                <div class="flex justify-between items-start mb-2">
                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded font-semibold">{{ $video->category }}</span>
                    @if($video->vip_only)
                        <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">👑 VIP</span>
                    @endif
                </div>
                <h3 class="font-bold text-gray-800 mb-1">{{ $video->title }}</h3>
                @if($video->description)
                    <p class="text-gray-500 text-sm line-clamp-2 mb-2">{{ $video->description }}</p>
                @endif
                <div class="flex justify-between items-center text-xs text-gray-400">
                    @if($video->duration)<span>⏱ {{ $video->duration }}</span>@endif
                    <span>👁 {{ number_format($video->views) }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 text-gray-400">
            <p class="text-3xl mb-3">🎬</p>
            <p>Videa budou brzy přidána.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $videos->links() }}</div>
</div>
@endsection
