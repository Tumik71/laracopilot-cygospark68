@extends('layouts.app')
@section('title', $post->title)
@section('content')

<div class="max-w-3xl mx-auto px-4 py-10">
    <a href="{{ route('blog.index') }}" class="text-blue-600 hover:underline text-sm">← Zpět na blog</a>

    <article class="mt-4 bg-white rounded-2xl shadow-lg overflow-hidden">
        @if($post->image_path)
        <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
        @else
        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-700 flex items-center justify-center">
            <span class="text-6xl">📰</span>
        </div>
        @endif

        <div class="p-8">
            @if($post->category)
            <span class="text-xs text-blue-600 font-semibold uppercase tracking-wide">{{ $post->category }}</span>
            @endif
            <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-4">{{ $post->title }}</h1>
            <div class="text-sm text-gray-400 mb-6">{{ $post->created_at->format('d. m. Y') }}</div>
            <div class="prose max-w-none text-gray-700 leading-relaxed">{!! nl2br(e(strip_tags($post->content))) !!}</div>
        </div>
    </article>

    <!-- Komentáře -->
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">💬 Komentáře ({{ count($comments) }})</h2>

        @if(session('user_id'))
        <form method="POST" action="{{ route('blog.comment', $post->id) }}" class="mb-6">
            @csrf
            <textarea name="content" rows="3" required
                      class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Váš komentář..."></textarea>
            <button type="submit" class="mt-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Odeslat</button>
        </form>
        @else
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-sm">
            <a href="{{ route('login') }}" class="text-blue-600 font-medium">Přihlaste se</a> pro přidání komentáře.
        </div>
        @endif

        <div class="space-y-4">
            @forelse($comments as $comment)
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-600 text-sm">
                        {{ substr($comment->user?->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="font-medium text-sm">{{ $comment->user?->name ?? 'Anonym' }}</span>
                    <span class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
            </div>
            @empty
            <p class="text-gray-400 text-sm">Zatím žádné komentáře.</p>
            @endforelse
        </div>
    </div>

    <!-- Související články -->
    @if($related->count())
    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">📚 Podobné články</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($related as $r)
            <a href="{{ route('blog.show', $r->slug) }}" class="bg-white rounded-lg p-4 shadow hover:shadow-md transition-all">
                <h3 class="font-semibold text-gray-800 text-sm">{{ $r->title }}</h3>
                <p class="text-xs text-gray-400 mt-1">{{ $r->created_at->format('d.m.Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
