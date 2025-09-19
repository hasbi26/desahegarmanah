<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AksesKesehatanModel;
use CodeIgniter\HTTP\ResponseInterface;

class AksesKesehatanController extends BaseController
{
    protected AksesKesehatanModel $model;

    public function __construct()
    {
        $this->model = new AksesKesehatanModel();
    }

    // GET /api/akses-kesehatan
    public function index(): ResponseInterface
    {
        $data = $this->model->findAll();
        return $this->response->setJSON(['status' => 'ok', 'data' => $data]);
    }

    // GET /api/akses-kesehatan/{id}
    public function show($id = null): ResponseInterface
    {
        if (!$id) {
            return $this->failValidationErrors('ID wajib diisi');
        }
        $row = $this->model->find($id);
        if (!$row) {
            return $this->failNotFound('Data tidak ditemukan');
        }
        return $this->response->setJSON(['status' => 'ok', 'data' => $row]);
    }

    // POST /api/akses-kesehatan
    public function create(): ResponseInterface
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!$this->model->insert($input)) {
            return $this->failValidationErrors($this->model->errors());
        }
        $id = $this->model->getInsertID();
        $new = $this->model->find($id);
        return $this->response->setStatusCode(201)->setJSON(['status' => 'created', 'data' => $new]);
    }

    // PUT/PATCH /api/akses-kesehatan/{id}
    public function update($id = null): ResponseInterface
    {
        if (!$id) {
            return $this->failValidationErrors('ID wajib diisi');
        }
        $input = $this->request->getJSON(true) ?? $this->request->getRawInput();
        if (!$this->model->update($id, $input)) {
            return $this->failValidationErrors($this->model->errors());
        }
        $updated = $this->model->find($id);
        return $this->response->setJSON(['status' => 'updated', 'data' => $updated]);
    }

    // DELETE /api/akses-kesehatan/{id}
    public function delete($id = null): ResponseInterface
    {
        if (!$id) {
            return $this->failValidationErrors('ID wajib diisi');
        }
        $row = $this->model->find($id);
        if (!$row) {
            return $this->failNotFound('Data tidak ditemukan');
        }
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'deleted']);
    }

    // Helpers for errors
    protected function failValidationErrors($errors): ResponseInterface
    {
        return $this->response->setStatusCode(422)->setJSON(['status' => 'error', 'errors' => $errors]);
    }

    protected function failNotFound(string $message): ResponseInterface
    {
        return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => $message]);
    }
}