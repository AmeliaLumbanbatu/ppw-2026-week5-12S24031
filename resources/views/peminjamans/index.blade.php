<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman Buku - SIPUS Del</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Menu Navigasi -->
    <div class="mb-4 btn-group">
        <a href="/buku" class="btn btn-outline-primary">Katalog Buku</a>
        <a href="/kategori" class="btn btn-outline-primary">Kategori</a>
        <a href="/peminjamans" class="btn btn-primary fw-bold">Peminjaman</a>
        <a href="/laporan" class="btn btn-outline-primary">Laporan</a>
    </div>

    <!-- Judul & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Riwayat Peminjaman Buku</h2>
        <a href="{{ route('peminjamans.create') }}" class="btn btn-primary">+ Tambah Peminjaman</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Buku</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                        <tr>
                            <td><strong>{{ $p->kode_pinjam }}</strong></td>
                            <td>{{ $p->buku->judul ?? '-' }}</td>
                            <td>{{ $p->nama_peminjam }} <br><small class="text-muted">({{ $p->nim_peminjam }})</small></td>
                            <td>{{ $p->tanggal_pinjam }}</td>
                            <td>{{ $p->tanggal_jatuh_tempo }}</td>
                            <td>
                                @if($p->status === 'dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status === 'dipinjam')
                                    <form action="{{ route('peminjamans.kembalikan', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Kembalikan</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3 text-muted">Belum ada transaksi peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $peminjamans->links() }}
        </div>
    </div>
</div>
</body>
</html>