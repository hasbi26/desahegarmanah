<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeRtIdNullableInMusiman extends Migration
{
    public function up()
    {
        // Drop the existing foreign key
        $this->forge->dropForeignKey('musiman', 'musiman_rt_id_foreign');

        // Modify rt_id to be nullable
        $this->forge->modifyColumn('musiman', [
            'rt_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        // Optionally, add back the foreign key if you still want referential integrity
        // But allow null
        $this->forge->addForeignKey('rt_id', 'rts', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        // Remove the foreign key
        $this->forge->dropForeignKey('musiman', 'musiman_rt_id_foreign');

        // Make rt_id NOT NULL again
        $this->forge->modifyColumn('musiman', [
            'rt_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        // Add back the original foreign key
        $this->forge->addForeignKey('rt_id', 'rts', 'id', 'CASCADE', 'CASCADE');
    }
}