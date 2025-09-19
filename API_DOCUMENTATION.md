# Dokumentasi API JSON

Dokumen ini menjelaskan endpoint API JSON yang tersedia di aplikasi, termasuk parameter, contoh request/response, serta aturan akses.

## Ringkasan
- **Base URL (default lokal XAMPP)**: `http://localhost/desahegarmanah/public`
- **Format request**: JSON (`Content-Type: application/json`) atau `x-www-form-urlencoded` saat login
- **Autentikasi**: Wajib login; semua endpoint di bawah `/api` dilindungi filter `auth` (menggunakan cookie sesi)
- **Pembatasan Akses Role**: Untuk user dengan peran Ketua RT (`role=2`), data otomatis difilter berdasarkan `rt_id` sesi

## Autentikasi

### POST /auth/login
- Deskripsi: Login untuk memperoleh cookie sesi.
- Body (`x-www-form-urlencoded`):
  - `username`: string
  - `password`: string
- Respons (200): redirect atau JSON sesuai konfigurasi; yang penting cookie sesi tersimpan di klien (browser/Postman/curl via cookie jar)
- Contoh curl:
```bash
curl -i -c cookies.txt -X POST \
  -d "username=admin&password=secret" \
  "http://localhost/desahegarmanah/public/auth/login"
```

### GET /auth/logout
- Deskripsi: Logout dan menghapus sesi.
- Catatan: Setelah logout, akses `/api/*` akan ditolak (harap login kembali).

---

## Penduduk
Endpoint JSON untuk data penduduk. Akses dilindungi auth; untuk `role=2` dibatasi oleh `rt_id` sesi.

### GET /api/penduduk
- Query Params:
  - `q` (opsional): kata kunci pencarian pada `nama_lengkap`, `nik`, `no_kk`, `alamat`
  - `page` (opsional, default 1)
  - `perPage` (opsional, default 10)
- Respons (200):
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "nama_lengkap": "Andi",
      "nik": "12345678",
      "no_kk": "87654321",
      "alamat": "Jl. Contoh",
      "jenis_kelamin": "L",
      "rt_id": 1,
      "updated_at": "2025-01-01 10:00:00"
    }
  ],
  "pagination": {"page": 1, "perPage": 10, "total": 1, "totalPages": 1}
}
```
- Contoh curl:
```bash
curl -b cookies.txt \
  "http://localhost/desahegarmanah/public/api/penduduk?q=andi&page=1&perPage=10"
```

### GET /api/penduduk/{id}
- Respons (200): gabungan data inti, tinggal, mutasi, rumah
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "nama_lengkap": "Andi",
    "nik": "12345678",
    "no_kk": "87654321",
    "alamat": "Jl. Contoh",
    "jenis_kelamin": "L",
    "rt_id": 1,
    "status_rumah": "Milik Sendiri",
    "luas_tanah": 90,
    "luas_bangunan": 45,
    "air": "PDAM",
    "listrik": "PLN",
    "sampah": "Diangkut",
    "limbah": "Septictank",
    "kelahiran": 0,
    "pendatang": 1,
    "kematian": 0,
    "pindah": 0
  }
}
```
- Kesalahan:
  - 404 jika tidak ditemukan
  - 403 jika `role=2` mencoba akses data RT lain

### POST /api/penduduk
- Body (JSON):
```json
{
  "nama_lengkap": "Andi",
  "nik": "12345678",
  "no_kk": "87654321",
  "tempat_lahir": "Bandung",
  "tanggal_lahir": "1990-01-01",
  "jenis_kelamin": "L",
  "pendidikan": "SMA",
  "status_perkawinan": "Belum Kawin",
  "agama": "Islam",
  "pekerjaan": "Karyawan",
  "alamat": "Jl. Contoh",
  "rt_id": 1,
  "status_rumah": "Milik Sendiri",
  "luas_tanah": 90,
  "luas_bangunan": 45,
  "air": "PDAM",
  "listrik": "PLN",
  "sampah": "Diangkut",
  "limbah": "Septictank",
  "kelahiran": false,
  "pendatang": true,
  "kematian": false,
  "pindah": false
}
```
- Validasi wajib: `nama_lengkap`, `nik` (min 8, unik), `jenis_kelamin`, `rt_id`
- Catatan: Untuk `role=2`, `rt_id` dipaksa mengikuti `rt_id` sesi
- Respons (201):
```json
{"status":"success","message":"Data penduduk berhasil ditambahkan","id": 10}
```

### PUT /api/penduduk/{id}
- Body: bidang sama dengan POST; boleh parsial
- Validasi wajib: `nama_lengkap`, `nik` (unik selain diri sendiri), `jenis_kelamin`
- Pembatasan: `role=2` hanya dapat memperbarui data di RT sendiri; `rt_id` akan dipaksa ke RT sesi
- Respons (200):
```json
{"status":"success","message":"Data penduduk berhasil diperbarui"}
```

