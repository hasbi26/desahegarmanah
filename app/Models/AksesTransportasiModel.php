<?php
namespace App\Models;

use CodeIgniter\Model;

class AksesTransportasiModel extends Model
{
    protected $table = 'akses_transportasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'permukiman_id', 'tujuan', 'jenis_transportasi', 'transportasi_umum',
        'waktu_tempuh_jam', 'biaya_perjalanan', 'kemudahan'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}