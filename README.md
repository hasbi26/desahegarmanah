# Aplikasi Pengelolaan Data Penduduk – Desa Hegarmanah

Dokumentasi ini ditujukan agar klien dan pengguna non-teknis mudah memahami cara memasang dan menggunakan aplikasi.

## Ringkasan

Aplikasi ini membantu pengelolaan data kependudukan di Desa Hegarmanah, termasuk penduduk tetap, penduduk musiman, dan manajemen pengguna (admin/RT).

## Fitur Utama

- **Dashboard**: Ringkasan data cepat.
- **Kelola Penduduk Tetap**: Lihat, tambah, ubah, hapus data penduduk tetap.
- **Kelola Penduduk Musiman**: Pencatatan warga musiman (mahasiswa, pekerja, pedagang, dll.).
- **Manajemen Pengguna (Admin)**: Kelola akun admin dan pengelola RT.
- **Settings**: Pengaturan aplikasi dasar.

## Teknologi

- **Framework**: CodeIgniter 4 (PHP)
- **Database**: MySQL/MariaDB
- **Server**: Dapat dijalankan dengan Apache (XAMPP) atau CLI (php spark)

## Persyaratan Sistem

- **PHP**: 8.1 atau lebih baru
- Ekstensi PHP: intl, mbstring, json (default), mysqlnd, libcurl (jika pakai HTTP client)
- **Composer**: untuk mengunduh dependensi PHP
- **MySQL/MariaDB**: untuk basis data

## Instalasi Cepat (Windows/XAMPP)

1. **Clone/ekstrak proyek** ke folder XAMPP, contoh:
   - `c:\xampp\htdocs\desa-hegarmanah\desahegarmanah`
2. **Install dependensi**
   ```bash
   composer install
   ```
3. **Salin dan setel environment**

   - Salin file `env` menjadi `.env`
   - Buka `.env`, aktifkan dan isi bagian App & Database:

   ```ini
   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = nama_database_anda
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   ```

4. **Buat database** di MySQL sesuai nama di `.env` (misal `desa_hegarmanah`).
5. **Jalankan migrasi database**
   ```bash
   php spark migrate
   ```
6. **(Opsional) Seed data referensi**
   - Untuk data desa contoh:
   ```bash
   php spark db:seed DesaSeeder
   ```
7. **Buat akun admin pertama** (wajib, untuk login awal)
   - Karena halaman pengguna hanya bisa diakses setelah login admin, buat akun admin langsung di database (sementara). Sistem mendukung password plaintext dan akan otomatis meng-upgrade ke hash yang aman saat login pertama.
   - Jalankan SQL ini di database Anda:
   ```sql
   INSERT INTO user (username, email, password, role, rt_id, is_active)
   VALUES ('admin', 'admin@example.com', 'admin123', 1, NULL, 1);
   ```
   - Username: `admin`, Password: `admin123`
   - Setelah berhasil login pertama kali, password akan diubah otomatis menjadi format yang aman (hash) oleh sistem.

## Menjalankan Aplikasi

- **Cara 1 (disarankan untuk pengembangan)**: Jalankan server bawaan CI4

  ```bash
  php spark serve
  ```

  Akses di browser: `http://localhost:8080`

- **Cara 2 (Apache XAMPP)**: Atur DocumentRoot ke folder `public` proyek ini:
  - Contoh: `c:\xampp\htdocs\desa-hegarmanah\desahegarmanah\public`
  - Akses melalui: `http://localhost/desahegarmanah` (tergantung konfigurasi VirtualHost/Alias Anda)

## Akun & Peran

- **Admin (role = 1)**
  - Akses penuh, termasuk menu "Pengguna" untuk menambah/ubah/hapus akun.
- **Pengelola RT (role = 2)**
  - Akses terbatas untuk pengelolaan data sesuai RT yang ditetapkan.

Catatan: Sidebar menampilkan menu "Pengguna" hanya untuk Admin.

## Alur Penggunaan Singkat

1. Login sebagai Admin.
2. Tambahkan data RT (jika belum ada) dan/atau data penduduk.
3. Tambahkan akun Pengelola RT melalui menu Pengguna (tetapkan RT yang dikelola).
4. Gunakan menu "Penduduk" dan "Musiman" sesuai kebutuhan operasional.

## Struktur Data (ringkas)

Migrasi utama mencakup tabel-tabel:

- `penduduk_new` (data inti penduduk)
- `penduduk_mutasi` (kelahiran, pendatang, kematian, pindah)
- `penduduk_tinggal` (kaitan penduduk dengan RT dan info tempat tinggal)
- `rumah_tangga` (fasilitas rumah tangga)
- `musiman` (ditambah beberapa kolom detail)
- `desa`, `rts`, dan penyesuaian `user` (kolom `rt_id`)

Saat migrasi, data lama (jika ada) dipindahkan ke struktur baru secara otomatis.

## Upload/Cache/Log

- Folder `writable/` digunakan untuk cache, logs, sesi, dan unggahan. Folder ini tidak ikut ke Git.
- Pastikan folder `writable/` dapat ditulis oleh PHP (di Windows biasanya sudah cukup).

## Troubleshooting

