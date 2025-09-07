<?php
namespace App\Models;

use CodeIgniter\Model;

class ProgramPemerintahModel extends Model
{
    protected $table = 'program_pemerintah';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'permukiman_id', 'blt_dana_desa', 'pkh', 'bst', 'banpres',
        'bantuan_umkm', 'bantuan_pekerja', 'bantuan_pendidikan', 'lainnya', 'keterangan_lainnya'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}