<x-dashboard-layout role="siswa" active="ajukan" title="Ajukan Pengaduan">

    <div class="grid gap-6 lg:grid-cols-3 items-start">

        <!-- Form -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
            <h3 class="text-lg font-bold text-gray-900">Ajukan Pengaduan Baru</h3>
            <p class="text-sm text-gray-400 mt-1 mb-6">Lengkapi data berikut agar pengaduanmu mudah ditindaklanjuti.</p>

            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                @include('siswa.pengaduan._fields')

                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                    <a href="{{ route('siswa.pengaduan.index') }}" class="px-4 py-2.5 text-center text-sm font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                        Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>

        <!-- Panel samping -->
        <aside class="space-y-4 lg:sticky lg:top-24">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h4 class="text-sm font-bold text-gray-900 mb-3">Tips agar cepat ditindaklanjuti</h4>
                <ul class="space-y-2.5 text-sm text-gray-500">
                    <li class="flex gap-2"><span class="text-indigo-500">•</span><span>Tulis judul singkat dan jelas.</span></li>
                    <li class="flex gap-2"><span class="text-indigo-500">•</span><span>Sebutkan lokasi sespesifik mungkin: gedung, lantai, dan ruangan.</span></li>
                    <li class="flex gap-2"><span class="text-indigo-500">•</span><span>Pilih urgensi sesuai kondisi. Gunakan "Tinggi" hanya untuk yang perlu segera ditangani.</span></li>
                    <li class="flex gap-2"><span class="text-indigo-500">•</span><span>Lampirkan foto bukti jika ada.</span></li>
                </ul>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h4 class="text-sm font-bold text-gray-900 mb-3">Setelah dikirim</h4>
                <ol class="space-y-2.5 text-sm text-gray-500">
                    <li><span class="font-semibold text-amber-600">Pending</span>: menunggu diperiksa admin. Kamu masih bisa mengedit atau menghapusnya.</li>
                    <li><span class="font-semibold text-emerald-600">Approved</span> atau <span class="font-semibold text-red-600">Rejected</span>: sudah diproses, disertai catatan admin. Tidak bisa diubah lagi.</li>
                </ol>
            </div>
        </aside>

    </div>

</x-dashboard-layout>