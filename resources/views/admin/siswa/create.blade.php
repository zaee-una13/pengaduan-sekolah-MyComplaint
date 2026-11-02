<x-dashboard-layout role="admin" active="siswa" title="Tambah Siswa">

    <div class="max-w-2xl bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
        <h3 class="text-lg font-bold text-gray-900">Buat Akun Siswa</h3>
        <p class="text-sm text-gray-400 mt-1 mb-6">Satu siswa satu akun. NIS dan email tidak boleh sama dengan akun lain.</p>

        <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-5">
            @csrf

            @include('admin.siswa._form')

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2.5 text-center text-sm font-semibold text-gray-500 hover:text-gray-700">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>

</x-dashboard-layout>