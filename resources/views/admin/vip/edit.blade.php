@extends('layouts.admin')
@section('title', 'Upravit VIP obsah')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.vip.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Zpět</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-1">✏️ Upravit VIP obsah</h1>
</div>
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.vip.update', $content->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Název *</label>
                <input type="text" name="title" required value="{{ old('title', $content->title) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Typ obsahu *</label>
                <select name="type" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['video' => '🎬 Video', 'tutorial' => '📚 Tutoriál', 'guide' => '📋 Průvodce', 'download' => '⬇️ Ke stažení', 'webinar' => '🎥 Webinář'] as $val => $label)
                        <option value="{{ $val }}" {{ $content->type === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Obsah / Popis *</label>
                <textarea name="content" rows="8" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('content', $content->content) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $content->youtube_url) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nový náhledový obrázek</label>
                <input type="file" name="thumbnail" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.vip.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Zrušit</a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold rounded-lg hover:opacity-90 transition">Uložit změny</button>
            </div>
        </form>
    </div>
</div>
@endsection
