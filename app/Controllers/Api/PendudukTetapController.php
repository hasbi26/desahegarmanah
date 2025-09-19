<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PendudukIntiModel; // penduduk_new
use App\Models\PendudukTinggalModel; // penduduk_tinggal
use App\Models\PendudukModel; // legacy (jika masih dipakai di tempat lain)
use CodeIgniter\HTTP\ResponseInterface;

class PendudukTetapController extends BaseController
{
    protected PendudukIntiModel $inti;
    protected PendudukTinggalModel $tinggal;

    public function __construct()
    {
        $this->inti   = new PendudukIntiModel();
        $this->tinggal = new PendudukTinggalModel();
    }

    // GET /api/penduduk-tetap
    public function index(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $rows = $db->table('penduduk_new pn')
            ->select('pn.*, pt.rt_id, pt.status_rumah, pt.luas_tanah, pt.luas_bangunan')
            ->join('penduduk_tinggal pt', 'pt.penduduk_id = pn.id', 'left')
            ->get()->getResultArray();
        return $this->response->setJSON(['status' => 'ok', 'data' => $rows]);
    }

    // GET /api/penduduk-tetap/{id}
    public function show($id = null): ResponseInterface
    {
        if (!$id) return $this->failValidationErrors('ID wajib diisi');
        $db = \Config\Database::connect();
        $row = $db->table('penduduk_new pn')
            ->select('pn.*, pt.rt_id, pt.status_rumah, pt.luas_tanah, pt.luas_bangunan')
            ->join('penduduk_tinggal pt', 'pt.penduduk_id = pn.id', 'left')
            ->where('pn.id', $id)
            ->get()->getRowArray();
        if (!$row) return $this->failNotFound('Data tidak ditemukan');
        return $this->response->setJSON(['status' => 'ok', 'data' => $row]);
    }

    // POST /api/penduduk-tetap
    // Body JSON contoh:
    // {
    //   "nama_lengkap":"...", "nik":"...", ..., "rt_id": 3,
    //   "status_rumah":"Hak Milik", "luas_tanah":100, "luas_bangunan":60
    // }
    public function create(): ResponseInterface
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        // Pisahkan data inti dan tinggal
        $intiData = array_intersect_key($input, array_flip([
            'nama_lengkap','nik','no_kk','tempat_lahir','tanggal_lahir','jenis_kelamin','pendidikan','status_perkawinan','agama','pekerjaan','alamat'
        ]));
        if (!$this->inti->insert($intiData)) {
            return $this->failValidationErrors($this->inti->errors());
        }
        $pendudukId = $this->inti->getInsertID();

        $tinggalData = array_intersect_key($input, array_flip(['rt_id','status_rumah','luas_tanah','luas_bangunan']));
        $tinggalData['penduduk_id'] = $pendudukId;
        if (!empty($tinggalData)) {
            if (!$this->tinggal->insert($tinggalData)) {
                return $this->failValidationErrors($this->tinggal->errors());
            }
        }

        return $this->show($pendudukId)->setStatusCode(201);
    }

    // PUT/PATCH /api/penduduk-tetap/{id}
    public function update($id = null): ResponseInterface
    {
        if (!$id) return $this->failValidationErrors('ID wajib diisi');
        $input = $this->request->getJSON(true) ?? $this->request->getRawInput();

        $intiData = array_intersect_key($input, array_flip([
            'nama_lengkap','nik','no_kk','tempat_lahir','tanggal_lahir','jenis_kelamin','pendidikan','status_perkawinan','agama','pekerjaan','alamat'
        ]));
        if ($intiData && !$this->inti->update($id, $intiData)) {
            return $this->failValidationErrors($this->inti->errors());
        }

        $tinggalData = array_intersect_key($input, array_flip(['rt_id','status_rumah','luas_tanah','luas_bangunan']));
        if ($tinggalData) {
            // pastikan baris tinggal ada; jika tidak, buatkan
            $existing = $this->tinggal->where('penduduk_id', $id)->first();
            $tinggalData['penduduk_id'] = $id;
            if ($existing) {
                if (!$this->tinggal->update($existing['id'], $tinggalData)) {
                    return $this->failValidationErrors($this->tinggal->errors());
                }
            } else {
                if (!$this->tinggal->insert($tinggalData)) {
                    return $this->failValidationErrors($this->tinggal->errors());
                }
            }
        }

        return $this->show($id);
    }

    // DELETE /api/penduduk-tetap/{id}
    public function delete($id = null): ResponseInterface
    {
        if (!$id) return $this->failValidationErrors('ID wajib diisi');
        // Hapus cascading: tinggal dulu, lalu inti
        $this->tinggal->where('penduduk_id', $id)->delete();
        $deleted = $this->inti->delete($id);
        if (!$deleted) return $this->failNotFound('Data tidak ditemukan');
        return $this->response->setJSON(['status' => 'deleted']);
    }

    // GET /api/penduduk-tetap/search?q=nama_or_nik
    public function search(): ResponseInterface
    {
        $q = trim((string)$this->request->getGet('q'));
        if ($q === '') return $this->response->setJSON(['status' => 'ok', 'data' => []]);
        $db = \Config\Database::connect();
        $rows = $db->table('penduduk_new pn')
            ->select('pn.id, pn.nama_lengkap, pn.nik')
            ->like('pn.nama_lengkap', $q)
            ->orLike('pn.nik', $q)
            ->orderBy('pn.nama_lengkap', 'ASC')
            ->limit(20)
            ->get()->getResultArray();
        return $this->response->setJSON(['status' => 'ok', 'data' => $rows]);
    }

    protected function failValidationErrors($errors): ResponseInterface
    {
        return $this->response->setStatusCode(422)->setJSON(['status' => 'error', 'errors' => $errors]);
    }

    protected function failNotFound(string $message): ResponseInterface
    {
        return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => $message]);
    }
}