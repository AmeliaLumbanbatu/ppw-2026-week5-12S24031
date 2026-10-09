# Tugas Mandiri Praktikum PPW Week 5 - Pembangunan Sistem Informasi Perpustakaan Kampus Del (SIPUS-Del)

Repositori ini berisi pengerjaan Tugas Mandiri Praktikum **Pemrograman dan Pengujian Aplikasi Web (PPW)** Minggu 05, Program Studi S1 Sistem Informasi - Institut Teknologi Del.

## 👤 Identitas Mahasiswa
- **Nama:** Amelia Renata Lumbanbatu
- **Program Studi:** S1 Sistem Informasi (2024)
- **Institusi:** Institut Teknologi Del
- **LinkedIn:** [Amelia Renata Lumbanbatu](https://www.linkedin.com/in/amelia-renata-lumbanbatu-867936364)

---

## 🛠️ Implementasi Spesifikasi Modul
1. **Skema Data & Migrations:** Membuat tabel `kategoris` dan `bukus` yang saling berelasi menggunakan *foreign key*, mengatur tipe data yang presisi, serta menyiapkan index database.
2. **Model Eloquent & Relasi:** Menerapkan relasi *One-to-Many* (`hasMany` dan `belongsTo`), mengatur proteksi *mass assignment* (`$fillable`), serta mengoptimalkan kueri dengan *Eager Loading* (`Buku::with('kategori')`) guna mencegah *N+1 query problem*.
3. **Routing RESTful & Resource Controller:** Mendaftarkan `Route::resource` yang mencakup 7 *method* CRUD lengkap secara konsisten dan menerapkan *Implicit Route Model Binding* pada controller.
4. **Validasi Form Server-Side & CSRF:** Menjalankan validasi form sisi server yang ketat (seperti ISBN unik, panjang judul minimal 5 karakter, stok tidak boleh minus) melalui `$request->validate()` dan memproteksi semua form dengan `@csrf` dan *method spoofing*.
5. **Blade Templating & Desain UI:** Mengimplementasikan *master layout* berbasis komponen `<x-layout>`, menyajikan daftar buku dengan *pagination*, menampilkan pesan sukses via *flash session*, serta menangani kondisi data kosong dengan direktif `@forelse`.
6. **Seeders & Factory:** Menyediakan file *seeder* yang diotomatisasi untuk memasukkan *mock data* realistis, yang terdiri dari 5 kategori perpustakaan dan 20 buku dummy untuk keperluan pengujian.

---

## 🌐 Akses Halaman Web (Routes)
Setelah server lokal dijalankan dengan perintah `php artisan serve`, aplikasi dapat langsung diuji melalui peramban (*browser*) pada rute berikut:

- **Halaman Daftar Kategori:** [http://127.0.0.1:8000/kategori](http://127.0.0.1:8000/kategori)
- **Halaman Daftar Buku:** [http://127.0.0.1:8000/buku](http://127.0.0.1:8000/buku)

> **Catatan:** Pastikan telah menjalankan `php artisan migrate:fresh --seed` sebelum mengakses halaman untuk melihat data uji (*dummy data*) yang sudah terhubung dengan *Eager Loading*.