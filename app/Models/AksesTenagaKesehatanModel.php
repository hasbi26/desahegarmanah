<?php
namespace App\Models;

use CodeIgniter\Model;

class AksesTenagaKesehatanModel extends Model
{
    protected $table = 'akses_tenaga_kesehatan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['permukiman_id', 'tenaga_kesehatan', 'jarak_km', 'waktu_tempuh_jam', 'kemudahan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}