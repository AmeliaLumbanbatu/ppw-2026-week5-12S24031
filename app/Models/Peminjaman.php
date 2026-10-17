<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    // Mendefinisikan kolom mana saja yang boleh diisi data (Mass Assignment)
    protected $fillable = [
        'kode_pinjam',
        'buku_id',
        'nim_peminjam',
        'nama_peminjam',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status',
    ];

    // Relasi: Satu peminjaman dimiliki oleh/terkait dengan satu buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}