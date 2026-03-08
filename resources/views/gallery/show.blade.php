@extends('layouts.app')
@section('title', $item->title)
@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">
    <a href="{{ route('gallery.index') }}" class="text-blue-600 hover:underline text-sm">← Zpět na galerii</a>

    <div class="mt-4 bg-white rounded-2xl shadow-lg overflow-hidden">
        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full max-h-96 object-cover">

        <div class="p-6">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $item->title }}</h1>
                    @if($item->category)<span class="text-sm text-blue-600 font-medium">{{ $item->category }}</span>@endif
                    @if($item->description)<p class="text-gray-600 mt-2">{{ $item->description }}</p>@endif
                </div>
                <!-- Hvězdičkové hodnocení -->
                <div>
                    <p class="text-sm text-gray-500 mb-2">Průměrné hodnocení:</p>
                    <div class="flex gap-1 text-2xl">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= round($item->ratings_avg_value ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                        @endfor
                    </div>

                    @if(session('user_id'))
                    <form method="POST" action="{{ route('gallery.rate', $item->id) }}" class="mt-3">
                        @csrf
                        <div class="flex gap-1">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="submit" name="rating" value="{{ $i }}"
                                    class="text-xl {{ ($userRating ?? 0) >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400 transition-colors">★</button>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Vaše hodnocení</p>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Komentáře -->
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">💬 Komentáře ({{ count($comments) }})</h2>

        @if(session('user_id'))
        <form method="POST" action="{{ route('gallery.comment', $item->id) }}" class="mb-6">
            @csrf
            <textarea name="content" rows="3" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Napište komentář..."></textarea>
            <button type="submit" class="mt-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Odeslat</button>
        </form>
        @else
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-sm">
            <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Přihlaste se</a> pro přidání komentáře.
        </div>
        @endif

        <div class="space-y-4">
            @forelse($comments as $comment)
            <div class="bg-white rounded-xl p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-sm font-bold text-blue-600">
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
</div>

@endsection
