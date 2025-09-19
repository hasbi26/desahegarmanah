<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    // GET /api/dashboard/summary
    public function summary(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $totalTetap = (int) $db->table('penduduk_new')->countAllResults();
        $totalMusiman = (int) $db->table('musiman')->countAllResults();

        // 30 hari terakhir (berdasarkan created_at)
        $last30Tetap = (int) $db->table('penduduk_new')->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults();
        $last30Musiman = (int) $db->table('musiman')->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))->countAllResults();

        $totalKeseluruhan = $totalTetap + $totalMusiman;

        // Persentase kenaikan (last30 vs total). Hindari div 0
        $pctTetap = $totalTetap > 0 ? round(($last30Tetap / $totalTetap) * 100, 2) : 0.0;
        $pctMusiman = $totalMusiman > 0 ? round(($last30Musiman / $totalMusiman) * 100, 2) : 0.0;
        $pctTotal = $totalKeseluruhan > 0 ? round((($last30Tetap + $last30Musiman) / $totalKeseluruhan) * 100, 2) : 0.0;

        return $this->response->setJSON([
            'status' => 'ok',
            'data' => [
                'total_penduduk_tetap' => $totalTetap,
                'total_penduduk_musiman' => $totalMusiman,
                'penduduk_baru_30_hari' => $last30Tetap,
                'musiman_baru_30_hari' => $last30Musiman,
                'total_keseluruhan' => $totalKeseluruhan,
                'persentase_30_hari' => [
                    'tetap' => $pctTetap,
                    'musiman' => $pctMusiman,
                    'total' => $pctTotal,
                ]
            ]
        ]);
    }

    // GET /api/dashboard/distribusi-rt
    public function distribusiPerRT(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $rows = $db->query('
            SELECT rt.nama as rt_nama, COUNT(pt.id) as total
            FROM rts rt
            LEFT JOIN penduduk_tinggal pt ON pt.rt_id = rt.id
            GROUP BY rt.id, rt.nama
            ORDER BY total DESC
            LIMIT 10
        ')->getResultArray();
        return $this->response->setJSON(['status' => 'ok', 'data' => $rows]);
    }

    // GET /api/dashboard/komposisi-jenis-kelamin
    public function komposisiJenisKelamin(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $rows = $db->query('
            SELECT jenis_kelamin, COUNT(*) as total
            FROM penduduk_new
            GROUP BY jenis_kelamin
        ')->getResultArray();

        // Hitung persentase
        $total = array_sum(array_column($rows, 'total')) ?: 1;
        foreach ($rows as &$r) {
            $r['persentase'] = round(($r['total'] / $total) * 100, 2);
        }
        return $this->response->setJSON(['status' => 'ok', 'data' => $rows]);
    }
}