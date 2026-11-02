@props(['user', 'size' => 'w-9 h-9 text-xs'])

@if ($user->foto_url)
    <img src="{{ $user->foto_url }}" alt="{{ $user->name }}" class="{{ $size }} rounded-full object-cover shrink-0">
@else
    <div class="{{ $size }} rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center shrink-0">
        {{ strtoupper(mb_substr($user->name, 0, 2)) }}
    </div>
@endif