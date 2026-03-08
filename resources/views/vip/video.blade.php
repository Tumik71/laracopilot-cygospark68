@extends('layouts.app')
@section('title', $video->title . ' – VIP Elektro Portal')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <a href="{{ route('vip.content') }}" class="text-yellow-600 hover:underline text-sm">← Zpět na VIP sekci</a>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mt-4">
        @if($video->youtube_url)
        <div class="aspect-video">
            @php
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->youtube_url, $matches);
                $ytId = $matches[1] ?? null;
            @endphp
            @if($ytId)
                <iframe src="https://www.youtube.com/embed/{{ $ytId }}" class="w-full h-full" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
            @endif
        </div>
        @endif
        <div class="p-8">
            <span class="bg-yellow-100 text-yellow-700 text-sm font-semibold px-3 py-1 rounded-full">{{ $video->getTypeLabel() }}</span>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-4 mb-4">{{ $video->title }}</h1>
            <div class="prose max-w-none text-gray-700">{!! nl2br(e($video->content)) !!}</div>
            @if($video->file_path)
            <div class="mt-6 p-4 bg-gray-50 rounded-xl border">
                <p class="font-semibold text-gray-700 mb-2">⬇️ Příloha ke stažení:</p>
                <a href="/storage/{{ $video->file_path }}" download="{{ $video->file_name }}" class="text-yellow-600 hover:underline">{{ $video->file_name }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
