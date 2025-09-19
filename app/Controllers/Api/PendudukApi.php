<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PendudukIntiModel;
use App\Models\PendudukMutasiModel;
use App\Models\PendudukTinggalModel;
use App\Models\RumahTanggaModel;

class PendudukApi extends BaseController
{
    protected $pendudukIntiModel;
    protected $pendudukMutasiModel;
    protected $pendudukTinggalModel;
    protected $rumahTanggaModel;
    protected $session;

    public function __construct()
    {
        $this->pendudukIntiModel    = new PendudukIntiModel();
        $this->pendudukMutasiModel  = new PendudukMutasiModel();
        $this->pendudukTinggalModel = new PendudukTinggalModel();
        $this->rumahTanggaModel     = new RumahTanggaModel();
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

    // GET /api/penduduk?q=&page=&perPage=
    public function index()
    {
        $q       = $this->request->getGet('q');
        $page    = max(1, (int) $this->request->getGet('page')) ?: 1;
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $offset  = ($page - 1) * $perPage;

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

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $items,
            'pagination' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => (int) ceil($total / $perPage),
            ],
        ]);
    }

    // GET /api/penduduk/{id}
    public function show($id)
    {
        $inti = $this->pendudukIntiModel->find($id);
        if (!$inti) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
        $tinggal = $this->pendudukTinggalModel->where('penduduk_id', $id)->first() ?? [];
        $mutasi  = $this->pendudukMutasiModel->where('penduduk_id', $id)->first() ?? [];
        $rumah   = $this->rumahTanggaModel->where('penduduk_id', $id)->first() ?? [];

        // Akses RT untuk role Ketua RT
        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && isset($tinggal['rt_id']) && (int)$tinggal['rt_id'] !== (int)$rtId) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak memiliki akses',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => array_merge($inti, $tinggal, $mutasi, $rumah),
        ]);
    }

    // POST /api/penduduk
    public function store()
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!is_array($input)) $input = [];

        $inti = [
            'nama_lengkap'     => $input['nama_lengkap'] ?? null,
            'nik'              => $input['nik'] ?? null,
            'no_kk'            => $input['no_kk'] ?? null,
            'tempat_lahir'     => $input['tempat_lahir'] ?? null,
            'tanggal_lahir'    => $input['tanggal_lahir'] ?? null,
            'jenis_kelamin'    => $input['jenis_kelamin'] ?? null,
            'pendidikan'       => $input['pendidikan'] ?? null,
            'status_perkawinan'=> $input['status_perkawinan'] ?? null,
            'agama'            => $input['agama'] ?? null,
            'pekerjaan'        => $input['pekerjaan'] ?? null,
            'alamat'           => $input['alamat'] ?? null,
        ];
        $mutasi = [
            'kelahiran' => !empty($input['kelahiran']) ? 1 : 0,
            'pendatang' => !empty($input['pendatang']) ? 1 : 0,
            'kematian'  => !empty($input['kematian']) ? 1 : 0,
            'pindah'    => !empty($input['pindah']) ? 1 : 0,
        ];
        $tinggal = [
            'rt_id'         => $input['rt_id'] ?? null,
            'status_rumah'  => $input['status_rumah'] ?? null,
            'luas_tanah'    => $input['luas_tanah'] ?? null,
            'luas_bangunan' => $input['luas_bangunan'] ?? null,
        ];
        $rumah  = [
            'air'     => $input['air'] ?? null,
            'listrik' => $input['listrik'] ?? null,
            'sampah'  => $input['sampah'] ?? null,
            'limbah'  => $input['limbah'] ?? null,
        ];

        $role = (int) $this->session->get('role');
        if ($role === 2) {
            $tinggal['rt_id'] = $this->session->get('rt_id');
        }

        $rules = [
            'nama_lengkap'  => 'required',
            'nik'           => 'required|min_length[8]|is_unique[penduduk_new.nik]',
            'jenis_kelamin' => 'required',
            'rt_id'         => 'required|integer',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getErrors(),
            ]);
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
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data',
            ]);
        }

        return $this->response->setStatusCode(201)->setJSON([
            'status'  => 'success',
            'message' => 'Data penduduk berhasil ditambahkan',
            'id'      => $pendudukId,
        ]);
    }

    // PUT /api/penduduk/{id}
    public function update($id)
    {
        $intiBefore = $this->pendudukIntiModel->find($id);
        if (!$intiBefore) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $tinggalBefore = $this->pendudukTinggalModel->where('penduduk_id', $id)->first() ?? [];

        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && isset($tinggalBefore['rt_id']) && (int)$tinggalBefore['rt_id'] !== (int)$rtId) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak memiliki akses',
            ]);
        }

        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!is_array($input)) $input = [];

        $inti = [
            'nama_lengkap'     => $input['nama_lengkap'] ?? $intiBefore['nama_lengkap'] ?? null,
            'nik'              => $input['nik'] ?? $intiBefore['nik'] ?? null,
            'no_kk'            => $input['no_kk'] ?? $intiBefore['no_kk'] ?? null,
            'tempat_lahir'     => $input['tempat_lahir'] ?? $intiBefore['tempat_lahir'] ?? null,
            'tanggal_lahir'    => $input['tanggal_lahir'] ?? $intiBefore['tanggal_lahir'] ?? null,
            'jenis_kelamin'    => $input['jenis_kelamin'] ?? $intiBefore['jenis_kelamin'] ?? null,
            'pendidikan'       => $input['pendidikan'] ?? $intiBefore['pendidikan'] ?? null,
            'status_perkawinan'=> $input['status_perkawinan'] ?? $intiBefore['status_perkawinan'] ?? null,
            'agama'            => $input['agama'] ?? $intiBefore['agama'] ?? null,
            'pekerjaan'        => $input['pekerjaan'] ?? $intiBefore['pekerjaan'] ?? null,
            'alamat'           => $input['alamat'] ?? $intiBefore['alamat'] ?? null,
        ];
        $mutasi = [
            'kelahiran' => !empty($input['kelahiran']) ? 1 : 0,
            'pendatang' => !empty($input['pendatang']) ? 1 : 0,
            'kematian'  => !empty($input['kematian']) ? 1 : 0,
            'pindah'    => !empty($input['pindah']) ? 1 : 0,
        ];
        $tinggal = [
            'rt_id'         => $input['rt_id'] ?? ($tinggalBefore['rt_id'] ?? null),
            'status_rumah'  => $input['status_rumah'] ?? ($tinggalBefore['status_rumah'] ?? null),
            'luas_tanah'    => $input['luas_tanah'] ?? ($tinggalBefore['luas_tanah'] ?? null),
            'luas_bangunan' => $input['luas_bangunan'] ?? ($tinggalBefore['luas_bangunan'] ?? null),
        ];
        $rumah = [
            'air'     => $input['air'] ?? null,
            'listrik' => $input['listrik'] ?? null,
            'sampah'  => $input['sampah'] ?? null,
            'limbah'  => $input['limbah'] ?? null,
        ];

        if ($role === 2) $tinggal['rt_id'] = $rtId;

        $rules = [
            'nama_lengkap'  => 'required',
            'nik'           => "required|min_length[8]|is_unique[penduduk_new.nik,id,{$id}]",
            'jenis_kelamin' => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getErrors(),
            ]);
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
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 'error',
                'message' => 'Gagal memperbarui data',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data penduduk berhasil diperbarui',
        ]);
    }

    // DELETE /api/penduduk/{id}
    public function delete($id)
    {
        $inti = $this->pendudukIntiModel->find($id);
        if (!$inti) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
        $tinggal = $this->pendudukTinggalModel->where('penduduk_id', $id)->first();

        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && $tinggal && (int)$tinggal['rt_id'] !== (int)$rtId) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak memiliki akses',
            ]);
        }

        $this->pendudukIntiModel->delete($id);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data penduduk berhasil dihapus',
        ]);
    }
}