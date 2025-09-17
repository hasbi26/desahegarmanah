<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\EnumeratorModel;
use CodeIgniter\API\ResponseTrait;

class Enumerator extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new EnumeratorModel();
    }

    public function index()
    {
        $q = $this->request->getGet('q');
        $page = max(1, (int) $this->request->getGet('page') ?: 1);
        $perPage = max(1, (int) $this->request->getGet('perPage') ?: 10);
        $offset = ($page - 1) * $perPage;

        $db = \Config\Database::connect();
        $builder = $db->table($this->model->table);

        if ($q) {
            $builder->groupStart()
                    ->like('nama', $q)
                    ->orLike('hp_telepon', $q)
                    ->orLike('alamat', $q)
                    ->groupEnd();
        }

        $total = (int) $builder->countAllResults(false);
        $rows  = $builder->limit($perPage, $offset)->get()->getResultArray();

        return $this->respond([
            'status' => 'success',
            'data' => $rows,
            'pagination' => [
                'page' => $page, 'perPage' => $perPage,
                'total' => $total, 'totalPages' => (int) ceil($total / $perPage)
            ],
        ]);
    }

    public function show($id = null)
    {
        $item = $this->model->find($id);
        if (! $item) {
            return $this->failNotFound('Data tidak ditemukan');
        }
        return $this->respond(['status' => 'success', 'data' => $item]);
    }

    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        if (! $this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondCreated(['status'=>'success','message'=>'Enumerator berhasil ditambahkan','id' => (int) $this->model->getInsertID()]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (! $this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        if (! $this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond(['status'=>'success','message'=>'Data berhasil diperbarui']);
    }

    public function delete($id = null)
    {
        if (! $this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['status'=>'success','message'=>'Data berhasil dihapus']);
    }

    // GET /api/enumerator/options?q=
    public function options()
    {
        $q = $this->request->getGet('q');
        $db = \Config\Database::connect();
        $builder = $db->table($this->model->table)->select('id, nama');

        if ($q) {
            $builder->like('nama', $q);
        }

        $rows = $builder->limit(20)->get()->getResultArray();

        $out = array_map(function ($r) {
            return ['id' => (int) $r['id'], 'text' => $r['nama']];
        }, $rows);

        return $this->respond($out);
    }
}
