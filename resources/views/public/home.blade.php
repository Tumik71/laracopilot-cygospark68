@extends('layouts.app')
@section('title', 'Elektro Portal – Elektroservis & Elektroinstalace')
@section('content')

<!-- HERO SEKCE -->
<section class="bg-gradient-to-br from-gray-900 via-gray-800 to-yellow-900 text-white py-24">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <div class="inline-block bg-yellow-400/20 border border-yellow-400/30 rounded-full px-4 py-2 text-yellow-400 text-sm font-semibold mb-6">
            ⚡ Odborný portál pro elektrotechniky
        </div>
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight">
            Elektro<span class="text-yellow-400">Portal</span>.cz
        </h1>
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            Váš odborný průvodce světem elektroinstalací, elektroservisu a moderní elektrotechniky. Vzdělávání, galerie realizací a exkluzivní VIP obsah pro profesionály.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('blog') }}" class="bg-yellow-400 text-gray-900 font-bold px-8 py-4 rounded-xl hover:bg-yellow-300 transition text-lg">
                📚 Číst Blog
            </a>
            <a href="{{ route('vip.info') }}" class="border-2 border-yellow-400 text-yellow-400 font-bold px-8 py-4 rounded-xl hover:bg-yellow-400 hover:text-gray-900 transition text-lg">
                👑 VIP Členství
            </a>
        </div>
    </div>
</section>

<!-- STATISTIKY -->
<section class="bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div class="text-white">
                <div class="text-3xl font-bold text-yellow-400">500+</div>
                <div class="text-gray-400 text-sm">Článků & tutoriálů</div>
            </div>
            <div class="text-white">
                <div class="text-3xl font-bold text-yellow-400">150+</div>
                <div class="text-gray-400 text-sm">Videí & tutoriálů</div>
            </div>
            <div class="text-white">
                <div class="text-3xl font-bold text-yellow-400">2 000+</div>
                <div class="text-gray-400 text-sm">VIP Předplatitelů</div>
            </div>
            <div class="text-white">
                <div class="text-3xl font-bold text-yellow-400">10+</div>
                <div class="text-gray-400 text-sm">Let zkušeností</div>
            </div>
        </div>
    </div>
</section>

<!-- NEJNOVĚJŠÍ ČLÁNKY -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">📝 Nejnovější články</h2>
                <p class="text-gray-500 mt-1">Odborné informace z praxe elektrikáře</p>
            </div>
            <a href="{{ route('blog') }}" class="text-yellow-600 font-semibold hover:underline">Zobrazit vše →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($latestPosts as $post)
            <article class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition group">
                <div class="h-48 bg-gradient-to-br from-gray-800 to-yellow-700 flex items-center justify-center">
                    @if($post->image)
                        <img src="/storage/{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-6xl">⚡</span>
                    @endif
                </div>
                <div class="p-5">
                    <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-1 rounded mb-2">{{ $post->category }}</span>
                    <h3 class="font-bold text-gray-800 mb-2 group-hover:text-yellow-600 transition">{{ $post->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-400">{{ $post->created_at->format('d.m.Y') }}</span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-yellow-600 text-sm font-semibold hover:underline">Číst →</a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-3 text-center py-8 text-gray-400">Brzy přidáme první články.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- GALERIE PREVIEW -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">🖼️ Galerie realizací</h2>
                <p class="text-gray-500 mt-1">Ukázky naší práce a odborných instalací</p>
            </div>
            <a href="{{ route('gallery') }}" class="text-yellow-600 font-semibold hover:underline">Celá galerie →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($galleryItems as $item)
            <div class="aspect-square bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl overflow-hidden hover:opacity-90 transition cursor-pointer">
                <img src="/storage/{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\'flex items-center justify-center w-full h-full bg-gradient-to-br from-gray-700 to-yellow-800\'><span class=\'text-5xl\'>⚡</span></div>'">
            </div>
            @empty
                @for($i = 0; $i < 6; $i++)
                <div class="aspect-square bg-gradient-to-br from-gray-700 to-yellow-800 rounded-xl flex items-center justify-center">
                    <span class="text-5xl">⚡</span>
                </div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- VIP SEKCE PROMO -->
<section class="py-20 bg-gradient-to-r from-gray-900 to-gray-800">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="text-5xl mb-4">👑</div>
        <h2 class="text-4xl font-extrabold text-white mb-4">VIP Členství</h2>
        <p class="text-gray-300 text-xl mb-8">Získejte přístup k exkluzivnímu obsahu: profesionální videa, tutoriály, dokumentace ke stažení a webináře pro certifikované elektrikáře.</p>
        <div class="bg-white/10 backdrop-blur rounded-2xl p-8 mb-8 border border-yellow-400/30">
            <div class="text-5xl font-extrabold text-yellow-400 mb-2">299 Kč<span class="text-xl font-normal text-gray-400">/měsíc</span></div>
            <p class="text-gray-300 mb-6">Kdykoli zrušitelné předplatné. Platba přes Stripe.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-300 mb-6">
                <div class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Exkluzivní videa</span></div>
                <div class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>PDF průvodce</span></div>
                <div class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>Webináře live</span></div>
                <div class="flex items-center space-x-2"><span class="text-green-400">✓</span><span>VIP galerie</span></div>
            </div>
            <a href="{{ route('vip.register') }}" class="inline-block bg-gradient-to-r from-yellow-400 to-red-500 text-white font-bold px-10 py-4 rounded-xl text-lg hover:opacity-90 transition">
                Začít VIP členství
            </a>
        </div>
    </div>
</section>

<!-- VIDEA PREVIEW -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">🎬 Nejnovější videa</h2>
                <p class="text-gray-500 mt-1">Video tutoriály a elektrotechnické rady</p>
            </div>
            <a href="{{ route('video.chat') }}" class="text-yellow-600 font-semibold hover:underline">Všechna videa →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($latestVideos as $video)
            <div class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-lg transition">
                <div class="aspect-video bg-gray-900 flex items-center justify-center relative">
                    @if($video->youtube_id)
                        <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/hqdefault.jpg" alt="{{ $video->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-2xl ml-1">▶</span>
                            </div>
                        </div>
                    @else
                        <span class="text-5xl">🎬</span>
                    @endif
                </div>
                <div class="p-4">
                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">{{ $video->category }}</span>
                    <h3 class="font-semibold text-gray-800 mt-2">{{ $video->title }}</h3>
                    @if($video->duration)
                        <p class="text-xs text-gray-400 mt-1">⏱ {{ $video->duration }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8 text-gray-400">Brzy přidáme první videa.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
