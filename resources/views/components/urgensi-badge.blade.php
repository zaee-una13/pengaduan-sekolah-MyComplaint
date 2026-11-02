@props(['urgensi'])

@php
    $map = [
        'rendah' => ['Rendah', 'bg-sky-50 text-sky-700', 'bg-sky-500'],
        'sedang' => ['Sedang', 'bg-orange-50 text-orange-700', 'bg-orange-500'],
        'tinggi' => ['Tinggi', 'bg-rose-50 text-rose-700', 'bg-rose-500'],
    ];
    [$label, $warna, $titik] = $map[$urgensi] ?? $map['sedang'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2 py-0.5 text-xs font-semibold rounded-md $warna"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $titik }}"></span>
    Urgensi {{ $label }}
</span>