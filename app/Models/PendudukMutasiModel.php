<?php

namespace App\Models;

use CodeIgniter\Model;

class PendudukMutasiModel extends Model
{
    protected $table = 'penduduk_mutasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['penduduk_id', 'kelahiran', 'pendatang', 'kematian', 'pindah'];
    protected $useTimestamps = true;
}
