<?php
namespace App\Models;

use CodeIgniter\Model;

class PermukimanModel extends Model
{
    protected $table = 'permukiman';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'keluarga_id', 'tempat_tinggal', 'status_lahan', 'luas_lantai', 'luas_lahan',
        'jenis_lantai', 'jenis_dinding', 'jendela', 'atap', 'penerangan',
        'energi_masak', 'sumber_kayu_bakar', 'pembuangan_sampah', 'fasilitas_mck',
        'sumber_air_mandi', 'fasilitas_bab', 'sumber_air_minum', 'pembuangan_limbah_cair',
        'bawah_sutet', 'bantaran_sungai', 'lereng_bukit', 'kondisi_rumah'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}