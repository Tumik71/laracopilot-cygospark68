@extends('layouts.admin')
@section('title', 'Předplatitelé')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">👥 VIP Předplatitelé</h1>
        <p class="text-gray-500 text-sm">Celkový měsíční příjem: <strong class="text-green-600">{{ number_format($totalRevenue, 0, ',', ' ') }} Kč</strong></p>
    </div>
</div>
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jméno</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">E-mail</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Telefon</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Předplatné od</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Akce</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($subscribers as $sub)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $sub->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $sub->email }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $sub->phone ?? '–' }}</td>
                <td class="px-6 py-4">
                    @if($sub->active)
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">✅ Aktivní</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">❌ Neaktivní</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-400">{{ $sub->subscribed_at ? $sub->subscribed_at->format('d.m.Y') : '–' }}</td>
                <td class="px-6 py-4 text-right">
                    @if($sub->active)
                    <form action="{{ route('admin.subscribers.destroy', $sub->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Zrušit předplatné tohoto uživatele?')" class="text-red-500 hover:text-red-700 text-sm">Zrušit předplatné</button>
                    </form>
                    @else
                        <span class="text-gray-300 text-sm">Zrušeno</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-12 text-gray-400">Zatím žádní předplatitelé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $subscribers->links() }}</div>
@endsection
