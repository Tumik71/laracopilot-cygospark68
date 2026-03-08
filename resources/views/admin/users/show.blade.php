@extends('layouts.admin')
@section('title', 'Detail uživatele')
@section('content')

<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
                <div class="flex gap-2 mt-2">
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ $user->role }}</span>
                    @if($user->two_factor_enabled)<span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">2FA aktivní</span>@endif
                    @if($user->banned_at)<span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Blokován</span>@endif
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Upravit</a>
                @if($user->banned_at)
                    <form method="POST" action="{{ route('admin.users.unban', $user->id) }}">
                        @csrf
                        <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg text-sm">Odblokovat</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.users.ban', $user->id) }}">
                        @csrf
                        <button class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm">Blokovat</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6 text-center">
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-lg font-bold">{{ $subscriptions->count() }}</div>
                <div class="text-xs text-gray-500">Předplatných</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-lg font-bold">{{ $galleryItems->count() }}</div>
                <div class="text-xs text-gray-500">Fotografií</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-lg font-bold">{{ $comments->count() }}</div>
                <div class="text-xs text-gray-500">Komentářů</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-sm font-medium">{{ $user->last_login_at?->format('d.m.Y') ?? '–' }}</div>
                <div class="text-xs text-gray-500">Poslední přihlášení</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold mb-3">💳 Předplatná</h3>
        @forelse($subscriptions as $sub)
        <div class="flex justify-between items-center py-2 border-b last:border-0">
            <div>
                <span class="text-sm font-medium">{{ $sub->plan?->name ?? 'Neznámý plán' }}</span>
                <span class="text-xs text-gray-400 ml-2">{{ $sub->starts_at?->format('d.m.Y') }}</span>
            </div>
            <span class="px-2 py-1 rounded text-xs {{ $sub->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $sub->status }}</span>
        </div>
        @empty
        <p class="text-gray-400 text-sm">Žádná předplatná.</p>
        @endforelse
    </div>
</div>

@endsection
