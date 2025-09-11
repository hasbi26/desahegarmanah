<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukModel extends Model
{
    protected $table = 'penduduk';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_lengkap',
        'nik',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pendidikan',
        'status_perkawinan',
        'agama',
        'pekerjaan',
        'alamat',
        'kelahiran',
        'pendatang',
        'kematian',
        'pindah',
        'status_rumah',
        'luas_tanah',
        'luas_bangunan',
        'air',
        'listrik',
        'sampah',
        'limbah',
        'rt_id'
    ];
    protected $useTimestamps = true;
}
