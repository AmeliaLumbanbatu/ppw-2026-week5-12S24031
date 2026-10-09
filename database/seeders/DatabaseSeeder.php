<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Buku;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat 5 Kategori manual yang realistis untuk perpustakaan
        $kategoris = [
            ['kode_kategori' => 'KAT-001', 'nama_kategori' => 'Pemrograman & Software Engineering'],
            ['kode_kategori' => 'KAT-002', 'nama_kategori' => 'Database & Sistem Basis Data'],
            ['kode_kategori' => 'KAT-003', 'nama_kategori' => 'UI/UX Design & Riset'],
            ['kode_kategori' => 'KAT-004', 'nama_kategori' => 'Kecerdasan Buatan & AI'],
            ['kode_kategori' => 'KAT-005', 'nama_kategori' => 'Jaringan & Keamanan Siber'],
        ];

        foreach ($kategoris as $kat) {
            $kategoriBaru = Kategori::create($kat);

            // 2. Setiap kategori otomatis dibuatkan 4 buku (total 20 buku)
            for ($i = 1; $i <= 4; $i++) {
                Buku::create([
                    'kategori_id' => $kategoriBaru->id,
                    'isbn' => '978-' . rand(1000, 9999) . '-' . rand(100, 999) . '-' . rand(0, 9),
                    'judul' => 'Panduan ' . $kat['nama_kategori'] . ' Vol. ' . $i,
                    'penulis' => 'Tim Akademik IT Del ' . $i,
                    'penerbit' => 'Del Press',
                    'tahun_terbit' => rand(2022, 2026),
                    'stok' => rand(5, 25),
                    'sinopsis' => 'Buku pegangan resmi untuk mempelajari dasar hingga mahir mengenai ' . $kat['nama_kategori'] . '.',
                ]);
            }
        }
    }
}