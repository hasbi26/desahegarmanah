<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToMusimanTable extends Migration
{
    public function up()
    {
        $fields = [
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
                'null' => true,
            ],
            'nik' => [
                'type' => 'CHAR',
                'constraint' => 16,
                'null' => true,
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status_perkawinan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'alasan_tinggal' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'lainnya' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('musiman', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('musiman', [
            'nama_lengkap',
            'jenis_kelamin',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'status_perkawinan',
            'alasan_tinggal',
            'lainnya',
        ]);
    }
}
