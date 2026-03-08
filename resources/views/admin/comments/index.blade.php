@extends('layouts.admin')
@section('title', 'Správa komentářů')
@section('content')

<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b flex flex-wrap gap-4 items-center justify-between">
        <h2 class="text-lg font-semibold">💬 Komentáře ({{ $comments->total() }})</h2>
        <form method="GET" class="flex gap-2">
            <select name="status" class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Všechny</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Čekající</option>
                <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Schválené</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Hledat..." class="border rounded-lg px-3 py-2 text-sm">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Filtrovat</button>
        </form>
    </div>

    <div class="divide-y">
        @forelse($comments as $comment)
        <div class="p-5 flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-600 flex-shrink-0">
                {{ substr($comment->user?->name ?? 'A', 0, 1) }}
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-medium text-sm">{{ $comment->user?->name ?? 'Anonym' }}</span>
                    <span class="text-xs text-gray-400">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                    <span class="text-xs px-2 py-0.5 rounded {{ $comment->approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $comment->approved ? '✅ Schválený' : '⏳ Čeká' }}
                    </span>
                </div>
                <p class="text-gray-700 text-sm mt-1">{{ $comment->content }}</p>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                @if(!$comment->approved)
                <form method="POST" action="{{ route('admin.comments.approve', $comment->id) }}">
                    @csrf
                    <button class="px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">Schválit</button>
                </form>
                @endif
                <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600" onclick="return confirm('Smazat komentář?')">Smazat</button>
                </form>
            </div>
        </div>
        @empty
        <div class="p-12 text-center text-gray-400">Žádné komentáře.</div>
        @endforelse
    </div>

    <div class="p-4">{{ $comments->withQueryString()->links() }}</div>
</div>

@endsection
