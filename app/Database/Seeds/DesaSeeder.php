<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DesaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Desa Hegarmanah', 'kecamatan_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Desa Jatimulya',  'kecamatan_id' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('desa')->insertBatch($data);
    }
}
