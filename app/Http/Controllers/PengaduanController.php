<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PengaduanController extends Controller
{
    // ======================================
    // DASBOR (Overview) - Siswa
    // ======================================
    public function dashboardSiswa()
    {
        $userId = Auth::id();

        $stats = [
            'total'    => Pengaduan::where('user_id', $userId)->count(),
            'pending'  => Pengaduan::where('user_id', $userId)->where('status', 'pending')->count(),
            'approved' => Pengaduan::where('user_id', $userId)->where('status', 'approved')->count(),
            'rejected' => Pengaduan::where('user_id', $userId)->where('status', 'rejected')->count(),
        ];

        $pengaduanTerbaru = Pengaduan::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Data dummy untuk grafik (nanti bisa diganti hitungan asli)
        $weeklyChart = [
            ['label' => 'M1', 'value' => 2],
            ['label' => 'M2', 'value' => 4],
            ['label' => 'M3', 'value' => 1],
            ['label' => 'M4', 'value' => 6],
            ['label' => 'M5', 'value' => 3],
        ];

        $categoryChart = [
            ['label' => 'Fasilitas', 'percent' => 45],
            ['label' => 'Akademik', 'percent' => 30],
            ['label' => 'Kedisiplinan', 'percent' => 25],
        ];

        return view('siswa.dashboard', compact('stats', 'pengaduanTerbaru', 'weeklyChart', 'categoryChart'));
    }

    // ======================================
    // DATA PENGADUAN (Riwayat) - Siswa
    // ======================================
    public function indexSiswa()
    {
        $pengaduans = Pengaduan::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.pengaduan.index', compact('pengaduans'));
    }

    // ======================================
    // FORM AJUKAN PENGADUAN - Siswa
    // ======================================
    public function createSiswa()
    {
        $categories = Category::orderBy('name')->get();

        return view('siswa.pengaduan.create', compact('categories'));
    }

    // =================================
    // Proses Siswa Mengajukan Pengaduan
    // =================================
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'judul'       => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'judul'       => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'foto'        => $fotoPath,
            'status'      => 'pending',
        ]);

        return redirect()->route('siswa.pengaduan.index')->with('success', 'Pengaduan berhasil diajukan.');
    }

    // ======================================
    // FORM EDIT PENGADUAN - Siswa
    // ======================================
    public function edit(Pengaduan $pengaduan)
    {
        if ($tolak = $this->izinkanUbah($pengaduan)) {
            return $tolak;
        }

        $categories = Category::orderBy('name')->get();

        return view('siswa.pengaduan.edit', compact('pengaduan', 'categories'));
    }

    // ======================================
    // PROSES UPDATE PENGADUAN - Siswa
    // ======================================
    public function update(Request $request, Pengaduan $pengaduan)
    {
        if ($tolak = $this->izinkanUbah($pengaduan)) {
            return $tolak;
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'judul'       => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'judul'       => $request->judul,
            'isi_laporan' => $request->isi_laporan,
        ];

        // Jika siswa upload foto baru, hapus foto lama lalu simpan yang baru
        if ($request->hasFile('foto')) {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
            $data['foto'] = $request->file('foto')->store('pengaduan', 'public');
        }

        $pengaduan->update($data);

        return redirect()->route('siswa.pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // ======================================
    // HAPUS PENGADUAN - Siswa
    // ======================================
    public function destroy(Pengaduan $pengaduan)
    {
        if ($tolak = $this->izinkanUbah($pengaduan)) {
            return $tolak;
        }

        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('siswa.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    // ======================================
    // Penjaga aturan: hanya pemilik + status pending
    // Mengembalikan redirect jika ditolak, null jika boleh
    // ======================================
    private function izinkanUbah(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses pengaduan ini.');
        }

        if ($pengaduan->status !== 'pending') {
            return redirect()
                ->route('siswa.pengaduan.index')
                ->with('error', 'Pengaduan yang sudah diproses admin tidak dapat diubah atau dihapus.');
        }

        return null;
    }

    // ======================================
    // DASBOR (Overview) - Admin
    // ======================================
    public function dashboardAdmin()
    {
        $stats = [
            'pending'        => Pengaduan::where('status', 'pending')->count(),
            'approved_bulan' => Pengaduan::where('status', 'approved')->whereMonth('updated_at', now()->month)->count(),
            'rejected_bulan' => Pengaduan::where('status', 'rejected')->whereMonth('updated_at', now()->month)->count(),
            'total'          => Pengaduan::count(),
        ];

        $pengaduanTerbaru = Pengaduan::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        // Data dummy untuk grafik (nanti bisa diganti hitungan asli)
        $weeklyChart = [
            ['label' => 'M1', 'value' => 8],
            ['label' => 'M2', 'value' => 12],
            ['label' => 'M3', 'value' => 6],
            ['label' => 'M4', 'value' => 21],
            ['label' => 'M5', 'value' => 10],
        ];

        $categoryChart = [
            ['label' => 'Fasilitas', 'percent' => 36],
            ['label' => 'Akademik', 'percent' => 27],
            ['label' => 'Kedisiplinan', 'percent' => 21],
            ['label' => 'Lainnya', 'percent' => 16],
        ];

        return view('admin.dashboard', compact('stats', 'pengaduanTerbaru', 'weeklyChart', 'categoryChart'));
    }

    // ======================================
    // DATA PENGADUAN (Semua) - Admin
    // ======================================
    public function indexAdmin()
    {
        $pengaduans = Pengaduan::with(['user', 'category'])
            ->latest()
            ->get();

        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    // ===========================================
    // Proses Admin Memverivikasi Status Pengaduan
    // ===========================================
    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->status !== 'pending') {
            return redirect()->back()->with('error', 'Status pengaduan ini sudah diproses dan tidak dapat diubah lagi!');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'catatan_penyerahan' => 'nullable|string',
        ]);

        $pengaduan->update([
            'status' => $request->status,
            'catatan_penyerahan' => $request->catatan_penyerahan,
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }

    public function cetakPdf()
    {
        $pengaduans = Pengaduan::with(['user', 'category'])->latest()->get();

        $pdf = Pdf::loadView('admin.laporan-pdf', compact('pengaduans'));

        return $pdf->download('laporan-pengaduan-sekolah.pdf');
    }
}