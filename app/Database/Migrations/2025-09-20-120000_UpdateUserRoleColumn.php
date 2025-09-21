<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserRoleColumn extends Migration
{
    public function up()
    {
        // Modify the role column to ENUM type with specific roles
        $this->forge->modifyColumn('user', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['desa/admin', 'rt', 'kecamatan', 'kabupaten'],
                'default' => 'rt',
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        // Revert the role column back to its original state
        $this->forge->modifyColumn('user', [
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }
}
