<x-dashboard-layout role="siswa" active="dashboard" title="Dasbor">

    @if (session('success'))
        <div class="p-4 text-sm text-green-700 rounded-xl bg-green-50 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

        <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl shadow-sm border-2 border-gray-900 p-5">
            <p class="text-sm text-gray-400">Total Pengaduan</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border-2 border-amber-400 p-5">
            <p class="text-sm text-gray-400">Pending</p>
            <p class="text-3xl font-bold text-amber-500 mt-1">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border-2 border-emerald-500 p-5">
            <p class="text-sm text-gray-400">Approved</p>
            <p class="text-3xl font-bold text-emerald-500 mt-1">{{ $stats['approved'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border-2 border-red-500 p-5">
            <p class="text-sm text-gray-400">Rejected</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $stats['rejected'] }}</p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-6">Pengaduan Masuk per Minggu</h3>
            <div class="flex items-end gap-4 h-40">
                @php $maxVal = collect($weeklyChart)->max('value') ?: 1; @endphp
                @foreach ($weeklyChart as $bar)
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                        <div class="w-full max-w-10 mx-auto bg-indigo-500 rounded-t-lg transition-all" style="height: {{ ($bar['value'] / $maxVal) * 100 }}%"></div>
                        <span class="text-xs text-gray-400">{{ $bar['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-5">Berdasarkan Kategori</h3>
            <div class="space-y-4">
                @foreach ($categoryChart as $cat)
                    <div>
                        <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                            <span class="font-medium">{{ $cat['label'] }}</span>
                            <span class="font-semibold text-gray-700">{{ $cat['percent'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ $cat['percent'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Tabel Terbaru -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-bold text-gray-700">Pengaduan Terbaru</h3>
            <a href="{{ route('siswa.pengaduan.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase border-b border-gray-100">
                    <tr>
                        <th class="py-2">Judul</th>
                        <th class="py-2">Kategori</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduanTerbaru as $item)
                        <tr class="border-b border-gray-50">
                            <td class="py-3 font-semibold text-gray-800">{{ $item->judul }}</td>
                            <td class="py-3">{{ $item->category->name ?? '-' }}</td>
                            <td class="py-3">
                                @if ($item->status === 'pending')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full">Pending</span>
                                @elseif ($item->status === 'approved')
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-600 rounded-full">Approved</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold bg-red-50 text-red-600 rounded-full">Rejected</span>
                                @endif
                            </td>
                            <td class="py-3">{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-400">Belum ada pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-dashboard-layout>