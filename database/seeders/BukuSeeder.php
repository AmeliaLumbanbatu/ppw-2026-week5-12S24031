<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Peminjaman;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori disesuaikan dengan kolom kode_kategori dan nama_kategori
        $kategoriPemrograman = Kategori::firstOrCreate(
            ['kode_kategori' => 'KAT-001'],
            ['nama_kategori' => 'Pemrograman & Software Engineering']
        );

        $kategoriBasisData = Kategori::firstOrCreate(
            ['kode_kategori' => 'KAT-002'],
            ['nama_kategori' => 'Database & Sistem Basis Data']
        );

        // 2. Buku Stok = 0 (Syarat Uji Penolakan Peminjaman Modul 6)
        $bukuHabis = Buku::create([
            'kategori_id' => $kategoriPemrograman->id,
            'isbn' => '978-0131103627',
            'judul' => 'The C Programming Language (Stok Habis)',
            'penulis' => 'Brian W. Kernighan, Dennis M. Ritchie',
            'penerbit' => 'Prentice Hall',
            'tahun_terbit' => 1988,
            'stok' => 0,
            'sinopsis' => 'Buku sampel dengan stok 0 untuk pengujian batas transaksi.',
        ]);

        // 3. Buku Stok = 1 (Syarat Uji Concurrency Locking Modul 6)
        $bukuKritis = Buku::create([
            'kategori_id' => $kategoriBasisData->id,
            'isbn' => '978-0073523323',
            'judul' => 'Database System Concepts (Stok 1)',
            'penulis' => 'Abraham Silberschatz',
            'penerbit' => 'McGraw-Hill',
            'tahun_terbit' => 2019,
            'stok' => 1,
            'sinopsis' => 'Buku sampel dengan stok 1 untuk pengujian transaksi concurrency.',
        ]);

        // 4. Buku Stok Normal
        $bukuNormal = Buku::create([
            'kategori_id' => $kategoriPemrograman->id,
            'isbn' => '978-0132350884',
            'judul' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
            'penulis' => 'Robert C. Martin',
            'penerbit' => 'Prentice Hall',
            'tahun_terbit' => 2008,
            'stok' => 5,
            'sinopsis' => 'Panduan penulisan kode yang bersih dan profesional.',
        ]);

        // 5. Sampel Riwayat Transaksi Peminjaman
        Peminjaman::create([
            'kode_pinjam' => 'PJM-20261017-001',
            'buku_id' => $bukuNormal->id,
            'nim_peminjam' => '12S24001',
            'nama_peminjam' => 'Budi Santoso',
            'tanggal_pinjam' => now()->subDays(5),
            'tanggal_jatuh_tempo' => now()->addDays(2),
            'status' => 'dipinjam',
        ]);
    }
}