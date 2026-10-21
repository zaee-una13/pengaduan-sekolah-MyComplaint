<x-dashboard-layout role="admin" active="data" title="Data Pengaduan">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Pengaduan Siswa</h3>
                <p class="text-sm text-gray-400">Kelola dan berikan tanggapan untuk pengaduan yang masuk.</p>
            </div>

            <a href="{{ route('admin.pengaduan.cetakPdf') }}"
               class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Cetak PDF
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">{{ session('error') }}</div>
        @endif

        @if ($pengaduans->isEmpty())
            <p class="py-8 text-center text-sm text-gray-400">Belum ada pengaduan dari siswa.</p>
        @else
            {{-- Tabel (layar lebar) --}}
            <div class="hidden xl:block overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Tanggal</th>
                            <th class="px-4 py-3">Nama Siswa</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Isi Laporan</th>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 rounded-r-lg min-w-[200px]">Aksi / Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $item)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 align-top">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $item->user->name ?? 'Siswa' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">{{ $item->category->name ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 font-semibold text-gray-800 break-words">{{ $item->judul }}</td>
                                <td class="px-4 py-3 max-w-xs break-words">{{ $item->isi_laporan }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->foto)
                                        <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat Foto</a>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3"><x-status-badge :status="$item->status" /></td>
                                <td class="px-4 py-3">@include('admin.pengaduan._verifikasi', ['item' => $item])</td>
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
                                <p class="text-sm text-gray-500">oleh {{ $item->user->name ?? 'Siswa' }}</p>
                            </div>
                            <x-status-badge :status="$item->status" class="shrink-0" />
                        </div>

                        <div class="flex flex-wrap items-center gap-3 text-xs">
                            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-full font-medium">{{ $item->category->name ?? '-' }}</span>
                            @if ($item->foto)
                                <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="text-indigo-600 underline">Lihat Foto</a>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 break-words">{{ $item->isi_laporan }}</p>

                        <div class="pt-3 border-t border-gray-100">
                            @include('admin.pengaduan._verifikasi', ['item' => $item])
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-dashboard-layout>