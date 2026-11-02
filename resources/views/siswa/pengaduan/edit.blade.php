<x-dashboard-layout role="siswa" active="data" title="Edit Pengaduan">

    <div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <h3 class="text-lg font-bold text-gray-900">Edit Pengaduan</h3>
        <p class="text-sm text-gray-400 mt-1 mb-6">Perubahan hanya bisa dilakukan selama status masih Pending.</p>

        <form action="{{ route('siswa.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            @include('siswa.pengaduan._fields')

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                <a href="{{ route('siswa.pengaduan.index') }}" class="px-4 py-2.5 text-center text-sm font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</x-dashboard-layout>