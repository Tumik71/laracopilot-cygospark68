@extends('layouts.admin')
@section('title', 'Blog')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">📝 Blog & Články</h1>
        <p class="text-gray-500 text-sm">Spravujte články a příspěvky na blogu</p>
    </div>
    <a href="{{ route('admin.blog.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">+ Nový článek</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nadpis</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kategorie</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Zobrazení</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Datum</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Akce</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($posts as $post)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800 text-sm line-clamp-1 max-w-xs">{{ $post->title }}</p>
                    @if($post->vip_only)
                        <span class="text-xs bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded">👑 VIP</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $post->category }}</td>
                <td class="px-6 py-4">
                    @if($post->published)
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Publikováno</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">📄 Koncept</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($post->views) }}</td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $post->created_at->format('d.m.Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.blog.edit', $post->id) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-3">✏️ Upravit</a>
                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Opravdu smazat tento článek?')" class="text-red-500 hover:text-red-700 text-sm">🗑 Smazat</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-12 text-gray-400">Zatím žádné články. <a href="{{ route('admin.blog.create') }}" class="text-yellow-600 hover:underline">Vytvořit první článek →</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $posts->links() }}</div>
@endsection
