<?php
namespace App\Models;

use CodeIgniter\Model;

class AksesPendidikanModel extends Model
{
    protected $table = 'akses_pendidikan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['permukiman_id', 'fasilitas', 'jarak_km', 'waktu_tempuh_jam', 'kemudahan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}