### DELETE /api/penduduk/{id}
- Pembatasan: `role=2` hanya dapat menghapus data di RT sendiri
- Respons (200):
```json
{"status":"success","message":"Data penduduk berhasil dihapus"}
```

---

## Musiman
Endpoint JSON untuk data musiman (kategori "Musiman"). Akses dilindungi auth; `role=2` dibatasi `rt_id` sesi.

### GET /api/musiman
- Query Params: `q`, `page`, `perPage`
- Pencarian pada: `periode`, `keterangan`
- Respons (200):
```json
{
  "status":"success",
  "data":[{"id":1,"rt_id":1,"periode":"2025-01","keterangan":"Kuliah"}],
  "pagination":{"page":1,"perPage":10,"total":1,"totalPages":1}
}
```

### GET /api/musiman/{id}
- Respons (200):
```json
{"status":"success","data":{"id":1,"rt_id":1,"periode":"2025-01","keterangan":"Kuliah"}}
```
- 404 jika tidak ditemukan, 403 jika akses RT lain oleh `role=2`

### POST /api/musiman
- Body (JSON):
```json
{
  "penduduk_id": 1,
  "periode": "2025-01",
  "keterangan": "Kuliah",
  "nama_perguruan_tinggi": "ITB",
  "nama_perusahaan": null,
  "alamat_tempat_jualan": null,
  "alasan_lainnya": null,
  "nama_pondokan": "Kost A",
  "alamat_pondokan": "Jl. B",
  "no_telp": "0812...",
  "alamat_asal": "Tasik",
  "rt_id": 1
}
```
- Validasi wajib: `rt_id` (integer), `periode`
- Catatan: Untuk `role=2`, `rt_id` dipaksa ke `rt_id` sesi; `kategori` otomatis di-set `Musiman`
- Respons (201):
```json
{"status":"success","message":"Data musiman berhasil ditambahkan","id":5}
```

### PUT /api/musiman/{id}
- Body: bidang sama, boleh parsial; untuk `role=2`, `rt_id` dipaksa ke RT sesi
- Respons (200):
```json
{"status":"success","message":"Data musiman berhasil diperbarui"}
```

### DELETE /api/musiman/{id}
- Respons (200):
```json
{"status":"success","message":"Data musiman berhasil dihapus"}
```

---

## Enumerator
Endpoint JSON untuk enumerator. Tidak ada pembatasan khusus per RT.

### GET /api/enumerator
- Query Params: `q`, `page`, `perPage` (pencarian pada: `nama`, `hp_telepon`, `alamat`)
- Respons (200):
```json
{
  "status":"success",
  "data":[{"id":1,"nama":"Budi","alamat":"Jl. X","hp_telepon":"0812..."}],
  "pagination":{"page":1,"perPage":10,"total":1,"totalPages":1}
}
```

### GET /api/enumerator/{id}
- Respons (200):
```json
{"status":"success","data":{"id":1,"nama":"Budi","alamat":"Jl. X","hp_telepon":"0812..."}}
```

### POST /api/enumerator
- Body (JSON):
```json
{"nama":"Budi","alamat":"Jl. X","hp_telepon":"0812..."}
```
- Validasi wajib: `nama`
- Respons (201):
```json
{"status":"success","message":"Enumerator berhasil ditambahkan","id":3}
```

### PUT /api/enumerator/{id}
- Body: sama dengan POST; `nama` wajib
- Respons (200):
```json
{"status":"success","message":"Data berhasil diperbarui"}
```

### DELETE /api/enumerator/{id}
- Respons (200):
```json
{"status":"success","message":"Data berhasil dihapus"}
```

### GET /api/enumerator/options
- Deskripsi: Endpoint utilitas untuk komponen Select2.
- Query Params: `q` (opsional, pencarian nama)
- Respons (200):
```json
[{"id":1,"text":"Budi"},{"id":2,"text":"Siti"}]
```

---

## Pola Respons Error
- 401/302: Belum login (filter `auth`) – login terlebih dahulu
- 403: Akses ditolak (terutama saat `role=2` ke data RT berbeda)
- 404: Data tidak ditemukan
- 422: Validasi gagal – field `message` berisi detail error
- 500: Kegagalan proses (mis. transaksi DB gagal)

Contoh 422:
```json
{
  "status": "error",
  "message": {
    "nik": "The nik field must be at least 8 characters in length.",
    "rt_id": "The rt_id field is required."
  }
}
```

---

## Tips Penggunaan
1. Selalu login terlebih dahulu, lalu simpan cookie sesi (Postman otomatis; curl gunakan `-c` dan `-b`).
2. Saat mengirim JSON, set header `Content-Type: application/json`.
3. Untuk skenario frontend beda origin (domain berbeda), aktifkan CORS di `app/Config/Cors.php` sesuai kebutuhan.