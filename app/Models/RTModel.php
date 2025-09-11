<?php

namespace App\Models;

use CodeIgniter\Model;

class RTModel extends Model
{
    protected $table = 'rts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['rt', 'rw', 'nama_ketua'];
    protected $useTimestamps = true;
}
