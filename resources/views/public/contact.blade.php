@extends('layouts.app')
@section('title', 'Kontakt – Elektro Portal')
@section('content')
<div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold">📞 Kontaktujte nás</h1>
        <p class="text-gray-400 mt-2">Máte dotaz? Napište nám.</p>
    </div>
</div>
<div class="max-w-5xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Napište nám zprávu</h2>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                    ✅ {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jméno a příjmení *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">E-mail *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Telefon</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+420 xxx xxx xxx" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Zpráva *</label>
                    <textarea name="message" rows="6" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-bold py-4 rounded-xl hover:opacity-90 transition">
                    Odeslat zprávu ✉️
                </button>
            </form>
        </div>
        <div class="space-y-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kontaktní informace</h2>
            @foreach([
                ['📧', 'E-mail', 'info@elektro-portal.cz', 'mailto:info@elektro-portal.cz'],
                ['📞', 'Telefon', '+420 800 123 456', 'tel:+420800123456'],
                ['🌐', 'Web', 'www.elektro-portal.cz', 'https://elektro-portal.cz'],
                ['📍', 'Sídlo', 'Česká republika', null],
            ] as [$icon, $label, $value, $link])
            <div class="flex items-center space-x-4 bg-white rounded-xl border p-5">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-2xl">{{ $icon }}</div>
                <div>
                    <p class="text-sm text-gray-500">{{ $label }}</p>
                    @if($link)
                        <a href="{{ $link }}" class="font-semibold text-gray-800 hover:text-yellow-600">{{ $value }}</a>
                    @else
                        <p class="font-semibold text-gray-800">{{ $value }}</p>
                    @endif
                </div>
            </div>
            @endforeach
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-6 text-white">
                <h3 class="font-bold text-lg mb-2">👑 Chcete VIP přístup?</h3>
                <p class="text-gray-300 text-sm mb-4">Získejte přístup k exkluzivnímu obsahu pro elektrotechniky.</p>
                <a href="{{ route('vip.info') }}" class="inline-block bg-yellow-400 text-gray-900 font-bold px-6 py-2 rounded-lg hover:bg-yellow-300 transition text-sm">Více o VIP →</a>
            </div>
        </div>
    </div>
</div>
@endsection
