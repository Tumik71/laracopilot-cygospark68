@extends('layouts.admin')
@section('title', 'Nastavení rozšíření')
@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-3xl">⚙️</span>
            <div>
                <h2 class="font-semibold text-gray-800">{{ $definition['name'] }}</h2>
                <p class="text-sm text-gray-500">{{ $definition['description'] }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.extensions.save', $key) }}">
            @csrf
            @foreach($definition['settings'] as $setting)
            @php $value = $extension ? $extension->getSetting($setting) : ''; @endphp
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $setting)) }}</label>
                <input type="text" name="{{ $setting }}" value="{{ $value }}"
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            @endforeach

            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Uložit</button>
                <a href="{{ route('admin.extensions.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Zpět</a>
            </div>
        </form>
    </div>
</div>

@endsection
