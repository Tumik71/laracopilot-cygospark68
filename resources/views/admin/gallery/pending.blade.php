@extends('layouts.admin')
@section('title', 'Fotografie ke schválení')
@section('content')

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b">
        <h2 class="text-lg font-semibold">⏳ Fotografie čekající na schválení ({{ $items->total() }})</h2>
    </div>

    @if($items->count() === 0)
    <div class="p-12 text-center text-gray-400">
        <div class="text-5xl mb-3">✅</div>
        <p>Žádné fotografie ke schválení.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        @foreach($items as $item)
        <div class="border rounded-xl overflow-hidden">
            <div class="h-48 bg-gray-100 flex items-center justify-center">
                <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-800">{{ $item->title }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $item->description }}</p>
                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400">
                    <span>👤 {{ $item->user?->name ?? 'Anonym' }}</span>
                    <span>📅 {{ $item->created_at->format('d.m.Y') }}</span>
                    @if($item->category)<span class="bg-gray-100 px-2 py-0.5 rounded">{{ $item->category }}</span>@endif
                </div>
                <div class="flex gap-2 mt-4">
                    <form method="POST" action="{{ route('admin.gallery.approve', $item->id) }}" class="flex-1">
                        @csrf
                        <button class="w-full py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:bg-green-600">✅ Schválit</button>
                    </form>
                    <form method="POST" action="{{ route('admin.gallery.zamítnout', $item->id) }}" class="flex-1">
                        @csrf
                        <button class="w-full py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600">❌ Zamítnout</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="p-4">{{ $items->links() }}</div>
</div>

@endsection
