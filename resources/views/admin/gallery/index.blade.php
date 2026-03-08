@extends('layouts.admin')
@section('title', 'Galerie')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">🖼️ Galerie fotografií</h1>
        <p class="text-gray-500 text-sm">Správa fotografií realizovaných prací</p>
    </div>
    <a href="{{ route('admin.gallery.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">+ Přidat fotografii</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Fotografie</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Název</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kategorie</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Přístup</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Datum</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Akce</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($items as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="w-16 h-12 bg-gray-200 rounded-lg overflow-hidden">
                        <img src="/storage/{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/64x48/e5e7eb/9ca3af?text=⚡'">
                    </div>
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $item->title }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->category }}</td>
                <td class="px-6 py-4">
                    @if($item->vip_only)
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">👑 VIP</span>
                    @else
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">🌐 Veřejné</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $item->created_at->format('d.m.Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.gallery.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-3">✏️</a>
                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Smazat fotografii?')" class="text-red-500 hover:text-red-700 text-sm">🗑</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-12 text-gray-400">Galerie je prázdná.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $items->links() }}</div>
@endsection
