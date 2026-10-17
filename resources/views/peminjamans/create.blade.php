<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman - SIPUS Del</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Peminjaman Buku</h4>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('peminjamans.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Buku</label>
                    <select name="buku_id" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($bukus as $buku)
                            <option value="{{ $buku->id }}">{{ $buku->judul }} (Stok: {{ $buku->stok }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIM Peminjam</label>
                    <input type="text" name="nim_peminjam" class="form-control" value="{{ old('nim_peminjam') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" class="form-control" value="{{ old('nama_peminjam') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('peminjamans.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>