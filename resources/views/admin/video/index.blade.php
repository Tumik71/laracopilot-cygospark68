@extends('layouts.admin')
@section('title', 'Videa')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">🎬 Správa videí</h1>
        <p class="text-gray-500 text-sm">YouTube videa a video tutoriály</p>
    </div>
    <a href="{{ route('admin.video.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">+ Přidat video</a>
</div>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Název</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kategorie</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Délka</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Přístup</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Akce</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($videos as $video)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <p class="text-sm font-medium text-gray-800">{{ $video->title }}</p>
                    @if($video->youtube_url)
                        <a href="{{ $video->youtube_url }}" target="_blank" class="text-xs text-red-500 hover:underline">▶ YouTube</a>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $video->category }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $video->duration ?? '–' }}</td>
                <td class="px-6 py-4">
                    @if($video->vip_only)
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">👑 VIP</span>
                    @else
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">🌐 Veřejné</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.video.edit', $video->id) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-3">✏️</a>
                    <form action="{{ route('admin.video.destroy', $video->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Smazat video?')" class="text-red-500 text-sm">🗑</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12 text-gray-400">Žádná videa.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $videos->links() }}</div>
@endsection
