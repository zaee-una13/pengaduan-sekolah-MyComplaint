<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    private const DOMAIN = '@smk.belajar.id';

    // ======================================
    // DAFTAR AKUN SISWA (pemantauan)
    // ======================================
    public function index(Request $request)
    {
        $cari = trim((string) $request->query('cari', ''));

        $siswas = User::where('role', 'siswa')
            ->withCount([
                'pengaduans',
                'pengaduans as pending_count' => fn ($q) => $q->where('status', 'pending'),
            ])
            ->when($cari !== '', function ($q) use ($cari) {
                $q->where(function ($w) use ($cari) {
                    $w->where('name', 'like', "%{$cari}%")
                      ->orWhere('email', 'like', "%{$cari}%")
                      ->orWhere('nis', 'like', "%{$cari}%")
                      ->orWhere('kelas', 'like', "%{$cari}%");
                });
            })
            ->orderBy('kelas')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $total = User::where('role', 'siswa')->count();
        $pernahLogin = User::where('role', 'siswa')->whereNotNull('last_login_at')->count();

        $stats = [
            'total'        => $total,
            'pernah_login' => $pernahLogin,
            'belum_login'  => $total - $pernahLogin,
        ];

        return view('admin.siswa.index', compact('siswas', 'stats', 'cari'));
    }

    // ======================================
    // FORM TAMBAH SISWA
    // ======================================
    public function create()
    {
        return view('admin.siswa.create');
    }

    // ======================================
    // SIMPAN AKUN SISWA BARU
    // ======================================
    public function store(Request $request)
    {
        $request->merge(['email' => $this->susunEmail($request->input('email_username'))]);

        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'nis'            => ['required', 'regex:/^[0-9]+$/', 'max:20', 'unique:users,nis'],
            'kelas'          => ['required', 'string', 'max:50'],
            'email_username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'password'       => ['required', 'string', 'min:6', 'max:100'],
        ], [], $this->namaField());

        (new User)->forceFill([
            'name'              => $data['name'],
            'nis'               => $data['nis'],
            'kelas'             => $data['kelas'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'role'              => 'siswa',
            'email_verified_at' => now(),
        ])->save();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', "Akun {$data['email']} berhasil dibuat.");
    }

    // ======================================
    // FORM EDIT SISWA
    // ======================================
    public function edit(User $siswa)
    {
        $this->pastikanSiswa($siswa);

        return view('admin.siswa.edit', compact('siswa'));
    }

    // ======================================
    // UPDATE AKUN SISWA (nama, NIS, kelas, email, sandi)
    // ======================================
    public function update(Request $request, User $siswa)
    {
        $this->pastikanSiswa($siswa);

        $request->merge(['email' => $this->susunEmail($request->input('email_username'))]);

        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'nis'            => ['required', 'regex:/^[0-9]+$/', 'max:20', Rule::unique('users', 'nis')->ignore($siswa->id)],
            'kelas'          => ['required', 'string', 'max:50'],
            'email_username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/'],
            'email'          => ['required', 'email', Rule::unique('users', 'email')->ignore($siswa->id)],
            'password'       => ['nullable', 'string', 'min:6', 'max:100'],
        ], [], $this->namaField());

        $siswa->forceFill([
            'name'  => $data['name'],
            'nis'   => $data['nis'],
            'kelas' => $data['kelas'],
            'email' => $data['email'],
        ]);

        // Kata sandi hanya diganti jika diisi
        if (! empty($data['password'])) {
            $siswa->password = Hash::make($data['password']);
        }

        $siswa->save();

        return redirect()->route('admin.siswa.index')->with('success', 'Akun siswa berhasil diperbarui.');
    }

    // ======================================
    // HAPUS AKUN SISWA
    // ======================================
    public function destroy(User $siswa)
    {
        $this->pastikanSiswa($siswa);

        // Bersihkan file foto milik siswa ini (data pengaduannya ikut terhapus oleh FK cascade)
        foreach ($siswa->pengaduans as $pengaduan) {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
        }

        if ($siswa->foto_profil) {
            Storage::disk('public')->delete($siswa->foto_profil);
        }

        $nama = $siswa->name;
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', "Akun {$nama} berhasil dihapus.");
    }

    // ======================================
    // Helper
    // ======================================
    private function pastikanSiswa(User $user): void
    {
        abort_unless($user->role === 'siswa', 404);
    }

    private function susunEmail(?string $username): ?string
    {
        $username = strtolower(trim((string) $username));

        return $username === '' ? null : $username . self::DOMAIN;
    }

    private function namaField(): array
    {
        return [
            'name'           => 'nama',
            'nis'            => 'NIS',
            'kelas'          => 'kelas',
            'email_username' => 'email',
            'email'          => 'email',
            'password'       => 'kata sandi',
        ];
    }
}