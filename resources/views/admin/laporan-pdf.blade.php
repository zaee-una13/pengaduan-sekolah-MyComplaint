<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan Sekolah</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAPITULASI LAPORAN PENGADUAN SEKOLAH</h2>
        <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kategori</th>
                <th>Judul Pengaduan</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Catatan Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td>{{ $p->user->name ?? 'Anonim' }}</td>
                <td>{{ $p->category->name ?? '-' }}</td>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->isi_laporan }}</td>
                <td><span class="badge">{{ $p->status }}</span></td>
                <td>{{ $p->catatan_penyerahan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>