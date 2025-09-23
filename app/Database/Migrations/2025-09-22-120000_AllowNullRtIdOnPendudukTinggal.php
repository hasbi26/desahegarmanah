<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AllowNullRtIdOnPendudukTinggal extends Migration
{
    public function up()
    {
        // Make rt_id nullable to allow saving data when user has no RT assigned
        $this->forge->modifyColumn('penduduk_tinggal', [
            'rt_id' => [
                'name'       => 'rt_id',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        // Revert: make rt_id NOT NULL again (beware: will fail if NULL values exist)
        $this->forge->modifyColumn('penduduk_tinggal', [
            'rt_id' => [
                'name'       => 'rt_id',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }
}