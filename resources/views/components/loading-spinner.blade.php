@props(['size' => 'md', 'color' => 'emerald'])

@php
    $sizeClasses = [
        'sm' => 'w-4 h-4',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16',
    ];
    
    $colorClasses = [
        'emerald' => 'border-emerald-600',
        'blue' => 'border-blue-600',
        'purple' => 'border-purple-600',
        'white' => 'border-white',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $colorClass = $colorClasses[$color] ?? $colorClasses['emerald'];
@endphp

<div {{ $attributes->merge(['class' => 'inline-block']) }}>
    <div class="{{ $sizeClass }} border-4 {{ $colorClass }} border-t-transparent rounded-full animate-spin"></div>
</div>
