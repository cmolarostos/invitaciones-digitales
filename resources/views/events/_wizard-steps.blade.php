@php
    $steps = [
        1 => 'Tipo de evento',
        2 => 'Plantilla',
        3 => 'Detalles',
    ];
@endphp

<div class="flex items-center gap-2 mt-2">
    @foreach ($steps as $n => $label)
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center w-7 h-7 rounded-full text-xs font-semibold transition
                @if($n < $current) bg-indigo-600 text-white
                @elseif($n === $current) bg-indigo-600 text-white ring-4 ring-indigo-100
                @else bg-gray-100 text-gray-400 @endif">
                @if($n < $current)
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                @else
                    {{ $n }}
                @endif
            </div>
            <span class="text-sm hidden sm:inline
                @if($n <= $current) text-gray-700 font-medium @else text-gray-400 @endif">
                {{ $label }}
            </span>
        </div>

        @if(!$loop->last)
            <div class="flex-1 h-px max-w-12
                @if($n < $current) bg-indigo-300 @else bg-gray-200 @endif">
            </div>
        @endif
    @endforeach
</div>
