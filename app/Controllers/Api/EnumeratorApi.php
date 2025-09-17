<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\EnumeratorModel;

class EnumeratorApi extends BaseController
{
    protected $enumeratorModel;

    public function __construct()
    {
        $this->enumeratorModel = new EnumeratorModel();
    }

    // GET /api/enumerators?q=&page=&perPage=
    public function index()
    {
        $q       = $this->request->getGet('q') ?? '';
        $page    = max(1, (int) $this->request->getGet('page')) ?: 1;
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $offset  = ($page - 1) * $perPage;

        $builder = $this->enumeratorModel;
        if ($q) {
            $builder = $builder->groupStart()
                ->like('nama', $q)
                ->orLike('hp_telepon', $q)
                ->orLike('alamat', $q)
                ->groupEnd();
        }
        $total = $builder->countAllResults(false);
        $data  = $builder->orderBy('created_at', 'DESC')->findAll($perPage, $offset);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => (int) ceil($total / $perPage),
            ],
        ]);
    }

    // GET /api/enumerators/{id}
    public function show($id)
    {
        $data = $this->enumeratorModel->find($id);
        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $data]);
    }

    // POST /api/enumerators
    public function store()
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!is_array($input)) $input = [];

        $data = [
            'nama'       => $input['nama'] ?? null,
            'alamat'     => $input['alamat'] ?? null,
            'hp_telepon' => $input['hp_telepon'] ?? null,
        ];

        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getErrors(),
            ]);
        }

        $id = $this->enumeratorModel->insert($data, true);
        return $this->response->setStatusCode(201)->setJSON([
            'status'  => 'success',
            'message' => 'Enumerator berhasil ditambahkan',
            'id'      => $id,
        ]);
    }

    // PUT /api/enumerators/{id}
    public function update($id)
    {
        $exists = $this->enumeratorModel->find($id);
        if (!$exists) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!is_array($input)) $input = [];

        $data = [
            'nama'       => $input['nama'] ?? $exists['nama'] ?? null,
            'alamat'     => $input['alamat'] ?? $exists['alamat'] ?? null,
            'hp_telepon' => $input['hp_telepon'] ?? $exists['hp_telepon'] ?? null,
        ];

        $rules = ['nama' => 'required'];
        if (!$this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => $this->validator->getErrors(),
            ]);
        }

        $this->enumeratorModel->update($id, $data);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui',
        ]);
    }

    // DELETE /api/enumerators/{id}
    public function delete($id)
    {
        $exists = $this->enumeratorModel->find($id);
        if (!$exists) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }
        $this->enumeratorModel->delete($id);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data berhasil dihapus',
        ]);
    }

    // GET /api/enumerators/options?q= (untuk select2)
    public function options()
    {
        $search = $this->request->getGet('q');
        $builder = $this->enumeratorModel->select('id, nama');
        if ($search) $builder->like('nama', $search);
        $result = $builder->findAll(10);
        $data = [];
        foreach ($result as $row) {
            $data[] = ['id' => $row['id'], 'text' => $row['nama']];
        }
        return $this->response->setJSON($data);
    }
}