- **Halaman tidak muncul / 404**: Pastikan server mengarah ke folder `public`.
- **Gagal koneksi database**: Periksa kredensial pada `.env` dan pastikan DB dibuat.
- **Migrasi gagal**: Pastikan versi PHP sesuai dan jalankan `php spark migrate` dari root proyek yang berisi file `spark`.
- **Tidak bisa login**: Pastikan Anda sudah membuat akun admin via SQL seperti contoh di atas.

## Keamanan

- Setelah instalasi, ubah password admin bawaan melalui menu Pengguna.
- Simpan file `.env` hanya di server, jangan dibagikan. File ini sudah diabaikan oleh Git.

## Lisensi

Mengacu pada lisensi yang tercantum pada file `LICENSE` di proyek ini (CodeIgniter 4 dan komponen terkait).

---

Jika membutuhkan bantuan instalasi atau pelatihan penggunaan aplikasi, silakan hubungi tim pengembang.

## API Documentation (Ringkas)

Di bawah ini ringkasan endpoint API yang tersedia untuk klien front-end. Semua endpoint diasumsikan berada di base URL: `http://{host}:{port}/api` (contoh: `http://127.0.0.1:8000/api`).

Catatan umum:
- Semua respons JSON. Struktur umum untuk listing: `{ "data": [ ... ], "pagination": { ... } }`.
- Untuk perubahan data (POST/PUT/DELETE) pastikan Anda memiliki mekanisme auth/CSRF jika diperlukan oleh server.

1) Enumerator

- GET `/api/enumerator`
   - Deskripsi: ambil daftar enumerator (paginated).
   - Query params: `page` (default 1), `perPage` (default 10), `search` (opsional).
   - Contoh curl:
      ```bash
      curl "http://127.0.0.1:8000/api/enumerator?page=1&perPage=10"
      ```
   - Contoh response:
      ```json
      {"data":[],"pagination":{"currentPage":1,"perPage":10,"total":0,"totalPages":0}}
      ```

- GET `/api/enumerator/{id}`
   - Deskripsi: ambil detail enumerator.
   - Contoh curl: `curl http://127.0.0.1:8000/api/enumerator/1`

- POST `/api/enumerator`
   - Deskripsi: buat enumerator baru.
   - Body form/json fields: `nama`, `alamat`, `hp_telepon`.
   - Contoh curl:
      ```bash
      curl -X POST -H "Content-Type: application/json" -d '{"nama":"Budi","alamat":"Jl A","hp_telepon":"0812"}' http://127.0.0.1:8000/api/enumerator
      ```

- POST `/api/enumerator/{id}/update`
   - Deskripsi: update enumerator (form/json body sama seperti create).

- DELETE `/api/enumerator/{id}`
   - Deskripsi: hapus enumerator.

2) Penduduk

- GET `/api/penduduk`
   - Deskripsi: ambil daftar penduduk (menggunakan `penduduk_new` dan join tabel terkait).
   - Query params: `page`, `perPage`, `q` (search)

- GET `/api/penduduk/{id}`
   - Deskripsi: ambil detail penduduk lengkap (inti + tinggal + mutasi + rumah tangga)

- POST `/api/penduduk`
   - Deskripsi: buat data penduduk (inti + mutasi + tinggal + rumah tangga) secara transaksi.
   - Fields penting minimal: `nama_lengkap`, `nik`, `rt_id`.

- PUT `/api/penduduk/{id}`
   - Deskripsi: update data inti penduduk (kirim JSON raw untuk field yang diupdate).

- DELETE `/api/penduduk/{id}`
   - Deskripsi: hapus data inti penduduk.

3) Musiman

- GET `/api/musiman`, GET `/api/musiman/{id}`, POST `/api/musiman`, POST `/api/musiman/{id}/update`, DELETE `/api/musiman/{id}`
   - Deskripsi: CRUD untuk data musiman. Body: semua field yang relevan (lihat migration `CreateMusiman`).

4) Users

- GET `/api/users` (support query, paging)
- GET `/api/users/{id}`
- POST `/api/users` (fields: `username`, `password`, `rt_id`, `role`, `email`)
- POST `/api/users/{id}/update` or PUT `/api/users/{id}`
- DELETE `/api/users/{id}`

Testing helper
- Saya menambahkan skrip PowerShell: `tools/test-api.ps1` yang menjalankan serangkaian panggilan ke endpoint `enumerator` dan `penduduk` (list, create, show, update, delete). Cara pakai:

   ```powershell
   cd C:\Users\VINY\desahegarmanah
   php -S 127.0.0.1:8000 -t public
   # di jendela lain
   .\tools\test-api.ps1
   ```

Notes & Troubleshooting
- Jika Anda mendapatkan HTTP 500, periksa `writable/logs/` untuk pesan error (sering disebabkan table DB yang belum ada atau kredensial DB salah).
- Jika tabel belum ada, jalankan `php spark migrate` atau import SQL dump `desa_hegarmanah.sql`.
- Untuk operasi POST/PUT/DELETE, jika aplikasi mengaktifkan CSRF atau memerlukan auth, Anda perlu mengirim header/token yang sesuai. Skrip PowerShell saat ini mengasumsikan tidak ada CSRF.

Jika Anda ingin saya menambahkan contoh response lengkap, contoh payload per endpoint, atau menambahkan seeder & contoh data setelah migration, katakan mana yang Anda mau — saya akan tambahkan di README dan membuat seeder bila perlu.
