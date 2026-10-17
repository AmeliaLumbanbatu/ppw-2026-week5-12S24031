<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::all();

        // 1. Query Buku dengan withCount, filter dinamis when(), dan paginasi dengan filter tersimpan
        $bukus = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('penulis', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($request->kategori_id, function ($query, $kategoriId) {
                return $query->where('kategori_id', $kategoriId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // 2. Statistik Perpustakaan menggunakan Fluent Query Builder (DB::table)
        $stats = [
            'total_judul'        => DB::table('bukus')->count(),
            'total_stok'         => DB::table('bukus')->sum('stok'),
            'total_dipinjam'     => DB::table('peminjamans')->where('status', 'dipinjam')->count(),
            'total_dikembalikan' => DB::table('peminjamans')->where('status', 'dikembalikan')->count(),
        ];

        return view('buku.index', compact('bukus', 'kategoris', 'stats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'isbn'        => 'required|string|unique:bukus,isbn|max:255',
            'judul'       => 'required|string|min:5|max:255',
            'penulis'     => 'required|string|max:255',
            'penerbit'    => 'required|string|max:255',
            'tahun_terbit'=> 'required|integer|min:1900|max:' . date('Y'),
            'stok'        => 'required|integer|min:0',
            'sinopsis'    => 'nullable|string',
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'isbn'        => 'required|string|max:255|unique:bukus,isbn,' . $buku->id,
            'judul'       => 'required|string|min:5|max:255',
            'penulis'     => 'required|string|max:255',
            'penerbit'    => 'required|string|max:255',
            'tahun_terbit'=> 'required|integer|min:1900|max:' . date('Y'),
            'stok'        => 'required|integer|min:0',
            'sinopsis'    => 'nullable|string',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
    }
}