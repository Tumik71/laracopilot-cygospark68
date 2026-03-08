@extends('layouts.app')
@section('title', 'Galerie realizací – Elektro Portal')
@section('content')
<div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold">🖼️ Galerie realizací</h1>
        <p class="text-gray-400 mt-2">Fotografie dokončených elektroinstalací a prací</p>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Filtry kategorie -->
    @if($categories->count() > 0)
    <div class="flex flex-wrap gap-2 mb-8">
        <span class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-full text-sm font-semibold cursor-pointer">Vše</span>
        @foreach($categories as $cat)
            <span class="bg-white border text-gray-600 px-4 py-2 rounded-full text-sm font-medium hover:bg-yellow-50 cursor-pointer">{{ $cat }}</span>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($items as $item)
        <div class="group relative aspect-square bg-gray-200 rounded-xl overflow-hidden cursor-pointer">
            <img src="/storage/{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                onerror="this.parentElement.innerHTML='<div class=\'flex flex-col items-center justify-center w-full h-full bg-gradient-to-br from-gray-700 to-yellow-800\'><span class=\'text-4xl\'>⚡</span></div>'">
            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-3">
                <p class="text-white text-sm font-semibold">{{ $item->title }}</p>
                <p class="text-yellow-400 text-xs">{{ $item->category }}</p>
                @if($item->vip_only)
                    <span class="text-xs text-yellow-300 mt-1">👑 VIP</span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center py-16 text-gray-400">
            <p class="text-2xl mb-2">🖼️</p>
            <p>Galerie bude brzy naplněna fotografiemi realizací.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $items->links() }}</div>
</div>
@endsection
