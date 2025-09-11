<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukTinggalModel extends Model
{
    protected $table = 'penduduk_tinggal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['penduduk_id', 'rt_id', 'status_rumah', 'luas_tanah', 'luas_bangunan'];
    protected $useTimestamps = true;
}
