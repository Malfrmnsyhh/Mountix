@props(['title', 'value', 'icon', 'color' => 'primary'])

@php
    $colorClasses = [
        'primary' => 'bg-primary/10 text-primary',
        'secondary' => 'bg-secondary/10 text-secondary',
        'success' => 'bg-success/10 text-success',
        'warning' => 'bg-warning/10 text-warning',
        'danger' => 'bg-danger/10 text-danger',
    ];
    
    $currentColor = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="bg-white p-6 rounded-3xl border border-neutral-light shadow-sm flex items-center gap-5">
    <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $currentColor }}">
        <i data-lucide="{{ $icon }}" class="w-7 h-7"></i>
    </div>
    <div>
        <p class="text-xs font-bold text-neutral-dark/40 uppercase tracking-wider mb-1">{{ $title }}</p>
        <h4 class="text-2xl font-black text-neutral-dark">{{ $value }}</h4>
    </div>
</div>
