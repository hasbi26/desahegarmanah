<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMusiman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rt_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'penduduk_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'kategori'      => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Musiman'],
            'periode'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'keterangan'    => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rt_id', 'rts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('penduduk_id', 'penduduk', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('musiman', true);
    }

    public function down()
    {
        $this->forge->dropTable('musiman', true);
    }
}
