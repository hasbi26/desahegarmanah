<?php

namespace App\Models;

use CodeIgniter\Model;

class RumahTanggaModel extends Model
{
    protected $table = 'rumah_tangga';
    protected $primaryKey = 'id';
    protected $allowedFields = ['penduduk_id', 'air', 'listrik', 'sampah', 'limbah'];
    protected $useTimestamps = true;
}
