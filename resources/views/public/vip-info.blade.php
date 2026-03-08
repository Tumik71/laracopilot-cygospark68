@extends('layouts.app')
@section('title', 'VIP Členství – Elektro Portal')
@section('content')
<div class="bg-gradient-to-br from-gray-900 via-gray-800 to-yellow-900 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="text-6xl mb-4">👑</div>
        <h1 class="text-5xl font-extrabold mb-4">VIP Členství</h1>
        <p class="text-gray-300 text-xl mb-8">Přístup k exkluzivnímu obsahu pro profesionální elektrikáře a montéry</p>
        <div class="text-6xl font-extrabold text-yellow-400">299 Kč<span class="text-2xl font-normal text-gray-400">/měsíc</span></div>
        <p class="text-gray-400 mt-2">Kdykoli zrušitelné · Platba přes Stripe · Okamžitý přístup</p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Co získáte v VIP sekci:</h2>
            <ul class="space-y-3">
                @foreach([
                    ['🎬', 'Exkluzivní video tutoriály', 'Profesionální videa z praxe elektrikáře'],
                    ['📚', 'Odborné tutoriály', 'Krok za krokem průvodce složitými instalacemi'],
                    ['📋', 'PDF průvodce ke stažení', 'Dokumentace, schémata a šablony pro revize'],
                    ['🎥', 'Live webináře', 'Měsíční online semináře s odborníky'],
                    ['🖼️', 'VIP Galerie', 'Přístup k exkluzivním fotografiím realizací'],
                    ['📝', 'VIP Články', 'Podrobné odborné články určené jen pro profíky'],
                ] as [$icon, $title, $desc])
                <li class="flex items-start space-x-3">
                    <span class="text-2xl">{{ $icon }}</span>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $title }}</p>
                        <p class="text-gray-500 text-sm">{{ $desc }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-yellow-400 to-red-500 rounded-2xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-2">Začněte hned dnes!</h3>
                <p class="mb-6 opacity-90">Registrujte se a získejte okamžitý přístup ke všemu VIP obsahu.</p>
                <a href="{{ route('vip.register') }}" class="block bg-white text-gray-900 font-bold text-center py-4 rounded-xl hover:opacity-90 transition">
                    Registrovat se a předplatit
                </a>
                <p class="text-center mt-3 text-sm opacity-75">Nebo se <a href="{{ route('vip.login') }}" class="underline">přihlaste</a> pokud máte účet</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-6">
                <h4 class="font-bold text-gray-800 mb-3">Bezpečná platba</h4>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-white border rounded px-3 py-1 text-sm text-gray-600">💳 Visa</span>
                    <span class="bg-white border rounded px-3 py-1 text-sm text-gray-600">💳 Mastercard</span>
                    <span class="bg-white border rounded px-3 py-1 text-sm text-gray-600">🔒 SSL Šifrování</span>
                    <span class="bg-white border rounded px-3 py-1 text-sm text-gray-600">⚡ Stripe</span>
                </div>
                <p class="text-gray-400 text-sm mt-3">Platby jsou zpracovány bezpečně přes Stripe. Vaše platební údaje nikdy neskladujeme.</p>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Časté otázky</h2>
        <div class="space-y-4">
            @foreach([
                ['Mohu předplatné kdykoli zrušit?', 'Ano, předplatné lze zrušit kdykoliv bez poplatků. Přístup zůstane aktivní do konce zaplaceného období.'],
                ['Kdy získám přístup?', 'Přístup je okamžitý po úspěšné platbě. Obdržíte přihlašovací údaje e-mailem.'],
                ['Jaká jsou platební metody?', 'Přijímáme všechny hlavní platební karty (Visa, Mastercard) a platbu zpracovává Stripe.'],
                ['Je obsah v češtině?', 'Ano, veškerý obsah na Elektro Portálu je v českém jazyce.'],
            ] as [$q, $a])
            <div class="bg-white rounded-xl border p-5">
                <p class="font-semibold text-gray-800">❓ {{ $q }}</p>
                <p class="text-gray-500 text-sm mt-2">{{ $a }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
