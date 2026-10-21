<x-dashboard-layout role="siswa" active="data" title="Data Pengaduan">

    @if (session('success'))
        <div class="p-4 text-sm text-green-700 rounded-xl bg-green-50 border border-green-200">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="p-4 text-sm text-red-700 rounded-xl bg-red-50 border border-red-200">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <h3 class="text-lg font-bold text-gray-900">Riwayat Pengaduan Saya</h3>
            <a href="{{ route('siswa.pengaduan.create') }}"
               class="px-4 py-2 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                + Ajukan Pengaduan
            </a>
        </div>

        @if ($pengaduans->isEmpty())
            <p class="py-8 text-center text-sm text-gray-400">Belum ada pengaduan yang diajukan.</p>
        @else
            {{-- Tabel (layar lebar) --}}
            <div class="hidden xl:block overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Isi Pengaduan</th>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Catatan Admin</th>
                            <th class="px-4 py-3 rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $item)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 align-top">
                                <td class="px-4 py-4 whitespace-nowrap">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-4">{{ $item->category->name ?? '-' }}</td>
                                <td class="px-4 py-4 font-semibold text-gray-900 break-words">{{ $item->judul }}</td>
                                <td class="px-4 py-4 max-w-xs break-words">{{ Str::limit($item->isi_laporan, 80) }}</td>
                                <td class="px-4 py-4">
                                    @if ($item->foto)
                                        <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="text-indigo-600 underline">Lihat Foto</a>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4"><x-status-badge :status="$item->status" /></td>
                                <td class="px-4 py-4 italic text-gray-500 break-words">{{ $item->catatan_penyerahan ?? '-' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">@include('siswa.pengaduan._aksi', ['item' => $item])</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Kartu (HP & tablet) --}}
            <div class="xl:hidden grid gap-4 md:grid-cols-2">
                @foreach ($pengaduans as $item)
                    <div class="rounded-xl border border-gray-100 p-4 space-y-3">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y, H:i') }}</p>
                                <h4 class="font-semibold text-gray-900 break-words">{{ $item->judul }}</h4>
                            </div>
                            <x-status-badge :status="$item->status" class="shrink-0" />
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-xs">
                            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-full font-medium">{{ $item->category->name ?? '-' }}</span>
                            @if ($item->foto)
                                <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="text-indigo-600 underline">Lihat Foto</a>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 break-words">{{ Str::limit($item->isi_laporan, 140) }}</p>

                        @if ($item->catatan_penyerahan)
                            <p class="text-xs text-gray-500 bg-gray-50 rounded-lg p-3 break-words">
                                <span class="font-semibold">Catatan admin:</span>
                                <span class="italic">{{ $item->catatan_penyerahan }}</span>
                            </p>
                        @endif

                        <div class="pt-1">@include('siswa.pengaduan._aksi', ['item' => $item])</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-dashboard-layout>