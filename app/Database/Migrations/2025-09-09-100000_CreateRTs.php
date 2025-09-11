<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRTs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rt'         => ['type' => 'VARCHAR', 'constraint' => 10],
            'rw'         => ['type' => 'VARCHAR', 'constraint' => 10],
            'nama_ketua' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('rts', true);
    }

    public function down()
    {
        $this->forge->dropTable('rts', true);
    }
}
