<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MusimanModel;
use CodeIgniter\HTTP\ResponseInterface;

class PendudukMusimanController extends BaseController
{
    protected MusimanModel $model;
    protected $session;

    public function __construct()
    {
        $this->model = new MusimanModel();
        $this->session = \Config\Services::session();
    }

    private function role(): int
    {
        return (int) ($this->session->get('role') ?? 0);
    }

    private function rtId(): ?int
    {
        $rt = $this->session->get('rt_id');
        return $rt !== null ? (int) $rt : null;
    }

    private function restrictByRole($builder)
    {
        if ($this->role() === 2 && $this->rtId()) {
            $builder->where('rt_id', $this->rtId());
        }
        return $builder;
    }

    private function validatePayload(array $data, bool $isUpdate = false): array
    {
        $errors = [];
        // periode wajib
        if (empty($data['periode'])) {
            $errors['periode'] = 'Periode wajib diisi';
        }
        // rt_id wajib dan >0
        if (!isset($data['rt_id']) || !is_numeric($data['rt_id']) || (int)$data['rt_id'] <= 0) {
            $errors['rt_id'] = 'RT wajib dan harus lebih dari 0';
        }
        // penduduk_id optional tapi jika ada harus natural >0
        if (isset($data['penduduk_id']) && $data['penduduk_id'] !== '' && (!is_numeric($data['penduduk_id']) || (int)$data['penduduk_id'] <= 0)) {
            $errors['penduduk_id'] = 'Penduduk ID harus angka lebih dari 0';
        }
        return $errors;
    }

    private function checkForeignKeys(array $data): array
    {
        $errors = [];
        try {
            $db = db_connect();
            $rtOk = isset($data['rt_id']) ? (bool) $db->table('rts')->where('id', (int)$data['rt_id'])->countAllResults() : false;
            if (!$rtOk) $errors['rt_id'] = 'RT tidak valid (tidak ditemukan)';
            if (!empty($data['penduduk_id'])) {
                $pendOk = (bool) $db->table('penduduk_new')->where('id', (int)$data['penduduk_id'])->countAllResults();
                if (!$pendOk) $errors['penduduk_id'] = 'Penduduk ID tidak valid (tidak ditemukan)';
            }
        } catch (\Throwable $e) {
            log_message('error', 'FK check (API Musiman) gagal: ' . $e->getMessage());
            $errors['db'] = 'Gagal memeriksa keterkaitan data. Coba lagi.';
        }
        return $errors;
    }

    // GET /api/penduduk-musiman
    public function index(): ResponseInterface
    {
        $builder = $this->model;
        $this->restrictByRole($builder);
        $q = $this->request->getGet('q');
        if ($q) {
            $builder = $builder->groupStart()->like('periode', $q)->orLike('keterangan', $q)->groupEnd();
        }
        return $this->response->setJSON(['status' => 'ok', 'data' => $builder->orderBy('updated_at', 'DESC')->findAll()]);
    }

    // GET /api/penduduk-musiman/{id}
    public function show($id = null): ResponseInterface
    {
        if (!$id) return $this->failValidationErrors('ID wajib diisi');
        $row = $this->model->find($id);
        if (!$row) return $this->failNotFound('Data tidak ditemukan');
        if ($this->role() === 2 && $this->rtId() && (int)$row['rt_id'] !== $this->rtId()) {
            return $this->failForbidden('Tidak memiliki akses');
        }
        return $this->response->setJSON(['status' => 'ok', 'data' => $row]);
    }

    // POST /api/penduduk-musiman
    public function create(): ResponseInterface
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        // for role RT, paksa rt_id dari session
        if ($this->role() === 2) {
            $input['rt_id'] = $this->rtId();
        }
        // normalisasi numerik
        if (isset($input['penduduk_id']) && $input['penduduk_id'] !== '') $input['penduduk_id'] = (int)$input['penduduk_id'];
        if (isset($input['rt_id'])) $input['rt_id'] = (int)$input['rt_id'];
        $input['kategori'] = 'Musiman';

        $errors = $this->validatePayload($input);
        $errors = array_merge($errors, $this->checkForeignKeys($input));
        if (!empty($errors)) return $this->failValidationErrors($errors);

        if (!$this->model->insert($input)) {
            return $this->failValidationErrors($this->model->errors());
        }
        $new = $this->model->find($this->model->getInsertID());
        return $this->response->setStatusCode(201)->setJSON(['status' => 'created', 'data' => $new]);
    }

    // PUT/PATCH /api/penduduk-musiman/{id} atau tanpa ID (di body)
    public function update($id = null): ResponseInterface
    {
        $input = $this->request->getJSON(true) ?? $this->request->getRawInput();
        if (!$id) {
            $id = $input['id'] ?? null; // dukung update tanpa ID di URL
        }
        if (!$id) return $this->failValidationErrors('ID wajib diisi');

        $row = $this->model->find($id);
        if (!$row) return $this->failNotFound('Data tidak ditemukan');
        if ($this->role() === 2) {
            if (!$this->rtId() || (int)$row['rt_id'] !== $this->rtId()) return $this->failForbidden('Tidak memiliki akses');
            // pastikan rt_id tidak bisa dipindah ke RT lain
            $input['rt_id'] = $this->rtId();
        } else {
            if (isset($input['rt_id'])) $input['rt_id'] = (int)$input['rt_id'];
        }
        if (isset($input['penduduk_id']) && $input['penduduk_id'] !== '') $input['penduduk_id'] = (int)$input['penduduk_id'];

        $errors = $this->validatePayload(array_merge($row, $input), true);
        $errors = array_merge($errors, $this->checkForeignKeys(array_merge($row, $input)));
        if (!empty($errors)) return $this->failValidationErrors($errors);

        if (!$this->model->update($id, $input)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->response->setJSON(['status' => 'updated', 'data' => $this->model->find($id)]);
    }

    // POST /api/penduduk-musiman/save  (upsert: ada id = update, else create)
    public function save(): ResponseInterface
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();
        if (!empty($input['id'])) {
            return $this->update($input['id']);
        }
        return $this->create();
    }

    // DELETE /api/penduduk-musiman/{id}
    public function delete($id = null): ResponseInterface
    {
        if (!$id) return $this->failValidationErrors('ID wajib diisi');
        $row = $this->model->find($id);
        if (!$row) return $this->failNotFound('Data tidak ditemukan');
        if ($this->role() === 2 && $this->rtId() && (int)$row['rt_id'] !== $this->rtId()) {
            return $this->failForbidden('Tidak memiliki akses');
        }
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'deleted']);
    }

    protected function failValidationErrors($errors): ResponseInterface
    {
        return $this->response->setStatusCode(422)->setJSON(['status' => 'error', 'errors' => $errors]);
    }

    protected function failNotFound(string $message): ResponseInterface
    {
        return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => $message]);
    }

    protected function failForbidden(string $message): ResponseInterface
    {
        return $this->response->setStatusCode(403)->setJSON(['status' => 'error', 'message' => $message]);
    }
}