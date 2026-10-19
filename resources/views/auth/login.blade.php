<x-guest-layout>
    <!-- Container Utama -->
    <div x-data="{ role: 'siswa' }" 
         class="relative w-full max-w-4xl min-h-[550px] md:h-[550px] bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row transition-all duration-500">

        <!-- ==================== TOGGLE SWITCH MOBILE ==================== -->
        <div class="md:hidden flex bg-gray-100 p-1.5 m-4 mb-0 rounded-xl">
            <button type="button" 
                    @click="role = 'siswa'"
                    :class="role === 'siswa' ? 'bg-white text-[#635BFF] shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all duration-200">
                Siswa
            </button>
            <button type="button" 
                    @click="role = 'admin'"
                    :class="role === 'admin' ? 'bg-white text-purple-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="flex-1 py-2 text-xs font-semibold rounded-lg transition-all duration-200">
                Admin
            </button>
        </div>

        <!-- ==================== FORM SISWA ==================== -->
        <div x-show="role === 'siswa' || window.innerWidth >= 768"
             class="w-full md:w-1/2 h-full p-6 md:p-12 flex flex-col justify-center transition-all duration-500">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="mb-6">
                <span class="inline-block px-3 py-1 bg-indigo-50 text-[#635BFF] text-xs font-semibold rounded-full mb-2">Login Siswa</span>
                <h2 class="text-2xl font-bold text-gray-900">Selamat datang</h2>
                <p class="text-xs text-gray-500 mt-1">Masuk ke akun Siswa MyComplaint Anda.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email_siswa" class="block text-xs font-semibold text-gray-700 mb-1">Email Sekolah</label>
                    <input id="email_siswa" type="email" name="email" :value="old('email')" required autofocus 
                           placeholder="siswa@smk.belajar.id" 
                           class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#635BFF] focus:border-[#635BFF] transition duration-150 shadow-sm" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <label for="password_siswa" class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <input id="password_siswa" type="password" name="password" required 
                           placeholder="siswasmkn5" 
                           class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#635BFF] focus:border-[#635BFF] transition duration-150 shadow-sm" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label for="remember_me_siswa" class="inline-flex items-center text-gray-600">
                        <input id="remember_me_siswa" type="checkbox" name="remember" class="rounded border-gray-300 text-[#635BFF] shadow-sm focus:ring-[#635BFF]">
                        <span class="ml-2">Tetap masuk</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-[#635BFF] font-medium hover:underline" href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-[#635BFF] hover:bg-[#5249e0] text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                        Masuk Siswa
                    </button>
                </div>
            </form>
        </div>

        <!-- ==================== FORM ADMIN ==================== -->
        <div x-show="role === 'admin' || window.innerWidth >= 768"
             x-cloak
             class="w-full md:w-1/2 h-full p-6 md:p-12 flex flex-col justify-center transition-all duration-500">
            <div class="mb-6">
                <span class="inline-block px-3 py-1 bg-purple-50 text-purple-700 text-xs font-semibold rounded-full mb-2">Login Administrator</span>
                <h2 class="text-2xl font-bold text-gray-900">Panel Admin</h2>
                <p class="text-xs text-gray-500 mt-1">Masuk untuk mengelola pengaduan sekolah.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email_admin" class="block text-xs font-semibold text-gray-700 mb-1">Email Administrator</label>
                    <input id="email_admin" type="email" name="email" required 
                           placeholder="admin@gmail.com" 
                           class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#635BFF] focus:border-[#635BFF] transition duration-150 shadow-sm" />
                </div>

                <div>
                    <label for="password_admin" class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi</label>
                    <input id="password_admin" type="password" name="password" required 
                           placeholder="admin123" 
                           class="w-full px-3.5 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#635BFF] focus:border-[#635BFF] transition duration-150 shadow-sm" />
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label for="remember_me_admin" class="inline-flex items-center text-gray-600">
                        <input id="remember_me_admin" type="checkbox" name="remember" class="rounded border-gray-300 text-[#635BFF] shadow-sm focus:ring-[#635BFF]">
                        <span class="ml-2">Tetap masuk</span>
                    </label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 px-4 bg-gray-900 hover:bg-black text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                        Masuk Admin
                    </button>
                </div>
            </form>
        </div>

        <!-- ==================== SLIDING PANEL DEKSTOP ==================== -->
        <div class="hidden md:flex absolute top-0 left-0 w-1/2 h-full bg-[#635BFF] text-white p-12 flex-col justify-between transition-transform duration-700 ease-in-out z-20"
             :class="role === 'admin' ? 'translate-x-0' : 'translate-x-full'">
            
            <!-- Header Brand -->
            <div class="flex items-center space-x-2">
                <span class="bg-white text-[#635BFF] font-bold text-xs px-2 py-1 rounded">My</span>
                <span class="font-extrabold text-xl tracking-tight">MyComplaint</span>
            </div>

            <!-- Konten saat Form SISWA Aktif (Panel di Kanan) -->
            <div x-show="role === 'siswa'" class="transition-opacity duration-300">
                <h1 class="text-3xl font-extrabold leading-tight mb-3">
                    Setiap laporan, terlihat dalam satu tempat.
                </h1>
                <p class="text-indigo-100 text-xs leading-relaxed mb-6">
                    Masuk untuk melihat pengaduan yang belum ditangani, yang tertunda, dan yang sudah diselesaikan tim hari ini.
                </p>
                <button type="button" @click="role = 'admin'" 
                        class="inline-flex items-center px-5 py-2.5 border-2 border-white text-white font-semibold text-xs rounded-lg hover:bg-white hover:text-[#635BFF] transition duration-200">
                    Sebagai Admin 
                </button>
            </div>

            <!-- Konten saat Form ADMIN Aktif (Panel di Kiri) -->
            <div x-show="role === 'admin'" x-cloak class="transition-opacity duration-300">
                <h1 class="text-3xl font-extrabold leading-tight mb-3">
                    Kelola Pengaduan Sekolah Lebih Cepat.
                </h1>
                <p class="text-indigo-100 text-xs leading-relaxed mb-6">
                    Akses dashboard verifikasi untuk meninjau, menyetujui, dan merespons laporan siswa.
                </p>
                <button type="button" @click="role = 'siswa'" 
                        class="inline-flex items-center px-5 py-2.5 border-2 border-white text-white font-semibold text-xs rounded-lg hover:bg-white hover:text-[#635BFF] transition duration-200">
                     Sebagai Siswa
                </button>
            </div>

            <div></div>
        </div>

    </div>
</x-guest-layout>