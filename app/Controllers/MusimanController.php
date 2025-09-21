<?php

namespace App\Controllers;

use App\Models\MusimanModel;
use App\Models\PendudukIntiModel;

class MusimanController extends BaseController
{
    protected $musimanModel;
    protected $pendudukModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->musimanModel = new MusimanModel();
        $this->pendudukModel = new PendudukIntiModel();
        $this->session = \Config\Services::session();
    }

    private function restrictBuilderByRole($builder)
    {
        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && $rtId) {
            $builder->where('rt_id', $rtId);
        }
        return $builder;
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');

        $q = $this->request->getGet('q');
        $page = max(1, (int) $this->request->getGet('page'));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);
        if ($q) {
            $builder = $builder->groupStart()
                ->like('periode', $q)
                ->orLike('keterangan', $q)
                ->orLike('nama_lengkap', $q)
                ->orLike('nik', $q)
                ->groupEnd();
        }
        $total = $builder->countAllResults(false);
        $items = $builder->orderBy('updated_at', 'DESC')->findAll($perPage, $offset);

        return view('musiman/index', [
            'title' => 'Data Penduduk Musiman',
            'items' => $items,
            'q' => $q,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => (int) ceil($total / $perPage),
        ]);
    }

    public function create()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        return view('musiman/form', ['title' => 'Tambah Musiman', 'item' => null]);
    }

    public function store()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $data = $this->request->getPost([
            'penduduk_id',
            'periode',
            'keterangan',
            'nama_perguruan_tinggi',
            'nama_perusahaan',
            'alamat_tempat_jualan',
            'alasan_lainnya',
            'nama_pondokan',
            'alamat_pondokan',
            'no_telp',
            'alamat_asal',
            'rt_id',
            'nama_lengkap',
            'jenis_kelamin',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'status_perkawinan',
            'alasan_tinggal',
            'lainnya',
        ]);

        $role = (int) $this->session->get('role');
        // ensure rt_id is present and comes from session for role 2
        if ($role === 2 && !$this->session->get('rt_id')) {
            // Attempt to read rt_id from DB for the current user (fallback when session is stale)
            $userId = $this->session->get('user_id');
            if ($userId) {
                try {
                    $db = db_connect();
                    $row = $db->table('user')->select('rt_id')->where('id', $userId)->get()->getRowArray();
                    if ($row && isset($row['rt_id']) && $row['rt_id']) {
                        $this->session->set('rt_id', $row['rt_id']);
                    }
                } catch (\Throwable $e) {
                    // ignore DB error and fallback to existing behavior below
                    log_message('error', 'Failed to fetch rt_id fallback: ' . $e->getMessage());
                }
            }
        }
        $data['rt_id'] = ($role === 2) ? $this->session->get('rt_id') : (isset($data['rt_id']) ? (int) $data['rt_id'] : null);
        if ($role === 2 && !$data['rt_id']) {
            return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak tersedia di sesi. Silakan login ulang atau pilih RT.']);
        }
        // Normalisasi nilai numerik agar tidak menjadi 0 saat kosong
        // Jangan paksa cast yang bisa jadi 0; gunakan validasi aman
        if ($role === 2) {
            $rtIdFromSession = $this->session->get('rt_id');
            $data['rt_id'] = (is_numeric($rtIdFromSession) && (int)$rtIdFromSession > 0) ? (int)$rtIdFromSession : null;
        } else {
            $data['rt_id'] = (isset($data['rt_id']) && is_numeric($data['rt_id']) && (int)$data['rt_id'] > 0) ? (int)$data['rt_id'] : null;
        }
        $data['penduduk_id'] = isset($data['penduduk_id']) && $data['penduduk_id'] !== '' ? (int)$data['penduduk_id'] : null;
        $data['kategori'] = 'Musiman';

        $rules = [
            'rt_id' => 'required|is_natural_no_zero',
            'penduduk_id' => 'permit_empty|is_natural_no_zero',
            'periode' => 'required',
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        if (!$validation->run($data)) return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        // Verify foreign keys exist to avoid DB exception
        try {
            $db = db_connect();
            // check rt exists
            $rtOk = (bool) $db->table('rts')->where('id', $data['rt_id'])->countAllResults();
            if (!$rtOk) return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak valid (tidak ditemukan)']);
            // check penduduk exists if provided
            if (!empty($data['penduduk_id'])) {
                $pendOk = (bool) $db->table('penduduk_new')->where('id', $data['penduduk_id'])->countAllResults();
                if (!$pendOk) return redirect()->back()->withInput()->with('errors', ['penduduk_id' => 'Penduduk ID tidak valid (tidak ditemukan)']);
            }
        } catch (\Throwable $e) {
            log_message('error', 'FK check failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('errors', ['db' => 'Gagal melakukan validasi data terkait. Coba lagi.']);
        }

        // Final safety checks before insert: ensure rt_id is a positive int
        log_message('debug', 'Musiman store payload pre-insert: ' . json_encode($data));
        if (!isset($data['rt_id']) || !is_numeric($data['rt_id']) || (int)$data['rt_id'] <= 0) {
            log_message('error', 'Musiman insert prevented: invalid rt_id: ' . var_export($data['rt_id'], true));
            return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak valid atau kosong.']);
        }
        $data['rt_id'] = (int) $data['rt_id'];
        if (!empty($data['penduduk_id']) && (!is_numeric($data['penduduk_id']) || (int)$data['penduduk_id'] <= 0)) {
            log_message('error', 'Musiman insert prevented: invalid penduduk_id: ' . var_export($data['penduduk_id'], true));
            return redirect()->back()->withInput()->with('errors', ['penduduk_id' => 'Penduduk ID tidak valid']);
        }

        try {
            $this->musimanModel->insert($data);
        } catch (\Throwable $e) {
            log_message('error', 'Musiman insert failed: ' . $e->getMessage() . ' -- payload: ' . json_encode($data));
            // Friendly error for FK problems or other DB issues
            return redirect()->back()->withInput()->with('errors', ['db' => 'Gagal menyimpan data musiman. Pastikan RT dan Penduduk valid.']);
        }
        return redirect()->to(base_url('musiman'))->with('success', 'Data musiman berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $item = $this->musimanModel->find($id);
        if (!$item) return redirect()->to('musiman')->with('error', 'Data tidak ditemukan');
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return redirect()->to('musiman')->with('error', 'Tidak memiliki akses');
        }
        // If penduduk_id is set, fetch display name for the form
        if (!empty($item['penduduk_id'])) {
            try {
                $db = db_connect();
                $row = $db->table('penduduk_new')->select('id, nama_lengkap')->where('id', $item['penduduk_id'])->get()->getRowArray();
                if ($row) $item['penduduk_name'] = $row['nama_lengkap'];
            } catch (\Throwable $e) {
                log_message('error', 'Failed to fetch penduduk name for edit: ' . $e->getMessage());
            }
        }

        return view('musiman/form', ['title' => 'Edit Musiman', 'item' => $item]);
    }

    public function update($id = null)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        if ($id === null) {
            $id = $this->request->getPost('id');
        }
        $item = $this->musimanModel->find($id);
        if (!$item) return redirect()->to('musiman')->with('error', 'Data tidak ditemukan');
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return redirect()->to('musiman')->with('error', 'Tidak memiliki akses');
        }
        $data = $this->request->getPost([
            'penduduk_id',
            'periode',
            'keterangan',
            'nama_perguruan_tinggi',
            'nama_perusahaan',
            'alamat_tempat_jualan',
            'alasan_lainnya',
            'nama_pondokan',
            'alamat_pondokan',
            'no_telp',
            'alamat_asal',
            'rt_id',
            'nama_lengkap',
            'jenis_kelamin',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'status_perkawinan',
            'alasan_tinggal',
            'lainnya',
        ]);

        if ($role === 2) {
            if (!$this->session->get('rt_id')) {
                // Attempt to read rt_id from DB for the current user (fallback)
                $userId = $this->session->get('user_id');
                if ($userId) {
                    try {
                        $db = db_connect();
                        $row = $db->table('user')->select('rt_id')->where('id', $userId)->get()->getRowArray();
                        if ($row && isset($row['rt_id']) && $row['rt_id']) {
                            $this->session->set('rt_id', $row['rt_id']);
                        }
                    } catch (\Throwable $e) {
                        log_message('error', 'Failed to fetch rt_id fallback (update): ' . $e->getMessage());
                    }
                }
            }
            $rtIdFromSession = $this->session->get('rt_id');
            $data['rt_id'] = (is_numeric($rtIdFromSession) && (int)$rtIdFromSession > 0) ? (int)$rtIdFromSession : null;
        } else {
            $data['rt_id'] = (isset($data['rt_id']) && is_numeric($data['rt_id']) && (int)$data['rt_id'] > 0) ? (int)$data['rt_id'] : null;
        }
        if ($role === 2 && !$data['rt_id']) {
            return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak tersedia di sesi. Silakan login ulang atau pilih RT.']);
        }
        // Normalisasi numerik agar tidak menjadi 0
        $data['penduduk_id'] = isset($data['penduduk_id']) && $data['penduduk_id'] !== '' ? (int)$data['penduduk_id'] : null;

        $rules = [
            'rt_id' => 'required|is_natural_no_zero',
            'penduduk_id' => 'permit_empty|is_natural_no_zero',
            'periode' => 'required',
        ];
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        if (!$validation->run($data)) return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        // Verify foreign keys exist before update
        try {
            $db = db_connect();
            $rtOk = (bool) $db->table('rts')->where('id', $data['rt_id'])->countAllResults();
            if (!$rtOk) return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak valid (tidak ditemukan)']);
            if (!empty($data['penduduk_id'])) {
                $pendOk = (bool) $db->table('penduduk_new')->where('id', $data['penduduk_id'])->countAllResults();
                if (!$pendOk) return redirect()->back()->withInput()->with('errors', ['penduduk_id' => 'Penduduk ID tidak valid (tidak ditemukan)']);
            }
        } catch (\Throwable $e) {
            log_message('error', 'FK check failed (update): ' . $e->getMessage());
            return redirect()->back()->withInput()->with('errors', ['db' => 'Gagal melakukan validasi data terkait. Coba lagi.']);
        }

        // Final safety checks before update
        log_message('debug', 'Musiman update payload pre-update (id=' . $id . '): ' . json_encode($data));
        if (!isset($data['rt_id']) || !is_numeric($data['rt_id']) || (int)$data['rt_id'] <= 0) {
            log_message('error', 'Musiman update prevented (id=' . $id . '): invalid rt_id: ' . var_export($data['rt_id'], true));
            return redirect()->back()->withInput()->with('errors', ['rt_id' => 'RT tidak valid atau kosong.']);
        }
        $data['rt_id'] = (int) $data['rt_id'];
        if (!empty($data['penduduk_id']) && (!is_numeric($data['penduduk_id']) || (int)$data['penduduk_id'] <= 0)) {
            log_message('error', 'Musiman update prevented (id=' . $id . '): invalid penduduk_id: ' . var_export($data['penduduk_id'], true));
            return redirect()->back()->withInput()->with('errors', ['penduduk_id' => 'Penduduk ID tidak valid']);
        }

        try {
            $this->musimanModel->update($id, $data);
        } catch (\Throwable $e) {
            log_message('error', 'Musiman update failed (id=' . $id . '): ' . $e->getMessage() . ' -- payload: ' . json_encode($data));
            return redirect()->back()->withInput()->with('errors', ['db' => 'Gagal memperbarui data musiman. Pastikan RT dan Penduduk valid.']);
        }
        return redirect()->to(base_url('musiman'))->with('success', 'Data musiman berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $item = $this->musimanModel->find($id);
        if (!$item) return redirect()->to('musiman')->with('error', 'Data tidak ditemukan');
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return redirect()->to('musiman')->with('error', 'Tidak memiliki akses');
        }
        $this->musimanModel->delete($id);
        return redirect()->to(base_url('musiman'))->with('success', 'Data musiman berhasil dihapus');
    }

    public function exportPdf()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);
        $items = $builder->orderBy('periode', 'ASC')->findAll();
        $html = view('musiman/pdf', ['items' => $items]);
        if (!class_exists('Dompdf\\Dompdf')) return $this->response->setBody($html);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $this->response->setHeader('Content-Type', 'application/pdf')->setBody($dompdf->output());
    }

    public function exportExcel()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);
        $items = $builder->orderBy('periode', 'ASC')->findAll();

        $filename = 'musiman.csv';
        $headers = ['RT ID', 'PENDUDUK ID', 'PERIODE', 'KETERANGAN'];
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, $headers);
        foreach ($items as $i) {
            fputcsv($csv, [$i['rt_id'], $i['penduduk_id'], $i['periode'], $i['keterangan']]);
        }
        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);
        return $this->response->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }

    public function ajaxList()
    {
        if (!$this->session->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $q = $this->request->getGet('q');
        $page = max(1, (int) $this->request->getGet('page'));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);
        if ($q) {
            $builder = $builder->groupStart()
                ->like('periode', $q)
                ->orLike('keterangan', $q)
                ->orLike('nama_lengkap', $q)
                ->orLike('nik', $q)
                ->groupEnd();
        }
        $total = $builder->countAllResults(false);
        $items = $builder->orderBy('updated_at', 'DESC')->findAll($perPage, $offset);

        $data = [
            'items' => $items,
            'q' => $q,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => (int) ceil($total / $perPage),
        ];
        return $this->response->setJSON($data);
    }
}
