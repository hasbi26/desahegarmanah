<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MusimanModel;

class MusimanApi extends BaseController
{
    protected $musimanModel;
    protected $session;

    public function __construct()
    {
        $this->musimanModel = new MusimanModel();
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

    // GET /api/musiman?q=&page=&perPage=
    public function index()
    {
        $q       = $this->request->getGet('q');
        $page    = max(1, (int) $this->request->getGet('page')) ?: 1;
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $offset  = ($page - 1) * $perPage;

        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);

        if ($q) {
            $builder = $builder->groupStart()
                ->like('periode', $q)
                ->orLike('keterangan', $q)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $items = $builder->orderBy('updated_at', 'DESC')->findAll($perPage, $offset);

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

    // GET /api/musiman/{id}
    public function show($id)
    {
        $item = $this->musimanModel->find($id);
        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak memiliki akses',
            ]);
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $item]);
    }

    // POST /api/musiman
    public function store()
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!is_array($input)) $input = [];

        $role = (int) $this->session->get('role');
        $data = [
            'penduduk_id'          => $input['penduduk_id'] ?? null,
            'periode'              => $input['periode'] ?? null,
            'keterangan'           => $input['keterangan'] ?? null,
            'nama_perguruan_tinggi'=> $input['nama_perguruan_tinggi'] ?? null,
            'nama_perusahaan'      => $input['nama_perusahaan'] ?? null,
            'alamat_tempat_jualan' => $input['alamat_tempat_jualan'] ?? null,
            'alasan_lainnya'       => $input['alasan_lainnya'] ?? null,
            'nama_pondokan'        => $input['nama_pondokan'] ?? null,
            'alamat_pondokan'      => $input['alamat_pondokan'] ?? null,
            'no_telp'              => $input['no_telp'] ?? null,
            'alamat_asal'          => $input['alamat_asal'] ?? null,
            'kategori'             => 'Musiman',
            'rt_id'                => ($role === 2) ? $this->session->get('rt_id') : ($input['rt_id'] ?? null),
        ];

        $rules = [
            'rt_id'   => 'required|integer',
            'periode' => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getErrors(),
            ]);
        }

        $id = $this->musimanModel->insert($data, true);
        return $this->response->setStatusCode(201)->setJSON([
            'status'  => 'success',
            'message' => 'Data musiman berhasil ditambahkan',
            'id'      => $id,
        ]);
    }

    // PUT /api/musiman/{id}
    public function update($id)
    {
        $item = $this->musimanModel->find($id);
        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak memiliki akses',
            ]);
        }

        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!is_array($input)) $input = [];

        $update = [
            'penduduk_id'          => $input['penduduk_id'] ?? $item['penduduk_id'] ?? null,
            'periode'              => $input['periode'] ?? $item['periode'] ?? null,
            'keterangan'           => $input['keterangan'] ?? $item['keterangan'] ?? null,
            'nama_perguruan_tinggi'=> $input['nama_perguruan_tinggi'] ?? $item['nama_perguruan_tinggi'] ?? null,
            'nama_perusahaan'      => $input['nama_perusahaan'] ?? $item['nama_perusahaan'] ?? null,
            'alamat_tempat_jualan' => $input['alamat_tempat_jualan'] ?? $item['alamat_tempat_jualan'] ?? null,
            'alasan_lainnya'       => $input['alasan_lainnya'] ?? $item['alasan_lainnya'] ?? null,
            'nama_pondokan'        => $input['nama_pondokan'] ?? $item['nama_pondokan'] ?? null,
            'alamat_pondokan'      => $input['alamat_pondokan'] ?? $item['alamat_pondokan'] ?? null,
            'no_telp'              => $input['no_telp'] ?? $item['no_telp'] ?? null,
            'alamat_asal'          => $input['alamat_asal'] ?? $item['alamat_asal'] ?? null,
        ];
        if ($role === 2) $update['rt_id'] = $this->session->get('rt_id');

        $this->musimanModel->update($id, $update);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data musiman berhasil diperbarui',
        ]);
    }

    // DELETE /api/musiman/{id}
    public function delete($id)
    {
        $item = $this->musimanModel->find($id);
        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Tidak memiliki akses',
            ]);
        }
        $this->musimanModel->delete($id);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data musiman berhasil dihapus',
        ]);
    }
}