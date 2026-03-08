@extends('layouts.admin')
@section('title', 'Upravit článek')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blog.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Zpět na seznam</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-1">✏️ Upravit článek</h1>
</div>

<form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nadpis článku *</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Krátký popis</label>
                    <textarea name="excerpt" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('excerpt', $post->getRawOriginal('excerpt')) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Obsah článku *</label>
                    <textarea name="content" rows="15" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('content', $post->content) }}</textarea>
                </div>
            </div>
        </div>
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Nastavení</h3>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategorie *</label>
                    <select name="category" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @foreach(['Instalace','Bezpečnost','Osvětlení','Revize','Rozvaděče','Smart Home','Fotovoltaika','Obnovitelné zdroje','Projektování','Komponenty','Obecné'] as $cat)
                            <option value="{{ $cat }}" {{ $post->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nová fotografie</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @if($post->image)
                        <p class="text-xs text-gray-400 mt-1">Aktuální: {{ basename($post->image) }}</p>
                    @endif
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Meta popis (SEO)</label>
                    <textarea name="meta_description" rows="2" maxlength="160" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('meta_description', $post->meta_description) }}</textarea>
                </div>
                <div class="flex items-center mb-3">
                    <input type="checkbox" name="published" id="published" value="1" {{ $post->published ? 'checked' : '' }} class="mr-2">
                    <label for="published" class="text-sm font-medium">✅ Publikováno</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="vip_only" id="vip_only" value="1" {{ $post->vip_only ? 'checked' : '' }} class="mr-2">
                    <label for="vip_only" class="text-sm font-medium">👑 Pouze pro VIP</label>
                </div>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold py-3 rounded-xl hover:opacity-90 transition">
                Aktualizovat článek
            </button>
        </div>
    </div>
</form>
@endsection
