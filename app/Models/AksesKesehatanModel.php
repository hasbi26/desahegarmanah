<?php

namespace App\Models;

use CodeIgniter\Model;

class AksesKesehatanModel extends Model
{
    protected $table            = 'akses_kesehatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'permukiman_id',
        'fasilitas',
        'jarak_km',
        'waktu_tempuh_jam',
        'kemudahan',
        'created_at',
        'updated_at',
    ];

    // Timestamps (kolom sudah ada di DB dump)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi sederhana (opsional, bisa disesuaikan)
    protected $validationRules = [
        'permukiman_id'    => 'required|integer',
        'fasilitas'        => 'required|string',
        'jarak_km'         => 'permit_empty|decimal',
        'waktu_tempuh_jam' => 'permit_empty|decimal',
        'kemudahan'        => 'permit_empty|in_list[1,2]',
    ];

    protected $validationMessages = [
        'permukiman_id' => [
            'required' => 'permukiman_id wajib diisi',
            'integer'  => 'permukiman_id harus angka',
        ],
        'fasilitas' => [
            'required' => 'fasilitas wajib diisi',
        ],
    ];
}