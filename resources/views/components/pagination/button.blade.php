@props([
    'url' => null,
    'disabled' => false,
    'label' => '',
    'icon' => null,
    'rounded' => null
])

@php
    $classes = 'relative inline-flex items-center border border-gray-600 bg-gray-700 px-4 py-2 text-sm font-medium ';
    $classes .= $disabled ? 'cursor-default text-gray-400' : 'text-white hover:bg-gray-600';
    $classes .= $rounded ? ' ' . $rounded : '';
@endphp

@if ($disabled)
    <span {{ $attributes->merge(['class' => $classes, 'aria-disabled' => 'true', 'aria-label' => $label]) }}>
        @if ($icon)
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="{{ $icon }}" clip-rule="evenodd" />
            </svg>
        @else
            {{ $slot }}
        @endif
    </span>
@else
    <a href="{{ $url }}" {{ $attributes->merge(['class' => $classes, 'aria-label' => $label]) }}>
        @if ($icon)
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="{{ $icon }}" clip-rule="evenodd" />
            </svg>
        @else
            {{ $slot }}
        @endif
    </a>
@endif 