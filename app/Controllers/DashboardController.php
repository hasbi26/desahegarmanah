<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MusimanModel;
use App\Models\PendudukIntiModel;       // penduduk_new (inti)
use App\Models\PendudukTinggalModel;    // rt_id per penduduk
use App\Models\PendudukMutasiModel;     // kelahiran/pendatang/kematian/pindah

class DashboardController extends BaseController
{
    protected $userModel;
    protected $musimanModel;       // tabel musiman
    protected $intiModel;          // tabel penduduk_new
    protected $tinggalModel;       // tabel penduduk_tinggal
    protected $mutasiModel;        // tabel penduduk_mutasi
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel     = new UserModel();
        $this->musimanModel  = new MusimanModel();
        $this->intiModel     = new PendudukIntiModel();
        $this->tinggalModel  = new PendudukTinggalModel();
        $this->mutasiModel   = new PendudukMutasiModel();
        $this->session       = \Config\Services::session();
    }

    private function restrictByRole($builder)
    {
        $roleRaw = $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        $roleStr = strtolower((string)$roleRaw);
        $isRT = ((int)$roleRaw === 2) || in_array($roleStr, ['rt', 'pengelola rt'], true);
        if ($isRT && $rtId) {
            // Filter berdasarkan RT dari tabel penduduk_tinggal
            $builder->where('penduduk_tinggal.rt_id', $rtId);
        }
        return $builder;
    }

    public function index()
    {
        try {
            if (!$this->session->get('logged_in')) {
                return redirect()->to('/')
                    ->with('error', 'Silakan login terlebih dahulu');
            }

            $roleRaw = $this->session->get('role');
            $rtId = $this->session->get('rt_id');
            $roleStr = strtolower((string)$roleRaw);
            $isRT = ((int)$roleRaw === 2) || in_array($roleStr, ['rt', 'pengelola rt'], true);

            // Helper: buat builder baru untuk penduduk tetap + join penduduk_tinggal
            $db = \Config\Database::connect();
            $buildTetap = function () use ($db) {
                return $db->table('penduduk_new')
                    ->select('penduduk_new.id, penduduk_new.jenis_kelamin, penduduk_new.created_at, penduduk_tinggal.rt_id')
                    ->join('penduduk_tinggal', 'penduduk_tinggal.penduduk_id = penduduk_new.id', 'left');
            };

            // Builder musiman dengan scope RT (mendukung role string)
            $musiman = $this->musimanModel;
            if ($isRT && $rtId) {
                $musiman = $musiman->where('rt_id', $rtId);
            }

            // Window waktu untuk perbandingan 30 hari
            $cutoff    = date('Y-m-d H:i:s', strtotime('-30 days'));
            $prevStart = date('Y-m-d H:i:s', strtotime('-60 days'));
            $prevEnd   = $cutoff;

            // Helper perubahan persen yang aman dari pembagi 0
            $percent = static function (int $current, int $baseline): float {
                if ($baseline > 0) {
                    return (($current - $baseline) / $baseline) * 100.0;
                }
                if ($current > 0) {
                    // Tampilkan 100% saat ada pertumbuhan dari nol agar informatif di UI
                    return 100.0;
                }
                return 0.0;
            };

            // Total Tetap dan baseline 30 hari lalu (pakai created_at penduduk_new)
            // Gunakan builder fresh untuk setiap hitungan agar join selalu ada
            try {
                $totalTetap = $this->restrictByRole($buildTetap())->countAllResults(false);
                $totalTetapBefore = $this->restrictByRole($buildTetap())->where('penduduk_new.created_at <', $cutoff)->countAllResults(false);
            } catch (\Throwable $e) {
                log_message('error', 'Dashboard totalTetap query failed: ' . $e->getMessage());
                $totalTetap = $totalTetapBefore = 0;
            }
            $tetapChangePct = $percent((int)$totalTetap, (int)$totalTetapBefore);

            // Total Musiman dan baseline
            $totalMusiman = (clone $musiman)->countAllResults(false);
            $totalMusimanBefore = (clone $musiman)->where('created_at <', $cutoff)->countAllResults(false);
            $musimanChangePct = $percent((int)$totalMusiman, (int)$totalMusimanBefore);

            // Penduduk Baru 30 hari (berdasarkan penduduk_new.created_at)
            $baru30 = $this->restrictByRole($buildTetap())->where('penduduk_new.created_at >=', $cutoff)->countAllResults(false);
            $baruPrev30 = $this->restrictByRole($buildTetap())
                ->where('penduduk_new.created_at >=', $prevStart)
                ->where('penduduk_new.created_at <', $prevEnd)
                ->countAllResults(false);
            $baruChangePct = $percent((int)$baru30, (int)$baruPrev30);

            // Total keseluruhan
            $totalAll = $totalTetap + $totalMusiman;
            $totalAllBefore = $totalTetapBefore + $totalMusimanBefore;
            $allChangePct = $percent((int)$totalAll, (int)$totalAllBefore);

            // Statistik berbasis tetap (skema baru) - robust mapping nilai JK ke L/P
            $jkRow = $this->restrictByRole($buildTetap())
                ->select("\n                SUM(CASE WHEN UPPER(TRIM(penduduk_new.jenis_kelamin)) IN ('L','LAKI-LAKI','LAKI','LK') THEN 1 ELSE 0 END) AS laki,\n                SUM(CASE WHEN UPPER(TRIM(penduduk_new.jenis_kelamin)) IN ('P','PEREMPUAN','PR') THEN 1 ELSE 0 END) AS perempuan\n            ", false)
                ->get()
                ->getRowArray() ?? ['laki' => 0, 'perempuan' => 0];
            $laki = (int)($jkRow['laki'] ?? 0);
            $perempuan = (int)($jkRow['perempuan'] ?? 0);

            // Distribusi per RT (Top 10) – gunakan rt_id dari penduduk_tinggal
            // Bangun builder baru yang FROM penduduk_tinggal agar kolom rt_id selalu tersedia
            try {
                $perRTBuilder = $db->table('penduduk_tinggal')
                    ->select('penduduk_tinggal.rt_id, COUNT(penduduk_new.id) as jumlah')
                    ->join('penduduk_new', 'penduduk_new.id = penduduk_tinggal.penduduk_id', 'inner');
                $this->restrictByRole($perRTBuilder);
                $perRT = $perRTBuilder
                    ->groupBy('penduduk_tinggal.rt_id')
                    ->orderBy('jumlah', 'DESC')
                    ->limit(10)
                    ->get()
                    ->getResultArray();
            } catch (\Throwable $e) {
                log_message('error', 'Dashboard perRT query failed: ' . $e->getMessage());
                $perRT = [];
            }

            // Status dinamis berasal dari penduduk_mutasi (skema baru). Join untuk scope RT.
            // Use fresh DB table builder to avoid reusing model builder which can accumulate joins
            $mutasiBaseBuilder = function () use ($db) {
                return $db->table('penduduk_mutasi')
                    ->select('penduduk_mutasi.*, penduduk_tinggal.rt_id')
                    ->join('penduduk_tinggal', 'penduduk_tinggal.penduduk_id = penduduk_mutasi.penduduk_id', 'left');
            };

            $kelahiran = $this->restrictByRole($mutasiBaseBuilder())->where('penduduk_mutasi.kelahiran', 1)->countAllResults(false);
            $kematian  = $this->restrictByRole($mutasiBaseBuilder())->where('penduduk_mutasi.kematian', 1)->countAllResults(false);
            $pendatang = $this->restrictByRole($mutasiBaseBuilder())->where('penduduk_mutasi.pendatang', 1)->countAllResults(false);
            $pindah    = $this->restrictByRole($mutasiBaseBuilder())->where('penduduk_mutasi.pindah', 1)->countAllResults(false);
        } catch (\Throwable $e) {
            // Top-level dashboard failure: log and redirect safely to avoid Whoops
            log_message('error', 'Dashboard top-level exception: ' . $e->getMessage() . ' -- trace: ' . $e->getTraceAsString());
            return redirect()->to('/')->with('error', 'Terjadi kesalahan saat memuat dashboard. Silakan coba lagi nanti.');
        }

        $data = [
            'title' => 'Dashboard Penduduk',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama'),
            'stats' => [
                'total' => $totalTetap,
                'laki' => $laki,
                'perempuan' => $perempuan,
                'kelahiran' => $kelahiran,
                'kematian' => $kematian,
                'pendatang' => $pendatang,
                'pindah' => $pindah,
                'perRT' => $perRT,
                'cards' => [
                    'tetap' => ['total' => $totalTetap, 'changePct' => $tetapChangePct],
                    'musiman' => ['total' => $totalMusiman, 'changePct' => $musimanChangePct],
                    'baru' => ['total' => $baru30, 'changePct' => $baruChangePct],
                    'total_all' => ['total' => $totalAll, 'changePct' => $allChangePct],
                ],
            ],
        ];

        // Return dashboard view
        return view('pages/dashboard', $data);
    }

    public function settings()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $data = [
            'title' => 'Settings',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama')
        ];
        return view('pages/settings', $data);
    }

    public function keluarga()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $data = [
            'title' => 'KUESIONER RUMAH TANGGA',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama')
        ];
        return view('pages/keluarga', $data);
    }

    public function formIndividu()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $data = [
            'title' => 'KUESIONER Individu',
            'username' => session()->get('username'),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama')
        ];
        return view('pages/form_individu', $data);
    }
}