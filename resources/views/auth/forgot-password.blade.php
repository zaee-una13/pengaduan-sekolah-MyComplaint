<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 sm:p-8 md:p-10 border border-gray-100">

        <!-- Header & Logo -->
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center space-x-2 mb-4">
                <span class="bg-[#635BFF] text-white font-bold text-xs px-2.5 py-1 rounded-md">My</span>
                <span class="font-extrabold text-xl tracking-tight text-gray-900">MyComplaint</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Lupa Kata Sandi?</h2>
            <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email Terdaftar</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       placeholder="nama@smk.belajar.id"
                       class="w-full px-3.5 py-2.5 text-base md:text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#635BFF] focus:border-[#635BFF] transition duration-150 shadow-sm" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-2.5 px-4 bg-[#635BFF] hover:bg-[#5249e0] text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150 flex items-center justify-center">
                    Kirim Tautan Reset Password
                </button>
            </div>

            <!-- Kembali ke Halaman Login -->
            <div class="text-center pt-2">
                <a href="{{ route('login') }}" class="inline-flex items-center text-xs font-semibold text-[#635BFF] hover:underline">
                    &larr; Kembali ke halaman login
                </a>
            </div>
        </form>

    </div>
</x-guest-layout>