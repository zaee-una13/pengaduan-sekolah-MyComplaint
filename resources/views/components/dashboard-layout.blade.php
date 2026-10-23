@props(['role' => 'siswa', 'active' => 'dashboard', 'title' => 'Dashboard'])

@php
    $icons = [
        'dashboard'  => '<rect x="3.5" y="12" width="4.5" height="8.5" rx="1"/><rect x="9.75" y="7" width="4.5" height="13.5" rx="1"/><rect x="16" y="3.5" width="4.5" height="17" rx="1"/>',
        'data'       => '<path d="M4 7a1.5 1.5 0 0 1 1.5-1.5h3.17a1.5 1.5 0 0 1 1.06.44l1 1a1.5 1.5 0 0 0 1.06.44h6.71A1.5 1.5 0 0 1 20 8.88V17a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 17V7Z"/>',
        'ajukan'     => '<circle cx="12" cy="12" r="8.25"/><path d="M12 8.5v7M8.5 12h7"/>',
        'pengaturan' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 13.5a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V19.5a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H4.5a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H10.5a1.65 1.65 0 0 0 1-1.51V4.5a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V10.5a1.65 1.65 0 0 0 1.51 1H19.5a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/>',
    ];

    $menu = $role === 'siswa'
        ? [
            ['dashboard', 'Dasbor', 'siswa.dashboard'],
            ['data', 'Data Pengaduan', 'siswa.pengaduan.index'],
            ['ajukan', 'Ajukan Pengaduan', 'siswa.pengaduan.create'],
        ]
        : [
            ['dashboard', 'Dasbor', 'admin.dashboard'],
            ['data', 'Data Pengaduan', 'admin.pengaduan.index'],
        ];
    $menu[] = ['pengaturan', 'Pengaturan', 'profile.edit'];
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - {{ $title }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <div x-data="{ sidebarOpen: false }"
         x-effect="document.body.classList.toggle('overflow-hidden', sidebarOpen)"
         @keydown.escape.window="sidebarOpen = false"
         class="min-h-screen lg:flex">

        <!-- Overlay (hanya HP/tablet) -->
        <div x-show="sidebarOpen" x-cloak x-transition.opacity
             @click="sidebarOpen = false"
             class="fixed inset-0 z-30 bg-gray-900/40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen && '!translate-x-0'"
               class="fixed inset-y-0 left-0 z-40 w-64 max-w-[85vw] -translate-x-full transition-transform duration-200
                      bg-white border-r border-gray-100 flex flex-col
                      lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen lg:shrink-0 lg:max-w-none">

            <div class="h-16 shrink-0 flex items-center justify-between px-6 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white text-xs font-bold flex items-center justify-center">My</span>
                    <span class="text-base font-bold text-gray-900">MyComplaint</span>
                </div>
                <button type="button" @click="sidebarOpen = false" class="lg:hidden p-1 -mr-2 text-gray-400 hover:text-gray-600" aria-label="Tutup menu">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
                @foreach ($menu as [$key, $label, $routeName])
                    <a href="{{ route($routeName) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ $active === $key ? 'bg-indigo-50 text-indigo-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$key] !!}</svg>
                        <span class="whitespace-nowrap">{{ $label }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="shrink-0 p-4 border-t border-gray-100">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 shrink-0 rounded-full bg-indigo-600 flex items-center justify-center text-xs font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0 text-sm leading-tight">
                        <p class="font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-center text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl py-2 transition">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Konten utama -->
        <div class="flex-1 min-w-0 flex flex-col">
            <header class="sticky top-0 z-20 h-16 bg-white border-b border-gray-100 flex items-center gap-3 px-4 sm:px-6 lg:px-8">
                <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-800" aria-label="Buka menu">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <h1 class="text-lg font-bold text-gray-900 truncate">{{ $title }}</h1>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>