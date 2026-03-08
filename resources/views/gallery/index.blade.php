@extends('layouts.app')
@section('title', 'Galerie')
@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <h1 class="text-3xl font-bold">🖼️ Fotogalerie</h1>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('gallery.index') }}" class="px-4 py-2 {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }} rounded-lg text-sm font-medium">Vše</a>
            @foreach($categories as $cat)
            <a href="{{ route('gallery.index') }}?category={{ urlencode($cat) }}" class="px-4 py-2 {{ request('category') === $cat ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }} rounded-lg text-sm font-medium">{{ $cat }}</a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($items as $item)
        <a href="{{ route('gallery.show', $item->id) }}" class="group relative overflow-hidden rounded-xl aspect-square bg-gray-100 shadow hover:shadow-lg transition-all">
            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                <p class="text-white font-semibold text-sm">{{ $item->title }}</p>
                @if($item->ratings_avg_value)
                <div class="flex gap-0.5 mt-1">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="text-xs {{ $i <= round($item->ratings_avg_value) ? 'text-yellow-400' : 'text-gray-500' }}">★</span>
                    @endfor
                </div>
                @endif
            </div>
        </a>
        @empty
        <div class="col-span-4 text-center py-20 text-gray-400">
            <div class="text-5xl mb-3">🖼️</div>
            <p>Zatím žádné fotografie.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $items->withQueryString()->links() }}</div>
</div>

@endsection
