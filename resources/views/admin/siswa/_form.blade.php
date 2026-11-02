@php
    $siswa = $siswa ?? null;

    $inputClass = 'block w-full rounded-xl border-gray-200 bg-white text-gray-800 text-base md:text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm';

    $usernameEmail = old('email_username', $siswa ? Str::before($siswa->email, '@') : '');
@endphp

<div>
    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
    <input id="name" name="name" type="text" value="{{ old('name', $siswa->name ?? '') }}" required
           placeholder="Contoh: Budi Santoso" class="{{ $inputClass }}">
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
        <input id="nis" name="nis" type="text" inputmode="numeric" value="{{ old('nis', $siswa->nis ?? '') }}" required
               placeholder="Contoh: 2425001" class="{{ $inputClass }}">
        <x-input-error :messages="$errors->get('nis')" class="mt-2" />
    </div>

    <div>
        <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
        <input id="kelas" name="kelas" type="text" value="{{ old('kelas', $siswa->kelas ?? '') }}" required
               placeholder="Contoh: XII RPL 1" class="{{ $inputClass }}">
        <x-input-error :messages="$errors->get('kelas')" class="mt-2" />
    </div>
</div>

<div>
    <label for="email_username" class="block text-sm font-medium text-gray-700 mb-1">Email Sekolah</label>
    <div class="flex rounded-xl shadow-sm">
        <input id="email_username" name="email_username" type="text" value="{{ $usernameEmail }}" required
               autocomplete="off" placeholder="budi.santoso"
               class="min-w-0 flex-1 rounded-l-xl rounded-r-none border-gray-200 bg-white text-gray-800 text-base md:text-sm focus:border-indigo-500 focus:ring-indigo-500">
        <span class="inline-flex items-center px-3 rounded-r-xl border border-l-0 border-gray-200 bg-gray-50 text-sm text-gray-500">@@smk.belajar.id</span>
    </div>
    <p class="mt-1 text-xs text-gray-400">Cukup isi bagian depan. Huruf, angka, titik, garis bawah, dan strip.</p>
    <x-input-error :messages="$errors->get('email_username')" class="mt-2" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<div>
    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $siswa ? 'Kata Sandi Baru' : 'Kata Sandi' }}
        @if ($siswa)<span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span>@endif
    </label>
    <input id="password" name="password" type="text" autocomplete="new-password"
           {{ $siswa ? '' : 'required' }} placeholder="Minimal 6 karakter"
           class="{{ $inputClass }}">
    <p class="mt-1 text-xs text-gray-400">Catat dan berikan kata sandi ini kepada siswa. Siswa tidak bisa mengubahnya sendiri.</p>
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>