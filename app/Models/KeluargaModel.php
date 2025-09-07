<?php
namespace App\Models;

use CodeIgniter\Model;

class KeluargaModel extends Model
{
    protected $table = 'keluarga';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor_kk', 'nik_kepala_keluarga', 'lokasi_id', 'enumerator_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    
    protected $validationRules = [
        'nomor_kk' => 'required|max_length[20]',
        'nik_kepala_keluarga' => 'required|max_length[16]',
        'lokasi_id' => 'required|numeric',
        'enumerator_id' => 'required|numeric'
    ];
}