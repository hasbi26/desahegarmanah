<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PendudukModel;
use App\Models\MusimanModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $pendudukModel; // penduduk tetap (tabel 'penduduk')
    protected $musimanModel;  // penduduk musiman (tabel 'musiman')
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
        $this->pendudukModel = new PendudukModel();
        $this->musimanModel = new MusimanModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');

        // Builder penduduk tetap
        $tetap = $this->pendudukModel;
        if ($role === 2 && $rtId) {
            $tetap = $tetap->where('rt_id', $rtId);
        }

        // Builder musiman
        $musiman = $this->musimanModel;
        if ($role === 2 && $rtId) {
            $musiman = $musiman->where('rt_id', $rtId);
        }

        // Window waktu untuk perbandingan 30 hari
        $cutoff   = date('Y-m-d H:i:s', strtotime('-30 days'));
        $prevStart = date('Y-m-d H:i:s', strtotime('-60 days'));
        $prevEnd   = $cutoff;

        // Total Tetap dan baseline 30 hari lalu
        $totalTetap = (clone $tetap)->countAllResults(false);
        $totalTetapBefore = (clone $tetap)->where('created_at <', $cutoff)->countAllResults(false);
        $tetapChangePct = $totalTetapBefore > 0 ? (($totalTetap - $totalTetapBefore) / $totalTetapBefore) * 100 : 0;

        // Total Musiman dan baseline
        $totalMusiman = (clone $musiman)->countAllResults(false);
        $totalMusimanBefore = (clone $musiman)->where('created_at <', $cutoff)->countAllResults(false);
        $musimanChangePct = $totalMusimanBefore > 0 ? (($totalMusiman - $totalMusimanBefore) / $totalMusimanBefore) * 100 : 0;

        // Penduduk Baru 30 hari (penduduk tetap saja sesuai konfirmasi)
        $baru30 = (clone $tetap)->where('created_at >=', $cutoff)->countAllResults(false);
        $baruPrev30 = (clone $tetap)
            ->where('created_at >=', $prevStart)
            ->where('created_at <', $prevEnd)
            ->countAllResults(false);
        $baruChangePct = $baruPrev30 > 0 ? (($baru30 - $baruPrev30) / $baruPrev30) * 100 : 0;

        // Total Keseluruhan + baseline
        $totalAll = $totalTetap + $totalMusiman;
        $totalAllBefore = $totalTetapBefore + $totalMusimanBefore;
        $allChangePct = $totalAllBefore > 0 ? (($totalAll - $totalAllBefore) / $totalAllBefore) * 100 : 0;

        // Statistik existing untuk chart (berbasis tetap)
        $laki = (clone $tetap)->where('jenis_kelamin', 'L')->countAllResults(false);
        $perempuan = (clone $tetap)->where('jenis_kelamin', 'P')->countAllResults(false);

        $perRT = (clone $tetap)
            ->select('rt_id, COUNT(*) as jumlah')
            ->groupBy('rt_id')
            ->orderBy('jumlah', 'DESC')
            ->findAll(10);

        $kelahiran = (clone $tetap)->where('kelahiran', 1)->countAllResults(false);
        $kematian  = (clone $tetap)->where('kematian', 1)->countAllResults(false);
        $pendatang = (clone $tetap)->where('pendatang', 1)->countAllResults(false);
        $pindah    = (clone $tetap)->where('pindah', 1)->countAllResults(false);

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
