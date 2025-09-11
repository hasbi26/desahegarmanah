<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NormalizePendudukTables extends Migration
{
    public function up()
    {
        // penduduk_new: data inti
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
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nik');
        $this->forge->createTable('penduduk_new', true);

        // penduduk_mutasi
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'penduduk_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kelahiran'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'pendatang'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'kematian'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'pindah'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penduduk_id', 'penduduk_new', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penduduk_mutasi', true);

        // penduduk_tinggal
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'penduduk_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'rt_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'status_rumah'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'luas_tanah'    => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'luas_bangunan' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penduduk_id', 'penduduk_new', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('rt_id', 'rts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('penduduk_tinggal', true);

        // rumah_tangga
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'penduduk_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'air'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'listrik'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'sampah'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'limbah'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penduduk_id', 'penduduk_new', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rumah_tangga', true);

        // Alter musiman: tambah kolom detail
        $this->forge->addColumn('musiman', [
            'nama_perguruan_tinggi' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'nama_perusahaan'       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'alamat_tempat_jualan'  => ['type' => 'TEXT', 'null' => true],
            'alasan_lainnya'        => ['type' => 'TEXT', 'null' => true],
            'nama_pondokan'         => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'alamat_pondokan'       => ['type' => 'TEXT', 'null' => true],
            'no_telp'               => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'alamat_asal'           => ['type' => 'TEXT', 'null' => true],
        ]);

        // Migrasi data dari penduduk lama ke tabel-tabel baru
        $db = \Config\Database::connect();
        // Salin inti
        $db->query('
            INSERT INTO penduduk_new (id, nama_lengkap, nik, no_kk, tempat_lahir, tanggal_lahir, jenis_kelamin, pendidikan, status_perkawinan, agama, pekerjaan, alamat, created_at, updated_at)
            SELECT id, nama_lengkap, nik, no_kk, tempat_lahir, tanggal_lahir, jenis_kelamin, pendidikan, status_perkawinan, agama, pekerjaan, alamat, created_at, updated_at
            FROM penduduk
        ');
        // Mutasi
        $db->query('
            INSERT INTO penduduk_mutasi (penduduk_id, kelahiran, pendatang, kematian, pindah, created_at, updated_at)
            SELECT id, kelahiran, pendatang, kematian, pindah, created_at, updated_at
            FROM penduduk
        ');
        // Tinggal
        $db->query('
            INSERT INTO penduduk_tinggal (penduduk_id, rt_id, status_rumah, luas_tanah, luas_bangunan, created_at, updated_at)
            SELECT id, rt_id, status_rumah, luas_tanah, luas_bangunan, created_at, updated_at
            FROM penduduk
        ');
        // Rumah tangga
        $db->query('
            INSERT INTO rumah_tangga (penduduk_id, air, listrik, sampah, limbah, created_at, updated_at)
            SELECT id, air, listrik, sampah, limbah, created_at, updated_at
            FROM penduduk
        ');
    }

    public function down()
    {
        // Revert kolom tambahan musiman
        $this->forge->dropColumn('musiman', [
            'nama_perguruan_tinggi',
            'nama_perusahaan',
            'alamat_tempat_jualan',
            'alasan_lainnya',
            'nama_pondokan',
            'alamat_pondokan',
            'no_telp',
            'alamat_asal',
        ]);
        $this->forge->dropTable('rumah_tangga', true);
        $this->forge->dropTable('penduduk_tinggal', true);
        $this->forge->dropTable('penduduk_mutasi', true);
        $this->forge->dropTable('penduduk_new', true);
    }
}
