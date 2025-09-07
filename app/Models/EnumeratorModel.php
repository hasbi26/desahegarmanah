<?php
namespace App\Models;

use CodeIgniter\Model;

class EnumeratorModel extends Model
{
    protected $table = 'enumerator';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'alamat', 'hp_telepon'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}