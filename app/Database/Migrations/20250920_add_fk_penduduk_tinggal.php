<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkPendudukTinggal extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        try {
            $sql = "SELECT COUNT(*) AS c FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'penduduk_tinggal' AND CONSTRAINT_NAME = 'fk_penduduktinggal_penduduknew'";
            $row = $db->query($sql)->getRowArray();
            $count = isset($row['c']) ? (int)$row['c'] : 0;
            if ($count === 0) {
                // Add FK constraint safely
                $db->query("ALTER TABLE `penduduk_tinggal` ADD CONSTRAINT `fk_penduduktinggal_penduduknew` FOREIGN KEY (`penduduk_id`) REFERENCES `penduduk_new`(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
            }
        } catch (\Throwable $e) {
            // Migration should fail loudly so dev can inspect
            throw $e;
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        try {
            $sql = "SELECT COUNT(*) AS c FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'penduduk_tinggal' AND CONSTRAINT_NAME = 'fk_penduduktinggal_penduduknew'";
            $row = $db->query($sql)->getRowArray();
            $count = isset($row['c']) ? (int)$row['c'] : 0;
            if ($count > 0) {
                $db->query("ALTER TABLE `penduduk_tinggal` DROP FOREIGN KEY `fk_penduduktinggal_penduduknew`");
            }
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
