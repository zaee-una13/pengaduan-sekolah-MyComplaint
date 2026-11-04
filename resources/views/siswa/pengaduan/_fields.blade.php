@php
    $pengaduan = $pengaduan ?? null;

    $inputClass = 'block w-full rounded-xl border-gray-200 bg-white text-gray-800 text-base md:text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm';

    $deskripsiKategori = [
        'Fasilitas'    => 'Kerusakan atau kekurangan sarana & prasarana sekolah.',
        'Kedisiplinan' => 'Pelanggaran tata tertib atau perilaku di lingkungan sekolah.',
    ];

    $urgensiOpsi = [
        'rendah' => ['Rendah', 'Tidak mengganggu kegiatan', 'peer-checked:border-sky-500 peer-checked:bg-sky-50 peer-checked:text-sky-700'],
        'sedang' => ['Sedang', 'Cukup mengganggu', 'peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700'],
        'tinggi' => ['Tinggi', 'Perlu segera ditangani', 'peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700'],
    ];

    $kategoriDipilih = old('category_id', $pengaduan->category_id ?? null);
    $urgensiDipilih  = old('urgensi', $pengaduan->urgensi ?? 'sedang');
    $tanggalDipilih  = old('tanggal_kejadian', $pengaduan?->tanggal_kejadian?->format('Y-m-d') ?? now()->toDateString());
@endphp

<!-- Kategori -->
<fieldset>
    <legend class="block text-sm font-medium text-gray-700 mb-2">Kategori Pengaduan</legend>
    <div class="grid gap-3 sm:grid-cols-2">
        @foreach ($categories as $category)
            <label class="cursor-pointer">
                <input type="radio" name="category_id" value="{{ $category->id }}" class="peer sr-only" required
                       {{ (string) $kategoriDipilih === (string) $category->id ? 'checked' : '' }}>
                <div class="h-full rounded-xl border-2 border-gray-200 p-4 transition hover:border-gray-300
                            peer-checked:border-indigo-500 peer-checked:bg-indigo-50
                            peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-300">
                    <p class="text-sm font-semibold text-gray-900">{{ $category->name }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $deskripsiKategori[$category->name] ?? '' }}</p>
                </div>
            </label>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</fieldset>

<!-- Judul -->
<div>
    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengaduan</label>
    <input id="judul" name="judul" type="text" value="{{ old('judul', $pengaduan->judul ?? '') }}" required
           placeholder="Contoh: AC Lab Komputer 2 rusak"
           class="{{ $inputClass }}">
    <x-input-error :messages="$errors->get('judul')" class="mt-2" />
</div>

<!-- Tingkat Urgensi -->
<fieldset>
    <legend class="block text-sm font-medium text-gray-700 mb-2">Tingkat Urgensi</legend>
    <div class="grid grid-cols-3 gap-2 sm:gap-3">
        @foreach ($urgensiOpsi as $nilai => [$label, $keterangan, $kelasAktif])
            <label class="cursor-pointer">
                <input type="radio" name="urgensi" value="{{ $nilai }}" class="peer sr-only" required
                       {{ $urgensiDipilih === $nilai ? 'checked' : '' }}>
                <div class="h-full rounded-xl border-2 border-gray-200 px-2 py-3 text-center text-gray-600 transition hover:border-gray-300
                            peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-300 {{ $kelasAktif }}">
                    <p class="text-sm font-semibold">{{ $label }}</p>
                    <p class="hidden sm:block text-xs opacity-80 mt-0.5">{{ $keterangan }}</p>
                </div>
            </label>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('urgensi')" class="mt-2" />
</fieldset>

<!-- Tanggal Kejadian & Lokasi -->
<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="tanggal_kejadian" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kejadian</label>
        <input id="tanggal_kejadian" name="tanggal_kejadian" type="date" value="{{ $tanggalDipilih }}"
               max="{{ now()->toDateString() }}" required
               class="{{ $inputClass }}">
        <x-input-error :messages="$errors->get('tanggal_kejadian')" class="mt-2" />
    </div>

    <div>
        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Detail Lokasi</label>
        <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi', $pengaduan->lokasi ?? '') }}" required
               placeholder="Contoh: Lab Komputer 2, Gedung B lt. 2"
               class="{{ $inputClass }}">
        <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
    </div>
</div>

<!-- Isi Laporan -->
<div>
    <label for="isi_laporan" class="block text-sm font-medium text-gray-700 mb-1">Isi Laporan / Detail Pengaduan</label>
    <textarea id="isi_laporan" name="isi_laporan" rows="5" required
              placeholder="Ceritakan apa yang terjadi, sejak kapan, dan dampaknya..."
              class="{{ $inputClass }}">{{ old('isi_laporan', $pengaduan->isi_laporan ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('isi_laporan')" class="mt-2" />
</div>

<!-- Foto -->
<div>
    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $pengaduan ? 'Ganti Foto' : 'Lampirkan Foto' }}
        <span class="text-red-500">*</span>
        <span class="text-gray-400 font-normal">(maks 2MB)</span>
    </label>

    @if ($pengaduan && $pengaduan->foto)
        <p class="text-sm text-gray-500 mb-2">
            Foto saat ini:
            <a href="{{ asset('storage/' . $pengaduan->foto) }}" target="_blank" class="text-indigo-600 underline">Lihat Foto</a>
            <span class="text-gray-400">(kosongkan jika tidak ingin mengganti)</span>
        </p>
    @endif

    <input id="foto" name="foto" type="file" accept="image/*"
           {{ ($pengaduan && $pengaduan->foto) ? '' : 'required' }}
           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
</div>