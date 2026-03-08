@extends('layouts.admin')
@section('title', 'Správa uživatelů')
@section('content')

<div class="bg-white rounded-xl shadow-sm">
    <!-- Hlavička -->
    <div class="p-6 border-b flex flex-wrap gap-4 items-center justify-between">
        <h2 class="text-lg font-semibold">👥 Uživatelé ({{ $users->total() }})</h2>
        <form method="GET" class="flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Hledat jméno nebo e-mail..."
                   class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="role" class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Všechny role</option>
                <option value="user" {{ request('role')=='user'?'selected':'' }}>Uživatel</option>
                <option value="vip" {{ request('role')=='vip'?'selected':'' }}>VIP</option>
                <option value="editor" {{ request('role')=='editor'?'selected':'' }}>Redaktor</option>
                <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            </select>
            <select name="status" class="border rounded-lg px-3 py-2 text-sm">
                <option value="">Všechny stavy</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Aktivní</option>
                <option value="banned" {{ request('status')=='banned'?'selected':'' }}>Zablokovaní</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">🔍 Hledat</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Uživatel</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Role</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">2FA</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Stav</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-500">Registrace</th>
                    <th class="px-6 py-3 text-right font-medium text-gray-500">Akce</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                        <div class="text-gray-400">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $user->role === 'vip' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $user->role === 'editor' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $user->role === 'user' ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->two_factor_enabled)
                            <span class="text-green-600 text-xs font-medium">✅ Aktivní</span>
                        @else
                            <span class="text-gray-400 text-xs">Neaktivní</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->banned_at)
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">🚫 Blokován</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">✅ Aktivní</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-400">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-green-600 hover:underline">Upravit</a>
                            @if($user->banned_at)
                                <form method="POST" action="{{ route('admin.users.unban', $user->id) }}" class="inline">
                                    @csrf
                                    <button class="text-yellow-600 hover:underline">Odblokovat</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.users.ban', $user->id) }}" class="inline">
                                    @csrf
                                    <button class="text-orange-600 hover:underline" onclick="return confirm('Blokovat uživatele?')">Blokovat</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline" onclick="return confirm('Opravdu smazat?')">Smazat</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-4">{{ $users->withQueryString()->links() }}</div>
</div>

@endsection
