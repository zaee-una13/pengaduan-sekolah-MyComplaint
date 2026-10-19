<x-dashboard-layout role="siswa" active="ajukan" title="Ajukan Pengaduan">

    <div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-5">Ajukan Pengaduan Baru</h3>

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori Pengaduan</label>
                <select id="category_id" name="category_id" required
                    class="block w-full rounded-xl border-gray-200 bg-white text-gray-800 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengaduan / Keluhan</label>
                <input id="judul" name="judul" type="text"
                    class="block w-full rounded-xl border-gray-200 bg-white text-gray-800 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="Contoh: Fasilitas AC Kelas R.10 Rusak" required>
                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
            </div>

            <div>
                <label for="isi_laporan" class="block text-sm font-medium text-gray-700 mb-1">Isi Laporan / Detail Pengaduan</label>
                <textarea id="isi_laporan" name="isi_laporan" rows="4"
                    class="block w-full rounded-xl border-gray-200 bg-white text-gray-800 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="Jelaskan detail pengaduan secara rinci..." required></textarea>
                <x-input-error :messages="$errors->get('isi_laporan')" class="mt-2" />
            </div>

            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Lampirkan Foto (Opsional, Maks 2MB)</label>
                <input id="foto" name="foto" type="file" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <x-input-error :messages="$errors->get('foto')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('siswa.pengaduan.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Kirim Pengaduan
                </button>
            </div>
        </form>
    </div>

</x-dashboard-layout>