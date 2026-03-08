@extends('layouts.admin')
@section('title', 'Přidat video')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.video.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Zpět</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-1">🎬 Přidat video</h1>
</div>
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.video.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Název videa *</label>
                <input type="text" name="title" required value="{{ old('title') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Popis</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategorie *</label>
                    <select name="category" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        @foreach(['Základy','Instalace','Osvětlení','Rozvaděče','Bezpečnost','FVE','Vzdělávání','Smart Home'] as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Délka (mm:ss)</label>
                    <input type="text" name="duration" value="{{ old('duration') }}" placeholder="12:34" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Náhledový obrázek</label>
                <input type="file" name="thumbnail" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="vip_only" id="vip_only" value="1" class="mr-2">
                <label for="vip_only" class="text-sm font-medium">👑 Pouze pro VIP předplatitele</label>
            </div>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.video.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Zrušit</a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold rounded-lg hover:opacity-90 transition">Uložit video</button>
            </div>
        </form>
    </div>
</div>
@endsection
