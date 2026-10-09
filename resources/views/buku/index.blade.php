<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPUS-Del | Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Perpustakaan IT Del - Daftar Buku</h4>
                        <div>
                            <a href="{{ route('kategori.index') }}" class="btn btn-light btn-sm fw-bold me-2">Kelola Kategori</a>
                            <a href="{{ route('buku.create') }}" class="btn btn-light btn-sm fw-bold">+ Tambah Buku</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Tahun</th>
                                    <th>Stok</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bukus as $index => $buku)
                                    <tr>
                                        <td>{{ $bukus->firstItem() + $index }}</td>
                                        <td>{{ $buku->judul }}</td>
                                        <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                                        <td>{{ $buku->penulis }}</td>
                                        <td>{{ $buku->tahun_terbit }}</td>
                                        <td>{{ $buku->stok }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada data buku yang tersimpan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>