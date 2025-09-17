<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MusimanModel;
use CodeIgniter\API\ResponseTrait;

class Musiman extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new MusimanModel();
    }

    public function index()
    {
        $q = $this->request->getGet('q');
        $page = max(1, (int) $this->request->getGet('page') ?: 1);
        $perPage = max(1, (int) $this->request->getGet('perPage') ?: 10);
        $offset = ($page - 1) * $perPage;

        $db = \Config\Database::connect();
        $builder = $db->table($this->model->table);

        // RT filter for role=2
        $session = session();
        if ($session->get('role') == 2 && $session->get('rt_id')) {
            $builder->where('rt_id', $session->get('rt_id'));
        }
        if ($q) {
            $builder->groupStart()
                    ->like('periode', $q)
                    ->orLike('keterangan', $q)
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
        // set kategori otomatis
        $data['kategori'] = 'Musiman';

        // force rt_id for Ketua RT
        $session = session();
        if ($session->get('role') == 2) {
            $data['rt_id'] = $session->get('rt_id');
        }

        if (! $this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respondCreated(['status'=>'success','message'=>'Data musiman berhasil ditambahkan','id' => (int) $this->model->getInsertID()]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (! $this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        // pastikan kategori tetap Musiman
        $data['kategori'] = 'Musiman';

        // Role-based restriction
        $session = session();
        $existing = $this->model->find($id);
        if ($session->get('role') == 2) {
            if (!isset($existing['rt_id']) || $existing['rt_id'] != $session->get('rt_id')) {
                return $this->failForbidden('Akses ditolak');
            }
            $data['rt_id'] = $session->get('rt_id');
        }

        if (! $this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond(['status'=>'success','message'=>'Data musiman berhasil diperbarui']);
    }

    public function delete($id = null)
    {
        if (! $this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['status'=>'success','message'=>'Data musiman berhasil dihapus']);
    }
}
