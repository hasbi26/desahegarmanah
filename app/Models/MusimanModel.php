<?php

namespace App\Models;

use CodeIgniter\Model;

class MusimanModel extends Model
{
    protected $table = 'musiman';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'rt_id',
        'penduduk_id',
        'kategori',
        'periode',
        'keterangan',
        'nama_perguruan_tinggi',
        'nama_perusahaan',
        'alamat_tempat_jualan',
        'alasan_lainnya',
        'nama_pondokan',
        'alamat_pondokan',
        'no_telp',
        'alamat_asal',
        'nama_lengkap',
        'jenis_kelamin',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'status_perkawinan',
        'alasan_tinggal',
        'lainnya',
    ];
    protected $useTimestamps = true;
}
