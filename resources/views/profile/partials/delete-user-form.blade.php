<section>
    <header>
        <h2 class="text-lg font-bold text-gray-900">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __('Setelah akun dihapus, semua data akan dihapus permanen. Silakan unduh data yang ingin disimpan sebelum menghapus akun.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl shadow-sm transition mt-4"
    >
        {{ __('Hapus Akun') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900">
                {{ __('Yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi untuk konfirmasi.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Kata Sandi') }}</label>
                <input id="password" name="password" type="password" placeholder="{{ __('Kata Sandi') }}"
                    class="block w-full rounded-xl border-gray-200 bg-white text-gray-800 focus:border-red-500 focus:ring-red-500 shadow-sm">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>