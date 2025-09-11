<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUserAddRtId extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('rt_id', 'user')) {
            $this->forge->addColumn('user', [
                'rt_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'role_id'
                ],
            ]);
        }
        // optional: add FK if DB supports
        // $this->forge->addForeignKey('rt_id', 'rts', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        if ($this->db->fieldExists('rt_id', 'user')) {
            $this->forge->dropColumn('user', 'rt_id');
        }
    }
}
