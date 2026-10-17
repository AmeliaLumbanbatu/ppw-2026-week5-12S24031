<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi - SIPUS Del</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="mb-4 btn-group">
    <a href="/buku" class="btn btn-outline-primary">Katalog Buku</a>
    <a href="/kategori" class="btn btn-outline-primary">Kategori</a>
    <a href="/peminjamans" class="btn btn-outline-primary">Peminjaman</a>
    <a href="/laporan" class="btn btn-primary fw-bold">Laporan</a>
</div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Laporan Rekapitulasi Sirkulasi</h2>
        <a href="{{ route('peminjamans.index') }}" class="btn btn-secondary">Kembali ke Peminjaman</a>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h5>Total Transaksi</h5>
                    <h3>{{ $totalTransaksi }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body">
                    <h5>Sedang Dipinjam</h5>
                    <h3>{{ $totalDipinjam }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5>Sudah Dikembalikan</h5>
                    <h3>{{ $totalDikembalikan }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekapitulasi Top Buku -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Top 5 Buku Sering Dipinjam</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered align-middle mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Total Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukuTerpopuler as $index => $buku)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td><span class="badge bg-info text-dark">{{ $buku->total_pinjam }} kali</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada data rekapitulasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>