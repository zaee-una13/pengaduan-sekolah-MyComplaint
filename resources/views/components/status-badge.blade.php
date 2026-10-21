@props(['status'])

@php
    $styles = [
        'pending'  => 'bg-amber-50 text-amber-600',
        'approved' => 'bg-emerald-50 text-emerald-600',
        'rejected' => 'bg-red-50 text-red-600',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-block px-2.5 py-1 text-xs font-semibold rounded-full ' . ($styles[$status] ?? 'bg-gray-100 text-gray-600')]) }}>
    {{ ucfirst($status) }}
</span>