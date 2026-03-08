@extends('layouts.admin')
@section('title', 'VIP Obsah')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">👑 VIP Obsah</h1>
        <p class="text-gray-500 text-sm">Exkluzivní obsah pro předplatitele</p>
    </div>
    <a href="{{ route('admin.vip.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">+ Přidat VIP obsah</a>
</div>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Název</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Typ</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Autor</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Datum</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Akce</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($contents as $content)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $content->title }}</td>
                <td class="px-6 py-4">
                    <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full">{{ $content->getTypeLabel() }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $content->author }}</td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $content->created_at->format('d.m.Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.vip.edit', $content->id) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-3">✏️</a>
                    <form action="{{ route('admin.vip.destroy', $content->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Smazat VIP obsah?')" class="text-red-500 text-sm">🗑</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12 text-gray-400">Žádný VIP obsah.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $contents->links() }}</div>
@endsection
