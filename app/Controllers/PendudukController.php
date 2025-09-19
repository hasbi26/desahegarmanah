<?php

namespace App\Controllers;

use App\Models\PendudukIntiModel;
use App\Models\PendudukMutasiModel;
use App\Models\PendudukTinggalModel;
use App\Models\RumahTanggaModel;
use App\Models\RTModel;
use CodeIgniter\HTTP\ResponseInterface;

class PendudukController extends BaseController
{
    protected $pendudukIntiModel;
    protected $pendudukMutasiModel;
    protected $pendudukTinggalModel;
    protected $rumahTanggaModel;
    protected $rtModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->pendudukIntiModel    = new PendudukIntiModel();
        $this->pendudukMutasiModel  = new PendudukMutasiModel();
        $this->pendudukTinggalModel = new PendudukTinggalModel();
        $this->rumahTanggaModel     = new RumahTanggaModel();
        $this->rtModel              = new RTModel();
        $this->session              = \Config\Services::session();
    }

    private function restrictBuilderByRole($builder)
    {
        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && $rtId) {
            // Pada skema baru, rt_id berada di tabel penduduk_tinggal
            $builder->where('penduduk_tinggal.rt_id', $rtId);
        }
        return $builder;
    }

    /**
     * Pastikan rt_id ada di sesi untuk role=2. Jika kosong, ambil dari tabel user.
     */
    private function ensureRtIdInSession(): void
    {
        $role = (int) $this->session->get('role');
        if ($role !== 2) return;
        if ($this->session->get('rt_id')) return;

        $userId = $this->session->get('user_id');
        if (!$userId) return;
        try {
            $db = db_connect();
            $row = $db->table('user')->select('rt_id')->where('id', $userId)->get()->getRowArray();
            if ($row && !empty($row['rt_id'])) {
                $this->session->set('rt_id', (int) $row['rt_id']);
            }
        } catch (\Throwable $e) {
            log_message('error', 'ensureRtIdInSession failed: ' . $e->getMessage());
        }
    }

    /**
     * Pastikan data RT dasar tersedia (RT01, RT10).
     */
    private function ensureRtSeeds(): void
    {
        try {
            $existing = $this->rtModel
                ->select('rt')
                ->whereIn('rt', ['RT01', '01', 'RT10', '10'])
                ->findAll();
            $have = array_map(static function ($r) {
                return strtoupper($r['rt']);
            }, $existing ?? []);
            $toInsert = [];
            if (!in_array('RT01', $have, true) && !in_array('01', $have, true)) {
                $toInsert[] = ['rt' => 'RT01'];
            }
            if (!in_array('RT10', $have, true) && !in_array('10', $have, true)) {
                $toInsert[] = ['rt' => 'RT10'];
            }
            if (!empty($toInsert)) {
                $this->rtModel->insertBatch($toInsert);
            }
        } catch (\Throwable $e) {
            log_message('error', 'ensureRtSeeds failed: ' . $e->getMessage());
        }
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $this->ensureRtIdInSession();

        $q = $this->request->getGet('q');
        $page = max(1, (int) $this->request->getGet('page'));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // Join penduduk inti + tinggal untuk kebutuhan listing (rt_id dan alamat)
        $builder = $this->pendudukIntiModel->select('penduduk_new.*, penduduk_tinggal.rt_id')
            ->join('penduduk_tinggal', 'penduduk_tinggal.penduduk_id = penduduk_new.id', 'left');
        $this->restrictBuilderByRole($builder);
        if ($q) {
            $builder = $builder->groupStart()
                ->like('penduduk_new.nama_lengkap', $q)
                ->orLike('penduduk_new.nik', $q)
                ->orLike('penduduk_new.no_kk', $q)
                ->orLike('penduduk_new.alamat', $q)
                ->groupEnd();
        }
        $total = $builder->countAllResults(false);
        $items = $builder->orderBy('penduduk_new.updated_at', 'DESC')->findAll($perPage, $offset);

        $data = [
            'title' => 'Data Penduduk',
            'items' => $items,
            'q' => $q,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => (int) ceil($total / $perPage),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama'),
        ];
        return view('penduduk/index', $data);
    }

    public function create()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $this->ensureRtIdInSession();
        $role = (int) $this->session->get('role');
        $sessionRtId = $this->session->get('rt_id');

        // Ambil opsi RT sesuai peran; untuk RT (role=2) dengan rt_id di sesi, tidak perlu dropdown
        $rtOptions = [];
        $currentRt = null;
        if ($role === 2 && !empty($sessionRtId)) {
            $currentRt = $this->rtModel->find((int) $sessionRtId);
        } else {
            $rtOptions = $this->rtModel
                ->orderBy('rt', 'ASC')
                ->orderBy('rw', 'ASC')
                ->findAll();
        }

        return view('penduduk/form', [
            'title' => 'Tambah Penduduk',
            'rtOptions' => $rtOptions,
            'currentRt' => $currentRt,
            'item' => null,
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama'),
        ]);
    }

    public function store()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');

        $inti = $this->request->getPost([
            'nama_lengkap',
            'nik',
            'no_kk',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'pendidikan',
            'status_perkawinan',
            'agama',
            'pekerjaan',
            'alamat'
        ]);
        $mutasi = $this->request->getPost(['kelahiran', 'pendatang', 'kematian', 'pindah']);
        $tinggal = $this->request->getPost(['rt_id', 'status_rumah', 'luas_tanah', 'luas_bangunan']);
        $rumah  = $this->request->getPost(['air', 'listrik', 'sampah', 'limbah']);

        $role = (int) $this->session->get('role');
        if ($role === 2) {
            $this->ensureRtIdInSession();
            $rtId = $this->session->get('rt_id');
            if ($rtId) {
                // Jika sesi memiliki rt_id, pakai itu (abaikan input form)
                $tinggal['rt_id'] = (int) $rtId;
            } else {
                // Sesi kosong: izinkan pilih dari dropdown (RT01/RT10)
                // Pastikan nilai dari form ada dan integer
                if (empty($tinggal['rt_id']) || !is_numeric($tinggal['rt_id'])) {
                    return redirect()->back()->withInput()->with('errors', ['rt_id' => 'Silakan pilih RT']);
                }
                $tinggal['rt_id'] = (int) $tinggal['rt_id'];
            }
        }

        // Normalisasi checkbox
        foreach (['kelahiran', 'pendatang', 'kematian', 'pindah'] as $f) {
            $mutasi[$f] = isset($mutasi[$f]) ? 1 : 0;
        }

        $rules = [
            'nama_lengkap' => 'required',
            'nik' => 'required|min_length[8]|is_unique[penduduk_new.nik]',
            'jenis_kelamin' => 'required',
            'rt_id' => 'required|is_natural_no_zero'
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        $toValidate = array_merge($inti, ['rt_id' => $tinggal['rt_id'] ?? null, 'jenis_kelamin' => $inti['jenis_kelamin'] ?? null]);
        if (!$validation->run($toValidate)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }


        // Sanitasi RT dan pastikan RT ada di tabel rts sebelum transaksi
        $tinggal['rt_id'] = isset($tinggal['rt_id']) && is_numeric($tinggal['rt_id']) ? (int)$tinggal['rt_id'] : null;
        $db = \Config\Database::connect();
        $rtOk = $tinggal['rt_id'] ? (bool) $db->table('rts')->where('id', $tinggal['rt_id'])->countAllResults() : false;
        if (!$rtOk) {
            return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak valid (tidak ditemukan)']);
        }

        try {
            $db->transException(true)->transStart();

            $pendudukId = $this->pendudukIntiModel->insert($inti, true);
            $mutasi['penduduk_id'] = $pendudukId;
            $this->pendudukMutasiModel->insert($mutasi);
            $tinggal['penduduk_id'] = $pendudukId;
            $this->pendudukTinggalModel->insert($tinggal);
            $rumah['penduduk_id'] = $pendudukId;
            $this->rumahTanggaModel->insert($rumah);

            $db->transComplete();
        } catch (\Throwable $e) {
            log_message('error', 'Store penduduk gagal: ' . $e->getMessage());
            if ($db->transStatus() === false) {
                $db->transRollback();
            }
            return redirect()->back()->withInput()->with('errors', ['Gagal menyimpan data. Pastikan RT valid dan data benar.']);
        }

        if (!$db->transStatus()) {
            return redirect()->back()->withInput()->with('errors', ['Gagal menyimpan data']);
        }

        return redirect()->to(base_url('penduduk'))->with('success', 'Data penduduk berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $this->ensureRtIdInSession();
        // Ambil data gabungan untuk form
        $inti = $this->pendudukIntiModel->find($id);
        if (!$inti) return redirect()->to(base_url('penduduk'))->with('error', 'Data tidak ditemukan');
        $tinggal = $this->pendudukTinggalModel->where('penduduk_id', $id)->first() ?? [];
        $mutasi  = $this->pendudukMutasiModel->where('penduduk_id', $id)->first() ?? [];
        $rumah   = $this->rumahTanggaModel->where('penduduk_id', $id)->first() ?? [];

        $role = (int) $this->session->get('role');
        // Samakan dengan logika Musiman: pastikan rt_id tersedia di sesi untuk role=2
        if ($role === 2) {
            $this->ensureRtIdInSession();
        }
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && isset($tinggal['rt_id']) && (int)$tinggal['rt_id'] !== (int)$rtId) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Tidak memiliki akses');
        }

        // Dropdown RT hanya untuk Admin atau ketika RT belum terset di sesi
        $rtOptions = [];
        $currentRt = null;
        if ($role === 2 && !empty($rtId)) {
            $currentRt = $this->rtModel->find((int) $rtId);
        } else {
            $rtOptions = $this->rtModel
                ->orderBy('rt', 'ASC')
                ->orderBy('rw', 'ASC')
                ->findAll();
        }
        return view('penduduk/form', [
            'title' => 'Edit Penduduk',
            'rtOptions' => $rtOptions,
            'currentRt' => $currentRt,
            // Pastikan ID penduduk tidak tertimpa oleh kolom id dari tabel relasi
            'item' => array_merge($inti, ['penduduk_id' => $id], $tinggal, $mutasi, $rumah),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama'),
        ]);
    }

    public function update($id = null)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        // Log incoming update request for debugging
        try {
            $actor = $this->session->get('user_id') ?? 'anon';
            $postRaw = $this->request->getPost();
            // Prefer POST 'id' field (hidden input) per user request
            $resolvedId = $this->request->getPost('id');
            if (empty($resolvedId) && $id !== null) {
                $resolvedId = $id;
            }
            $resolvedId = is_numeric($resolvedId) ? (int)$resolvedId : null;
            $logData = ['actor' => $actor, 'target_id' => $resolvedId, 'post_keys' => array_keys($postRaw)];
            log_message('info', 'Penduduk update requested: ' . json_encode($logData));
        } catch (\Throwable $e) {
            // don't fail update for logging issues
            log_message('error', 'Failed to log penduduk update request: ' . $e->getMessage());
        }
        if ($resolvedId === null) {
            return redirect()->to(base_url('penduduk'))->with('error', 'ID penduduk tidak disertakan');
        }
        // Gunakan ID dari form hidden, abaikan kemungkinan id relasi
        $id = (int) $resolvedId;
        // Use PendudukIntiModel (maps to penduduk_new) to fetch existing row
        $intiBefore = $this->pendudukIntiModel->find($id);
        if (!$intiBefore) return redirect()->to(base_url('penduduk'))->with('error', 'Data tidak ditemukan');
        $tinggalBefore = $this->pendudukTinggalModel->where('penduduk_id', $id)->first() ?? [];

        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2) {
            $this->ensureRtIdInSession();
            $rtId = $this->session->get('rt_id');
            if (!$rtId) {
                return redirect()->to(base_url('penduduk'))->with('error', 'RT tidak tersedia di sesi. Silakan login ulang.');
            }
        }
        if ($role === 2 && isset($tinggalBefore['rt_id']) && (int)$tinggalBefore['rt_id'] !== (int)$rtId) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Tidak memiliki akses');
        }

        $inti = $this->request->getPost([
            'nama_lengkap',
            'nik',
            'no_kk',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'pendidikan',
            'status_perkawinan',
            'agama',
            'pekerjaan',
            'alamat'
        ]);
        $mutasi = $this->request->getPost(['kelahiran', 'pendatang', 'kematian', 'pindah']);
        $tinggal = $this->request->getPost(['rt_id', 'status_rumah', 'luas_tanah', 'luas_bangunan']);
        $rumah  = $this->request->getPost(['air', 'listrik', 'sampah', 'limbah']);

        if ($role === 2) {
            if ($rtId) {
                $tinggal['rt_id'] = (int)$rtId;
            } else {
                // Sesi kosong: terima dari form
                if (empty($tinggal['rt_id']) || !is_numeric($tinggal['rt_id'])) {
                    return redirect()->back()->withInput()->with('errors', ['rt_id' => 'Silakan pilih RT']);
                }
                $tinggal['rt_id'] = (int)$tinggal['rt_id'];
            }
        }
        foreach (['kelahiran', 'pendatang', 'kematian', 'pindah'] as $f) {
            $mutasi[$f] = isset($mutasi[$f]) ? 1 : 0;
        }

        // Manual uniqueness check for NIK when updating: if NIK changed and already exists for another record, reject.
        $inputNik = isset($inti['nik']) ? trim($inti['nik']) : '';
        if ($inputNik !== '' && $inputNik !== ($intiBefore['nik'] ?? '')) {
            $existsNik = $this->pendudukIntiModel->where('nik', $inputNik)->where('id !=', $id)->first();
            if ($existsNik) {
                return redirect()->back()->withInput()->with('errors', ['nik' => 'NIK sudah digunakan oleh penduduk lain']);
            }
        }

        $rules = [
            'nama_lengkap' => 'required',
            'nik' => 'required|min_length[8]',
            'jenis_kelamin' => 'required',
            'rt_id' => 'required|is_natural_no_zero',
        ];
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        $toValidate = array_merge($inti, ['rt_id' => $tinggal['rt_id'] ?? null, 'jenis_kelamin' => $inti['jenis_kelamin'] ?? null]);
        if (!$validation->run($toValidate)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Sanitasi dan validasi FK RT sebelum transaksi
        $tinggal['rt_id'] = isset($tinggal['rt_id']) && is_numeric($tinggal['rt_id']) ? (int)$tinggal['rt_id'] : null;
        $db = \Config\Database::connect();
        $rtOk = $tinggal['rt_id'] ? (bool) $db->table('rts')->where('id', $tinggal['rt_id'])->countAllResults() : false;
        if (!$rtOk) {
            return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak valid (tidak ditemukan)']);
        }

        try {
            $db->transException(true)->transStart();

            log_message('debug', 'Updating penduduk_inti id=' . $id . ' with data: ' . json_encode($inti));
            $this->pendudukIntiModel->update($id, $inti);
            // upsert mutasi
            $existsMutasi = $this->pendudukMutasiModel->where('penduduk_id', $id)->first();
            if ($existsMutasi) {
                $this->pendudukMutasiModel->update($existsMutasi['id'], $mutasi);
            } else {
                $mutasi['penduduk_id'] = $id;
                $this->pendudukMutasiModel->insert($mutasi);
            }
            // upsert tinggal
            $existsTinggal = $this->pendudukTinggalModel->where('penduduk_id', $id)->first();
            if ($existsTinggal) {
                $this->pendudukTinggalModel->update($existsTinggal['id'], $tinggal);
            } else {
                $tinggal['penduduk_id'] = $id;
                $this->pendudukTinggalModel->insert($tinggal);
            }
            // upsert rumah
            $existsRumah = $this->rumahTanggaModel->where('penduduk_id', $id)->first();
            if ($existsRumah) {
                $this->rumahTanggaModel->update($existsRumah['id'], $rumah);
            } else {
                $rumah['penduduk_id'] = $id;
                $this->rumahTanggaModel->insert($rumah);
            }

            $db->transComplete();
            log_message('debug', 'Update penduduk berhasil untuk id=' . $id);
        } catch (\Throwable $e) {
            log_message('error', 'Update penduduk gagal: ' . $e->getMessage());
            if ($db->transStatus() === false) {
                $db->transRollback();
            }
            return redirect()->back()->withInput()->with('errors', ['Gagal memperbarui data. Pastikan RT valid dan data benar.']);
        }

        if (!$db->transStatus()) {
            $err = $db->error();
            $msg = !empty($err['message']) ? $err['message'] : 'Gagal memperbarui data';
            log_message('error', 'Transaksi update penduduk gagal: ' . $msg);
            return redirect()->back()->withInput()->with('errors', [$msg]);
        }

        return redirect()->to(base_url('penduduk'))->with('success', 'Data penduduk berhasil diperbarui');
    }

    public function show($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $this->ensureRtIdInSession();
        $inti = $this->pendudukIntiModel->find($id);
        if (!$inti) return redirect()->to(base_url('penduduk'))->with('error', 'Data tidak ditemukan');
        $tinggal = $this->pendudukTinggalModel->where('penduduk_id', $id)->first() ?? [];
        $mutasi  = $this->pendudukMutasiModel->where('penduduk_id', $id)->first() ?? [];
        $rumah   = $this->rumahTanggaModel->where('penduduk_id', $id)->first() ?? [];

        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && isset($tinggal['rt_id']) && (int)$tinggal['rt_id'] !== (int)$rtId) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Tidak memiliki akses');
        }

        return view('penduduk/show', [
            'title' => 'Detail Penduduk',
            'item' => array_merge($inti, $tinggal, $mutasi, $rumah),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama'),
        ]);
    }

    public function delete($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $this->ensureRtIdInSession();
        $inti = $this->pendudukIntiModel->find($id);
        if (!$inti) return redirect()->to(base_url('penduduk'))->with('error', 'Data tidak ditemukan');
        $tinggal = $this->pendudukTinggalModel->where('penduduk_id', $id)->first();
        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && $tinggal && (int)$tinggal['rt_id'] !== (int)$rtId) {
            return redirect()->to(base_url('penduduk'))->with('error', 'Tidak memiliki akses');
        }
        // Hapus inti, relasi akan ikut terhapus via FK CASCADE pada tabel normalized
        $this->pendudukIntiModel->delete($id);
        return redirect()->to(base_url('penduduk'))->with('success', 'Data penduduk berhasil dihapus');
    }

    public function exportPdf()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $this->ensureRtIdInSession();
        // Export dari skema baru: join untuk RT
        $builder = $this->pendudukIntiModel->select('penduduk_new.*, penduduk_tinggal.rt_id')
            ->join('penduduk_tinggal', 'penduduk_tinggal.penduduk_id = penduduk_new.id', 'left');
        $this->restrictBuilderByRole($builder);
        $items = $builder->orderBy('penduduk_new.nama_lengkap', 'ASC')->findAll();

        $html = view('penduduk/pdf', ['items' => $items]);
        // Dompdf export
        if (!class_exists('Dompdf\\Dompdf')) {
            return $this->response->setBody($html);
        }
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $this->response->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }

    public function exportExcel()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $this->ensureRtIdInSession();
        // Export dari skema baru: join untuk RT
        $builder = $this->pendudukIntiModel->select('penduduk_new.*, penduduk_tinggal.rt_id')
            ->join('penduduk_tinggal', 'penduduk_tinggal.penduduk_id = penduduk_new.id', 'left');
        $this->restrictBuilderByRole($builder);
        $items = $builder->orderBy('penduduk_new.nama_lengkap', 'ASC')->findAll();

        // Simple CSV as Excel alternative
        $filename = 'penduduk.csv';
        $headers = [
            'NAMA LENGKAP',
            'NIK',
            'NO KK',
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JK',
            'PENDIDIKAN',
            'STATUS PERKAWINAN',
            'AGAMA',
            'PEKERJAAN',
            'ALAMAT',
            'KELAHIRAN',
            'PENDATANG',
            'KEMATIAN',
            'PINDAH',
            'STATUS RUMAH',
            'LUAS TANAH',
            'LUAS BANGUNAN',
            'AIR',
            'LISTRIK',
            'SAMPAH',
            'LIMBAH',
            'RT ID'
        ];
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, $headers);
        foreach ($items as $i) {
            fputcsv($csv, [
                $i['nama_lengkap'],
                $i['nik'],
                $i['no_kk'],
                $i['tempat_lahir'],
                $i['tanggal_lahir'],
                $i['jenis_kelamin'],
                $i['pendidikan'],
                $i['status_perkawinan'],
                $i['agama'],
                $i['pekerjaan'],
                $i['alamat'],
                $i['kelahiran'],
                $i['pendatang'],
                $i['kematian'],
                $i['pindah'],
                $i['status_rumah'],
                $i['luas_tanah'],
                $i['luas_bangunan'],
                $i['air'],
                $i['listrik'],
                $i['sampah'],
                $i['limbah'],
                $i['rt_id']
            ]);
        }
        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }
}
