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

    public function index()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');

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
        $role = (int) $this->session->get('role');
        $rtOptions = ($role === 2) ? [] : $this->rtModel->orderBy('rt', 'ASC')->findAll();
        return view('penduduk/form', [
            'title' => 'Tambah Penduduk',
            'rtOptions' => $rtOptions,
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
            $tinggal['rt_id'] = $this->session->get('rt_id');
        }

        // Normalisasi checkbox
        foreach (['kelahiran', 'pendatang', 'kematian', 'pindah'] as $f) {
            $mutasi[$f] = isset($mutasi[$f]) ? 1 : 0;
        }

        $rules = [
            'nama_lengkap' => 'required',
            'nik' => 'required|min_length[8]|is_unique[penduduk_new.nik]',
            'jenis_kelamin' => 'required',
            'rt_id' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $pendudukId = $this->pendudukIntiModel->insert($inti, true);
        $mutasi['penduduk_id'] = $pendudukId;
        $this->pendudukMutasiModel->insert($mutasi);
        $tinggal['penduduk_id'] = $pendudukId;
        $this->pendudukTinggalModel->insert($tinggal);
        $rumah['penduduk_id'] = $pendudukId;
        $this->rumahTanggaModel->insert($rumah);
        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()->back()->withInput()->with('errors', ['Gagal menyimpan data']);
        }

        return redirect()->to(base_url('penduduk'))->with('success', 'Data penduduk berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        // Ambil data gabungan untuk form
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

        $rtOptions = ($role === 2) ? [] : $this->rtModel->orderBy('rt', 'ASC')->findAll();
        return view('penduduk/form', [
            'title' => 'Edit Penduduk',
            'rtOptions' => $rtOptions,
            'item' => array_merge($inti, $tinggal, $mutasi, $rumah),
            'role' => session()->get('role'),
            'wilayah_nama' => session()->get('wilayah_nama'),
        ]);
    }

    public function update($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $intiBefore = $this->pendudukIntiModel->find($id);
        if (!$intiBefore) return redirect()->to(base_url('penduduk'))->with('error', 'Data tidak ditemukan');
        $tinggalBefore = $this->pendudukTinggalModel->where('penduduk_id', $id)->first() ?? [];

        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
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

        if ($role === 2) $tinggal['rt_id'] = $rtId;
        foreach (['kelahiran', 'pendatang', 'kematian', 'pindah'] as $f) {
            $mutasi[$f] = isset($mutasi[$f]) ? 1 : 0;
        }

        $rules = [
            'nama_lengkap' => 'required',
            'nik' => "required|min_length[8]|is_unique[penduduk_new.nik,id,{$id}]",
            'jenis_kelamin' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();
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

        if (!$db->transStatus()) {
            return redirect()->back()->withInput()->with('errors', ['Gagal memperbarui data']);
        }

        return redirect()->to(base_url('penduduk'))->with('success', 'Data penduduk berhasil diperbarui');
    }

    public function show($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
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
