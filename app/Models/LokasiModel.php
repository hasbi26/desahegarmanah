<?php
namespace App\Models;

use CodeIgniter\Model;

class LokasiModel extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'provinsi', 'kabupaten_kota', 'kecamatan', 'desa', 'desa_id', 'rt_rw',
        'nama_responden', 'alamat_responden', 'nomor_hp', 'nomor_telepon_rumah'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}