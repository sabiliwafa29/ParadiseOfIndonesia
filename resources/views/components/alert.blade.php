@props(['type' => 'info'])

@php
    $colors = [
        'success' => 'bg-emerald-50 border-emerald-500 text-emerald-800',
        'error' => 'bg-red-50 border-red-500 text-red-800',
        'info' => 'bg-blue-50 border-blue-500 text-blue-800',
    ];
    $classes = $colors[$type] ?? $colors['info'];
@endphp

<div {{ $attributes->merge(['class' => "mb-6 border-l-4 rounded-r-lg p-4 shadow-sm $classes"]) }}>
    {{ $slot }}
</div>
