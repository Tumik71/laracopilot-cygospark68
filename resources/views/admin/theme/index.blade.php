@extends('layouts.admin')
@section('title', 'Správa vzhledu')
@section('content')

<div class="space-y-6">

    <!-- Tlačítka akcí -->
    <div class="flex gap-3 flex-wrap">
        <form method="POST" action="{{ route('admin.theme.reset') }}">
            @csrf
            <button onclick="return confirm('Resetovat na výchozí nastavení?')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">🔄 Reset na výchozí</button>
        </form>
        <form method="POST" action="{{ route('admin.theme.export') }}">
            @csrf
            <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm hover:bg-blue-200">📤 Exportovat téma</button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.theme.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Barvy -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-4">🎨 Barvy</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach([
                    ['primary_color', 'Primární barva'],
                    ['secondary_color', 'Sekundární barva'],
                    ['accent_color', 'Akcent'],
                    ['background_color', 'Pozadí'],
                    ['text_color', 'Text'],
                ] as [$key, $label])
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ $label }}</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="{{ $key }}" value="{{ $theme[$key] }}"
                               class="w-12 h-10 rounded cursor-pointer border border-gray-200">
                        <input type="text" name="{{ $key }}_text" value="{{ $theme[$key] }}"
                               class="flex-1 border rounded px-2 py-1 text-xs" readonly
                               oninput="this.previousElementSibling.value = this.value">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Typografie -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-4">🔤 Typografie</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Písmo</label>
                    <select name="font_family" class="w-full border rounded-lg px-3 py-2">
                        @foreach(['Inter', 'Roboto', 'Open Sans', 'Lato', 'Poppins', 'Montserrat', 'Nunito'] as $font)
                        <option value="{{ $font }}" {{ $theme['font_family'] === $font ? 'selected' : '' }}>{{ $font }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Základní velikost písma (px)</label>
                    <input type="number" name="font_size_base" value="{{ $theme['font_size_base'] }}"
                           min="12" max="24" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
        </div>

        <!-- Rozložení -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-4">📐 Rozložení</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Šíře layoutu</label>
                    <select name="layout" class="w-full border rounded-lg px-3 py-2">
                        <option value="wide" {{ $theme['layout']==='wide'?'selected':'' }}>Široký (max-w-7xl)</option>
                        <option value="medium" {{ $theme['layout']==='medium'?'selected':'' }}>Střední (max-w-5xl)</option>
                        <option value="narrow" {{ $theme['layout']==='narrow'?'selected':'' }}>Úzký (max-w-3xl)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zaoblení rohů</label>
                    <select name="border_radius" class="w-full border rounded-lg px-3 py-2">
                        <option value="none" {{ $theme['border_radius']==='none'?'selected':'' }}>Žádné</option>
                        <option value="rounded" {{ $theme['border_radius']==='rounded'?'selected':'' }}>Mírné</option>
                        <option value="rounded-xl" {{ $theme['border_radius']==='rounded-xl'?'selected':'' }}>Výrazné</option>
                        <option value="rounded-full" {{ $theme['border_radius']==='rounded-full'?'selected':'' }}>Pilulka</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Styl hlavičky</label>
                    <select name="header_style" class="w-full border rounded-lg px-3 py-2">
                        <option value="default" {{ $theme['header_style']==='default'?'selected':'' }}>Výchozí</option>
                        <option value="centered" {{ $theme['header_style']==='centered'?'selected':'' }}>Centrovaný</option>
                        <option value="minimal" {{ $theme['header_style']==='minimal'?'selected':'' }}>Minimalistický</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Komponenty hlavní stránky -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-4">🧩 Komponenty hlavní stránky</h2>
            <p class="text-sm text-gray-500 mb-4">Vyberte a seřaďte sekce, které se zobrazí na úvodní stránce.</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach([
                    ['show_hero', 'Hero / Banner'],
                    ['show_blog', 'Blog sekce'],
                    ['show_gallery', 'Galerie'],
                    ['show_testimonials', 'Reference'],
                    ['show_pricing', 'Ceník / Plány'],
                    ['show_newsletter', 'Newsletter'],
                ] as [$key, $label])
                <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ $theme[$key] ? 'border-blue-400 bg-blue-50' : '' }}">
                    <input type="checkbox" name="{{ $key }}" value="1" {{ $theme[$key] ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600">
                    <span class="text-sm font-medium">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Obsah stránek -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-4">📄 Obsah stránek</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Název webu</label>
                    <input type="text" name="site_name" value="{{ $theme['site_name'] }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="site_tagline" value="{{ $theme['site_tagline'] }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hero nadpis</label>
                    <input type="text" name="hero_title" value="{{ $theme['hero_title'] }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hero podnadpis</label>
                    <input type="text" name="hero_subtitle" value="{{ $theme['hero_subtitle'] }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Text tlačítka CTA</label>
                    <input type="text" name="hero_cta_text" value="{{ $theme['hero_cta_text'] }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL tlačítka CTA</label>
                    <input type="text" name="hero_cta_url" value="{{ $theme['hero_cta_url'] }}" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
        </div>

        <!-- Logo a Favicon -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-4">🖼️ Logo a Favicon</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo (PNG/SVG)</label>
                    @if(!empty($theme['logo_path']))
                        <img src="{{ asset('storage/'.$theme['logo_path']) }}" class="h-12 mb-2 border rounded p-1">
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                    <input type="file" name="favicon" accept="image/*" class="w-full border rounded-lg px-3 py-2">
                </div>
            </div>
        </div>

        <!-- Vlastní CSS -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="font-semibold text-gray-800 mb-4">💻 Vlastní CSS</h2>
            <textarea name="custom_css" rows="8"
                      class="w-full border rounded-lg px-3 py-2 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="/* Sem vložte vlastní CSS kód */">{{ $theme['custom_css'] }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">💾 Uložit vzhled</button>
        </div>
    </form>

    <!-- Import -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-semibold text-gray-800 mb-4">📥 Import tématu</h2>
        <form method="POST" action="{{ route('admin.theme.import') }}" enctype="multipart/form-data" class="flex gap-3">
            @csrf
            <input type="file" name="file" accept=".json" class="flex-1 border rounded-lg px-3 py-2 text-sm">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">Importovat</button>
        </form>
    </div>
</div>

@endsection
