<x-dashboard-layout role="siswa" active="data" title="Data Pengaduan">

    @if (session('success'))
        <div class="p-4 text-sm text-green-700 rounded-xl bg-green-50 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 text-sm text-red-700 rounded-xl bg-red-50 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Riwayat Pengaduan Saya</h3>
            <a href="{{ route('siswa.pengaduan.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                + Ajukan Pengaduan
            </a>
        </div>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 rounded-l-lg">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Judul</th>
                        <th scope="col" class="px-6 py-3">Isi Pengaduan</th>
                        <th scope="col" class="px-6 py-3">Foto</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Catatan Admin</th>
                        <th scope="col" class="px-6 py-3 rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $item)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">{{ $item->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->judul }}</td>
                            <td class="px-6 py-4">{{ Str::limit($item->isi_laporan, 80) }}</td>
                            <td class="px-6 py-4">
                                @if ($item->foto)
                                    <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="text-indigo-600 underline">Lihat Foto</a>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status === 'pending')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full">Pending</span>
                                @elseif ($item->status === 'approved')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-600 rounded-full">Approved</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-red-50 text-red-600 rounded-full">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 italic text-gray-500">{{ $item->catatan_penyerahan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->status === 'pending')
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('siswa.pengaduan.edit', $item->id) }}"
                                           class="px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('siswa.pengaduan.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Terkunci</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-6 text-center text-gray-400">Belum ada pengaduan yang diajukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-dashboard-layout>