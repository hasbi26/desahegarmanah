<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenduduk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_lengkap'    => ['type' => 'VARCHAR', 'constraint' => 150],
            'nik'             => ['type' => 'VARCHAR', 'constraint' => 20],
            'no_kk'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'tempat_lahir'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tanggal_lahir'   => ['type' => 'DATE', 'null' => true],
            'jenis_kelamin'   => ['type' => 'VARCHAR', 'constraint' => 1],
            'pendidikan'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'status_perkawinan' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'agama'           => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'pekerjaan'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'alamat'          => ['type' => 'TEXT', 'null' => true],
            'kelahiran'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'pendatang'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'kematian'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'pindah'          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status_rumah'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'luas_tanah'      => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'luas_bangunan'   => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'air'             => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'listrik'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'sampah'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'limbah'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'rt_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nik');
        $this->forge->addForeignKey('rt_id', 'rts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penduduk', true);
    }

    public function down()
    {
        $this->forge->dropTable('penduduk', true);
    }
}
