@php
    $inputClass = 'block w-full rounded-xl border-gray-200 bg-white text-gray-800 text-base md:text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm';
@endphp

<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-400">
            @if ($user->role === 'admin')
                Perbarui nama, email, dan foto profil akun Anda.
            @else
                Anda dapat mengubah nama dan foto profil.
            @endif
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Foto Profil -->
        <div class="flex items-start gap-4">
            <x-avatar :user="$user" size="w-16 h-16 text-lg" />
            <div class="min-w-0 flex-1">
                <label for="foto_profil" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil <span class="text-gray-400 font-normal">(maks 2MB)</span></label>
                <input id="foto_profil" name="foto_profil" type="file" accept="image/*"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />

                @if ($user->foto_profil)
                    <label class="inline-flex items-center gap-2 mt-3 text-xs text-gray-500">
                        <input type="checkbox" name="hapus_foto" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Hapus foto profil
                    </label>
                @endif
            </div>
        </div>

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                   class="{{ $inputClass }}">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        @if ($user->role === 'admin')
            <!-- Email (admin) -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                       class="{{ $inputClass }}">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        @else
            <!-- Data akun siswa: hanya-baca -->
            <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 space-y-3">
                <div class="grid gap-3 sm:grid-cols-2 text-sm">
                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="font-medium text-gray-800 break-all">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">NIS</p>
                        <p class="font-medium text-gray-800">{{ $user->nis ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Kelas</p>
                        <p class="font-medium text-gray-800">{{ $user->kelas ?? '-' }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400">
                    Email, kata sandi, dan penghapusan akun hanya dapat diubah oleh admin sekolah.
                </p>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>