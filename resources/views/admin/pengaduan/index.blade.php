<x-dashboard-layout role="admin" active="data" title="Data Pengaduan">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Pengaduan Siswa</h3>
                <p class="text-sm text-gray-400">Kelola dan berikan tanggapan untuk pengaduan yang masuk.</p>
            </div>

            <a href="{{ route('admin.pengaduan.cetakPdf') }}"
               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 border border-gray-100 rounded-xl overflow-hidden">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3">Tanggal</th>
                        <th scope="col" class="px-4 py-3">Nama Siswa</th>
                        <th scope="col" class="px-4 py-3">Kategori</th>
                        <th scope="col" class="px-4 py-3">Judul</th>
                        <th scope="col" class="px-4 py-3">Isi Laporan</th>
                        <th scope="col" class="px-4 py-3">Foto</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-center">Aksi / Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $item)
                        <tr class="bg-white border-b border-gray-50 hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $item->user->name ?? 'Siswa' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">
                                    {{ $item->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-800">{{ $item->judul }}</td>
                            <td class="px-4 py-3">{{ $item->isi_laporan }}</td>
                            <td class="px-4 py-3">
                                @if ($item->foto)
                                    <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat Foto</a>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->status === 'pending')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full">Pending</span>
                                @elseif ($item->status === 'approved')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-600 rounded-full">Approved</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-red-50 text-red-600 rounded-full">Rejected</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($item->status === 'pending')
                                    <form action="{{ route('admin.pengaduan.updateStatus', $item->id) }}" method="POST" class="space-y-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="w-full text-xs rounded-lg border-gray-200 text-gray-800">
                                            <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                        <input type="text" name="catatan_penyerahan" value="{{ $item->catatan_penyerahan }}"
                                               placeholder="Catatan/Tanggapan Admin"
                                               class="w-full text-xs rounded-lg border-gray-200 text-gray-800">
                                        <button type="submit" class="w-full py-1.5 px-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition">SIMPAN</button>
                                    </form>
                                @else
                                    <div class="text-xs text-gray-400">
                                        <span class="font-semibold text-gray-400 block mb-1">Status Permanen</span>
                                        Catatan: {{ $item->catatan_penyerahan ?? '-' }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-400">Belum ada pengaduan dari siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-dashboard-layout>