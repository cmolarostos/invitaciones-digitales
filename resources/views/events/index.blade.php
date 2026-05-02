@extends('layouts.app')

@section('title', 'Mis eventos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Mis eventos</h1>
    <a href="{{ route('events.create') }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded">
        + Nuevo evento
    </a>
</div>

@if ($events->isEmpty())
    <div class="text-center py-20 text-gray-400">
        <p class="text-lg">Aún no tienes eventos.</p>
        <a href="{{ route('events.create') }}" class="mt-3 inline-block text-indigo-600 hover:underline">
            Crea tu primer evento
        </a>
    </div>
@else
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($events as $event)
            <a href="{{ route('events.show', $event) }}"
               class="bg-white rounded-lg border border-gray-200 p-5 hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="font-semibold text-gray-900 truncate">{{ $event->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $event->event_date->translatedFormat('d M Y') }}
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        @if($event->status === 'draft') bg-gray-100 text-gray-600
                        @elseif($event->status === 'published') bg-green-100 text-green-700
                        @elseif($event->status === 'sent') bg-blue-100 text-blue-700
                        @else bg-purple-100 text-purple-700 @endif">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-3">
                    {{ $event->template->name ?? '—' }}
                </p>
            </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>
@endif
@endsection
