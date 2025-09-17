<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PendudukModel;
use CodeIgniter\API\ResponseTrait;

class Penduduk extends BaseController
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new PendudukModel();
    }

    // GET /api/penduduk?q=&page=1&perPage=10
    public function index()
    {
        $q = $this->request->getGet('q');
        $page = max(1, (int) $this->request->getGet('page') ?: 1);
        $perPage = max(1, (int) $this->request->getGet('perPage') ?: 10);
        $offset = ($page - 1) * $perPage;

        $db = \Config\Database::connect();
        $builder = $db->table($this->model->table);

        // Apply RT filter for role=2
        $session = session();
        $role = $session->get('role');
        $sessionRt = $session->get('rt_id');
        if ($role == 2 && $sessionRt) {
            $builder->where('rt_id', $sessionRt);
        }

        if ($q) {
            $builder->groupStart()
                    ->like('nama_lengkap', $q)
                    ->orLike('nik', $q)
                    ->orLike('no_kk', $q)
                    ->orLike('alamat', $q)
                    ->groupEnd();
        }

        $total = (int) $builder->countAllResults(false);
        $rows  = $builder->limit($perPage, $offset)->get()->getResultArray();

        $payload = [
            'status'     => 'success',
            'data'       => $rows,
            'pagination' => [
                'page'       => $page,
                'perPage'    => $perPage,
                'total'      => $total,
                'totalPages' => $perPage ? (int) ceil($total / $perPage) : 0,
            ],
        ];

        return $this->respond($payload);
    }

    // GET /api/penduduk/{id}
    public function show($id = null)
    {
        $item = $this->model->find($id);
        if (! $item) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        // Role-based RT access
        $session = session();
        if ($session->get('role') == 2 && $session->get('rt_id') && isset($item['rt_id']) && $item['rt_id'] != $session->get('rt_id')) {
            return $this->failForbidden('Akses ditolak');
        }

        return $this->respond(['status' => 'success', 'data' => $item]);
    }

    // POST /api/penduduk (JSON)
    public function create()
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        // If user role is Ketua RT (2), force rt_id to session rt_id
        $session = session();
        if ($session->get('role') == 2) {
            $data['rt_id'] = $session->get('rt_id');
        }

        if (! $this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        $id = $this->model->getInsertID();

        return $this->respondCreated(['status' => 'success', 'message' => 'Data penduduk berhasil ditambahkan', 'id' => (int) $id]);
    }

    // PUT /api/penduduk/{id} (JSON)
    public function update($id = null)
    {
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (! $this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        // Role-based RT restriction
        $session = session();
        $existing = $this->model->find($id);
        if ($session->get('role') == 2) {
            if (!isset($existing['rt_id']) || $existing['rt_id'] != $session->get('rt_id')) {
                return $this->failForbidden('Akses ditolak');
            }
            // Force rt_id to session
            $data['rt_id'] = $session->get('rt_id');
        }

        if (! $this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond(['status' => 'success', 'message' => 'Data penduduk berhasil diperbarui']);
    }

    // DELETE /api/penduduk/{id}
    public function delete($id = null)
    {
        if (! $this->model->find($id)) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $this->model->delete($id);

        return $this->respondDeleted(['status' => 'success', 'message' => 'Data penduduk berhasil dihapus']);
    }
}
