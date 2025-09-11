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
