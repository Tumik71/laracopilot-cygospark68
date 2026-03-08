@extends('layouts.admin')
@section('title', 'Nový článek')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blog.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Zpět na seznam</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-1">📝 Nový článek</h1>
</div>

<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nadpis článku *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Zadejte nadpis článku"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('title') border-red-400 @enderror">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Krátký popis (excerpt)</label>
                    <textarea name="excerpt" rows="2" placeholder="Krátký popis pro náhled článku..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('excerpt') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Obsah článku *</label>
                    <textarea name="content" rows="15" required placeholder="Napište obsah článku..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('content') border-red-400 @enderror">{{ old('content') }}</textarea>
                    @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Nastavení</h3>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategorie *</label>
                    <select name="category" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <option value="Instalace">Instalace</option>
                        <option value="Bezpečnost">Bezpečnost</option>
                        <option value="Osvětlení">Osvětlení</option>
                        <option value="Revize">Revize</option>
                        <option value="Rozvaděče">Rozvaděče</option>
                        <option value="Smart Home">Smart Home</option>
                        <option value="Fotovoltaika">Fotovoltaika</option>
                        <option value="Obnovitelné zdroje">Obnovitelné zdroje</option>
                        <option value="Projektování">Projektování</option>
                        <option value="Komponenty">Komponenty</option>
                        <option value="Obecné">Obecné</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Titulní fotografie</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Meta popis (SEO)</label>
                    <textarea name="meta_description" rows="2" maxlength="160" placeholder="Max. 160 znaků..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('meta_description') }}</textarea>
                </div>
                <div class="flex items-center mb-3">
                    <input type="checkbox" name="published" id="published" value="1" {{ old('published') ? 'checked' : '' }} class="mr-2">
                    <label for="published" class="text-sm font-medium text-gray-700">✅ Publikovat hned</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="vip_only" id="vip_only" value="1" {{ old('vip_only') ? 'checked' : '' }} class="mr-2">
                    <label for="vip_only" class="text-sm font-medium text-gray-700">👑 Pouze pro VIP</label>
                </div>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold py-3 rounded-xl hover:opacity-90 transition">
                Uložit článek
            </button>
        </div>
    </div>
</form>
@endsection
