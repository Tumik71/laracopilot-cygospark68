@extends('layouts.admin')
@section('title', 'Upravit fotografii')
@section('content')
<div class="mb-6">
    <a href="{{ route('admin.gallery.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Zpět na galerii</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-1">✏️ Upravit fotografii</h1>
</div>
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6">
        @if($item->image)
            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-700 mb-2">Aktuální fotografie:</p>
                <img src="/storage/{{ $item->image }}" alt="{{ $item->title }}" class="w-48 h-36 object-cover rounded-lg border" onerror="this.style.display='none'">
            </div>
        @endif
        <form action="{{ route('admin.gallery.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Název *</label>
                <input type="text" name="title" required value="{{ old('title', $item->title) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Popis</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">{{ old('description', $item->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategorie *</label>
                <select name="category" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @foreach(['Instalace','Rozvaděče','Osvětlení','Revize','Fotovoltaika','Smart Home'] as $cat)
                        <option value="{{ $cat }}" {{ $item->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nahradit fotografii (volitelné)</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="vip_only" id="vip_only" value="1" {{ $item->vip_only ? 'checked' : '' }} class="mr-2">
                <label for="vip_only" class="text-sm font-medium">👑 Pouze pro VIP</label>
            </div>
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.gallery.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Zrušit</a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-yellow-400 to-red-500 text-white font-semibold rounded-lg hover:opacity-90 transition">Uložit změny</button>
            </div>
        </form>
    </div>
</div>
@endsection
