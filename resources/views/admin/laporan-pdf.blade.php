<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengaduan Sekolah</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 16px; }
        .header h2 { margin: 0; font-size: 15px; }
        .header p { margin: 4px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 5px; text-align: left; vertical-align: top; }
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
                <th>Dilaporkan</th>
                <th>Kejadian</th>
                <th>Nama Siswa</th>
                <th>Kategori</th>
                <th>Urgensi</th>
                <th>Lokasi</th>
                <th>Judul</th>
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
                <td>{{ $p->tanggal_kejadian?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $p->user->name ?? 'Anonim' }}</td>
                <td>{{ $p->category->name ?? '-' }}</td>
                <td><span class="badge">{{ $p->urgensi }}</span></td>
                <td>{{ $p->lokasi ?? '-' }}</td>
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