<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\EnumeratorModel;
use App\Models\PendudukModel;

class Api extends BaseController
{
    protected $enumeratorModel;
    protected $pendudukModel;

    public function __construct()
    {
        $this->enumeratorModel = new EnumeratorModel();
        $this->pendudukModel = new PendudukModel();
    }

    // GET /api/enumerators
    public function enumerators()
    {
        if (! $this->enumeratorModel->db->tableExists($this->enumeratorModel->table)) {
            return $this->response->setJSON(['status' => 'success', 'data' => []]);
        }

        $data = $this->enumeratorModel->findAll();
        return $this->response->setJSON(['status' => 'success', 'data' => $data]);
    }

    // GET /api/penduduk/{id}
    public function penduduk($id = null)
    {
        if (empty($id)) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'ID required']);
        }

        if (! $this->pendudukModel->db->tableExists($this->pendudukModel->table)) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Not found']);
        }

        $item = $this->pendudukModel->find($id);
        if (!$item) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Not found']);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $item]);
    }

    // POST /api/echo
    // Example: returns posted JSON back to caller
    public function echo()
    {
        $input = $this->request->getJSON(true);
        if (empty($input)) {
            // also accept form post
            $input = $this->request->getPost();
        }

        return $this->response->setJSON(['status' => 'success', 'received' => $input]);
    }
}
