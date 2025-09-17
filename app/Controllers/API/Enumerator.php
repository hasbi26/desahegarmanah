<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\EnumeratorModel;

class Enumerator extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new EnumeratorModel();
    }

    public function index()
    {
        // If the underlying table doesn't exist yet (fresh DB), return empty result
        if (! $this->model->db->tableExists($this->model->table)) {
            return $this->response->setJSON(['data' => [], 'pagination' => ['currentPage'=>1,'perPage'=>0,'total'=>0,'totalPages'=>0]]);
        }

        $page = max(1, (int)$this->request->getGet('page'));
        $search = $this->request->getGet('search') ?? '';
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $offset = ($page - 1) * $perPage;

        $builder = $this->model;
        if ($search) {
            $builder = $builder->like('nama', $search)->orLike('hp_telepon', $search)->orLike('alamat', $search);
        }
        // Use countAllResults(false) only on builder instances; ensure we have a fresh builder
        $countBuilder = clone $builder;
        $total = $countBuilder->countAllResults(false);
        $data = $builder->orderBy('created_at', 'DESC')->findAll($perPage, $offset);

        return $this->response->setJSON(['data' => $data, 'pagination' => ['currentPage'=>$page,'perPage'=>$perPage,'total'=>$total,'totalPages'=>ceil($total/$perPage)]]);
    }

    public function show($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $row = $this->model->find($id);
        if (!$row) return $this->response->setStatusCode(404)->setJSON(['status'=>'error','message'=>'Not found']);
        return $this->response->setJSON(['status'=>'success','data'=>$row]);
    }

    public function store()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'hp_telepon' => $this->request->getPost('hp_telepon'),
        ];
        $id = $this->model->insert($data, true);
        if ($id) return $this->response->setStatusCode(201)->setJSON(['status'=>'success','id'=>$id]);
        return $this->response->setStatusCode(500)->setJSON(['status'=>'error','message'=>'Failed to save']);
    }

    public function update($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'hp_telepon' => $this->request->getPost('hp_telepon'),
        ];
        $this->model->update($id, $data);
        return $this->response->setJSON(['status'=>'success','message'=>'Updated']);
    }

    public function delete($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $this->model->delete($id);
        return $this->response->setJSON(['status'=>'success','message'=>'Deleted']);
    }
}
