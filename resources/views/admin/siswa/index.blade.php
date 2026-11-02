<x-dashboard-layout role="admin" active="siswa" title="Kelola Siswa">

    @if (session('success'))
        <div class="p-4 text-sm text-green-700 rounded-xl bg-green-50 border border-green-200">{{ session('success') }}</div>
    @endif

    <!-- Ringkasan pemantauan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-900 p-5">
            <p class="text-sm text-gray-400">Total Akun Siswa</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border-2 border-emerald-500 p-5">
            <p class="text-sm text-gray-400">Sudah Pernah Login</p>
            <p class="text-3xl font-bold text-emerald-500 mt-1">{{ $stats['pernah_login'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border-2 border-amber-400 p-5">
            <p class="text-sm text-gray-400">Belum Pernah Login</p>
            <p class="text-3xl font-bold text-amber-500 mt-1">{{ $stats['belum_login'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Akun Siswa</h3>
                <p class="text-sm text-gray-400">Satu siswa satu akun. Akun hanya dibuat dan dikelola oleh admin.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex gap-2">
                    <input type="search" name="cari" value="{{ $cari }}" placeholder="Cari nama, NIS, kelas, email"
                           class="w-full sm:w-64 rounded-xl border-gray-200 text-base md:text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    <button type="submit" class="px-4 py-2 bg-gray-900 hover:bg-black text-white text-sm font-semibold rounded-xl transition">Cari</button>
                </form>
                <a href="{{ route('admin.siswa.create') }}"
                   class="px-4 py-2 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    + Tambah Siswa
                </a>
            </div>
        </div>

        @if ($siswas->isEmpty())
            <p class="py-8 text-center text-sm text-gray-400">
                {{ $cari !== '' ? 'Tidak ada siswa yang cocok dengan pencarian.' : 'Belum ada akun siswa.' }}
            </p>
        @else
            {{-- Tabel (layar lebar) --}}
            <div class="hidden xl:block overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Siswa</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Pengaduan</th>
                            <th class="px-4 py-3">Login Terakhir</th>
                            <th class="px-4 py-3 rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswas as $s)
                            <tr class="border-b border-gray-50 hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <x-avatar :user="$s" size="w-9 h-9 text-xs" />
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate">{{ $s->name }}</p>
                                            <p class="text-xs text-gray-400">NIS {{ $s->nis ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $s->kelas ?? '-' }}</td>
                                <td class="px-4 py-3 break-all">{{ $s->email }}</td>
                                <td class="px-4 py-3">
                                    {{ $s->pengaduans_count }} laporan
                                    @if ($s->pending_count > 0)
                                        <span class="ml-1 px-2 py-0.5 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full">{{ $s->pending_count }} pending</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $s->last_login_at?->format('d M Y, H:i') ?? 'Belum pernah' }}
                                </td>
                                <td class="px-4 py-3">@include('admin.siswa._aksi', ['s' => $s])</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Kartu (HP & tablet) --}}
            <div class="xl:hidden grid gap-4 md:grid-cols-2">
                @foreach ($siswas as $s)
                    <div class="rounded-xl border border-gray-100 p-4 space-y-3">
                        <div class="flex items-center gap-3">
                            <x-avatar :user="$s" size="w-10 h-10 text-sm" />
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $s->name }}</p>
                                <p class="text-xs text-gray-400">NIS {{ $s->nis ?? '-' }} · {{ $s->kelas ?? '-' }}</p>
                            </div>
                        </div>

                        <p class="text-sm text-gray-500 break-all">{{ $s->email }}</p>

                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                            <span>{{ $s->pengaduans_count }} laporan</span>
                            @if ($s->pending_count > 0)
                                <span class="px-2 py-0.5 font-semibold bg-amber-50 text-amber-600 rounded-full">{{ $s->pending_count }} pending</span>
                            @endif
                        </div>

                        <p class="text-xs text-gray-400">
                            Login terakhir: {{ $s->last_login_at?->format('d M Y, H:i') ?? 'Belum pernah' }}
                        </p>

                        <div class="pt-3 border-t border-gray-100">@include('admin.siswa._aksi', ['s' => $s])</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $siswas->links() }}</div>
        @endif
    </div>

</x-dashboard-layout>