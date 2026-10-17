<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $totalTransaksi = DB::table('peminjamans')->count();
        $totalDipinjam = DB::table('peminjamans')->where('status', 'dipinjam')->count();
        $totalDikembalikan = DB::table('peminjamans')->where('status', 'dikembalikan')->count();

        $bukuTerpopuler = DB::table('peminjamans')
            ->join('bukus', 'peminjamans.buku_id', '=', 'bukus.id')
            ->select('bukus.judul', DB::raw('count(peminjamans.id) as total_pinjam'))
            ->groupBy('bukus.id', 'bukus.judul')
            ->orderByDesc('total_pinjam')
            ->limit(5)
            ->get();

        return view('laporan.index', compact(
            'totalTransaksi',
            'totalDipinjam',
            'totalDikembalikan',
            'bukuTerpopuler'
        ));
    }
}