@extends('layouts.app')
@section('title', 'Blog')
@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <h1 class="text-3xl font-bold">📝 Blog</h1>
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Hledat..." class="border rounded-lg px-3 py-2 text-sm">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">🔍</button>
        </form>
    </div>

    @if($categories->count())
    <div class="flex gap-2 flex-wrap mb-8">
        <a href="{{ route('blog.index') }}" class="px-4 py-2 {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-100' }} rounded-lg text-sm">Vše</a>
        @foreach($categories as $cat)
        <a href="?category={{ urlencode($cat) }}" class="px-4 py-2 {{ request('category') === $cat ? 'bg-blue-600 text-white' : 'bg-gray-100' }} rounded-lg text-sm">{{ $cat }}</a>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($posts as $post)
        <article class="bg-white rounded-xl shadow hover:shadow-lg transition-all overflow-hidden">
            <div class="h-44 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                @if($post->image_path)
                    <img src="{{ asset('storage/'.$post->image_path) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-5xl">📰</span>
                @endif
            </div>
            <div class="p-5">
                @if($post->category)<span class="text-xs text-blue-600 font-semibold uppercase">{{ $post->category }}</span>@endif
                <h2 class="font-bold text-lg text-gray-800 mt-1 mb-2">{{ $post->title }}</h2>
                <p class="text-gray-500 text-sm">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}</p>
                <div class="flex items-center justify-between mt-4">
                    <span class="text-xs text-gray-400">{{ $post->created_at->format('d.m.Y') }}</span>
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 text-sm font-medium hover:underline">Číst →</a>
                </div>
            </div>
        </article>
        @empty
        <div class="col-span-3 text-center py-20 text-gray-400">
            <div class="text-5xl mb-3">📝</div>
            <p>Zatím žádné články.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $posts->withQueryString()->links() }}</div>
</div>

@endsection
