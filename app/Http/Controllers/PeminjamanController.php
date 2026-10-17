<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\QueryException;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('buku')
            ->latest()
            ->paginate(10);

        return view('peminjamans.index', compact('peminjamans'));
    }

    public function create()
    {
       $bukus = Buku::all(); // Tampilkan semua buku termasuk yang stoknya 0
    return view('peminjamans.create', compact('bukus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'nim_peminjam' => 'required|string',
            'nama_peminjam' => 'required|string',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // 1. Pessimistic Locking
                $buku = Buku::where('id', $validated['buku_id'])->lockForUpdate()->firstOrFail();

                // 2. Cek Stok > 0
                if ($buku->stok < 1) {
                    throw new \RuntimeException("Stok buku '{$buku->judul}' sedang kosong!");
                }

                // 3. Cegah NIM yang sama meminjam buku yang sama yang belum dikembalikan
                $sudahPinjam = Peminjaman::where('buku_id', $validated['buku_id'])
                    ->where('nim_peminjam', $validated['nim_peminjam'])
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($sudahPinjam) {
                    throw new \RuntimeException("NIM {$validated['nim_peminjam']} masih meminjam buku ini dan belum mengembalikannya.");
                }

                // 4. Kurangi stok
                $buku->decrement('stok');

                // 5. Simpan data transaksi peminjaman
                $kodePinjam = 'PJM-' . date('Ymd') . '-' . rand(100, 999);
                Peminjaman::create([
                    'kode_pinjam' => $kodePinjam,
                    'buku_id' => $validated['buku_id'],
                    'nim_peminjam' => $validated['nim_peminjam'],
                    'nama_peminjam' => $validated['nama_peminjam'],
                    'tanggal_pinjam' => $validated['tanggal_pinjam'],
                    'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                    'status' => 'dipinjam',
                ]);
            });

            // Menyimpan State Sesi & Cookie HTTP sesuai Syarat Poin 4
            session(['last_peminjam_nim' => $validated['nim_peminjam']]);
            Cookie::queue('last_peminjaman_activity', now()->toDateTimeString(), 60);

            return redirect()->route('peminjamans.index')->with('success', 'Transaksi peminjaman berhasil disimpan!');
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION PEMINJAMAN]: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memproses peminjaman akibat eror basis data.');
        }
    }

    public function kembalikan($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // Pessimistic Locking saat pengembalian
                $peminjaman = Peminjaman::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($peminjaman->status === 'dikembalikan') {
                    throw new \RuntimeException('Buku ini sudah dikembalikan sebelumnya.');
                }

                // Ubah status, isi tanggal_kembali
                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => now(),
                ]);

                // Tambah stok buku kembali
                $peminjaman->buku()->increment('stok');
            });

            return redirect()->route('peminjamans.index')->with('success', 'Buku berhasil dikembalikan!');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (QueryException $e) {
            Log::error('[DB EXCEPTION PENGEMBALIAN]: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pengembalian akibat eror basis data.');
        }
    }
}