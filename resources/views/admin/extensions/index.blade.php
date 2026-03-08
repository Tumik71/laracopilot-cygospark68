@extends('layouts.admin')
@section('title', 'Rozšíření')
@section('content')

<div class="space-y-4">
    <p class="text-gray-500 text-sm">Aktivujte nebo deaktivujte rozšíření pro váš portál.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($available as $key => $ext)
        @php $inst = $installed[$key] ?? null; $active = $inst && $inst->active; @endphp
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-start gap-4 {{ $active ? 'border-l-4 border-green-500' : '' }}">
            <div class="text-3xl">{{ $ext['icon'] }}</div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">{{ $ext['name'] }}</h3>
                    <span class="text-xs px-2 py-1 rounded-full {{ $active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $active ? '✅ Aktivní' : 'Neaktivní' }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 mt-1">{{ $ext['description'] }}</p>
                <p class="text-xs text-gray-400 mt-1">v{{ $ext['version'] }}</p>
                <div class="flex gap-2 mt-3">
                    @if($active)
                        <form method="POST" action="{{ route('admin.extensions.deactivate', $key) }}">
                            @csrf
                            <button class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">Deaktivovat</button>
                        </form>
                        @if(!empty($ext['settings']))
                        <a href="{{ route('admin.extensions.settings', $key) }}" class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-xs hover:bg-blue-200">⚙️ Nastavení</a>
                        @endif
                    @else
                        <form method="POST" action="{{ route('admin.extensions.activate', $key) }}">
                            @csrf
                            <button class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">Aktivovat</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
