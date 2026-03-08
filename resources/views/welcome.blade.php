@extends('layouts.app')
@section('title', $theme['site_name'] ?? 'Portál')
@section('content')
@php $theme = \App\Models\ThemeSetting::getSettings(); @endphp

<!-- Hero -->
@if($theme['show_hero'] ?? '1')
<section class="relative bg-gradient-to-br from-blue-600 to-blue-900 text-white py-24 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight">
            {{ $theme['hero_title'] ?? 'Vítejte na portálu' }}
        </h1>
        <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
            {{ $theme['hero_subtitle'] ?? 'Objevte naše možnosti.' }}
        </p>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ $theme['hero_cta_url'] ?? '/registrace' }}"
               class="px-8 py-4 bg-white text-blue-700 font-bold rounded-xl hover:shadow-xl transition-all text-lg">
                {{ $theme['hero_cta_text'] ?? 'Začít zdarma' }}
            </a>
            <a href="{{ route('gallery.index') }}" class="px-8 py-4 border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-blue-700 transition-all text-lg">
                🖼️ Galerie
            </a>
        </div>
    </div>
</section>
@endif

<!-- Blog -->
@if($theme['show_blog'] ?? '1')
<section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-10">📝 Nejnovější články</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach(\App\Models\BlogPost::where('published', true)->latest()->take(3)->get() as $post)
            <div class="bg-gray-50 rounded-xl overflow-hidden hover:shadow-lg transition-all">
                <div class="h-44 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                    <span class="text-5xl">📰</span>
                </div>
                <div class="p-5">
                    @if($post->category)
                        <span class="text-xs text-blue-600 font-semibold uppercase">{{ $post->category }}</span>
                    @endif
                    <h3 class="font-bold text-gray-800 mt-1 mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-500 text-sm">{{ Str::limit($post->excerpt ?? $post->content, 80) }}</p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="mt-3 inline-block text-blue-600 text-sm font-medium hover:underline">Číst více →</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('blog.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Všechny články</a>
        </div>
    </div>
</section>
@endif

<!-- Galerie -->
@if($theme['show_gallery'] ?? '1')
<section class="py-16 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-10">🖼️ Fotogalerie</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(\App\Models\GalleryItem::where('status', 'approved')->latest()->take(8)->get() as $item)
            <a href="{{ route('gallery.show', $item->id) }}" class="relative group overflow-hidden rounded-xl aspect-square bg-gray-200">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">{{ $item->title }}</span>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('gallery.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Celá galerie</a>
        </div>
    </div>
</section>
@endif

<!-- Ceník -->
@if($theme['show_pricing'] ?? '1')
<section class="py-16 px-4 bg-white">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-4">💳 Plány a ceník</h2>
        <p class="text-center text-gray-500 mb-10">Vyberte si plán, který vám vyhovuje.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach(\App\Models\Plan::where('active', true)->orderBy('price')->get() as $plan)
            <div class="border-2 {{ $plan->slug === 'vip' ? 'border-blue-500' : 'border-gray-200' }} rounded-xl p-6 text-center hover:shadow-lg transition-all">
                @if($plan->slug === 'vip')<div class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full inline-block mb-3">Nejoblíbenější</div>@endif
                <h3 class="text-xl font-bold mb-2">{{ $plan->name }}</h3>
                <div class="text-3xl font-extrabold text-blue-600 mb-1">{{ number_format($plan->price, 0, ',', ' ') }} Kč</div>
                <div class="text-gray-400 text-sm mb-4">/{{ $plan->interval === 'monthly' ? 'měsíc' : 'rok' }}</div>
                <p class="text-gray-500 text-sm mb-4">{{ $plan->description }}</p>
                <ul class="text-sm text-left space-y-1 mb-6">
                    @foreach($plan->features_list as $feature)
                    <li class="flex items-center gap-2"><span class="text-green-500">✓</span> {{ $feature }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('stripe.checkout') }}?plan={{ $plan->slug }}" class="block w-full py-3 {{ $plan->slug === 'vip' ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-800' }} rounded-lg font-semibold transition-all">
                    Vybrat plán
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Newsletter -->
@if($theme['show_newsletter'] ?? '1')
<section class="py-16 px-4 bg-blue-600 text-white">
    <div class="max-w-xl mx-auto text-center">
        <h2 class="text-2xl font-bold mb-3">📧 Odebírejte novinky</h2>
        <p class="text-blue-100 mb-6">Zůstaňte informováni o nejnovějším obsahu.</p>
        <form class="flex gap-2">
            <input type="email" placeholder="vas@email.cz" class="flex-1 px-4 py-3 rounded-lg text-gray-800 focus:outline-none">
            <button type="submit" class="px-6 py-3 bg-white text-blue-600 font-bold rounded-lg hover:bg-gray-100">Přihlásit</button>
        </form>
    </div>
</section>
@endif

@endsection
