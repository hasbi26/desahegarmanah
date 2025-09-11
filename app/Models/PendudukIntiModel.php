<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukIntiModel extends Model
{
    protected $table = 'penduduk_new';
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
        'alamat'
    ];
    protected $useTimestamps = true;
}
