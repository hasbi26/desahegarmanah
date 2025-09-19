<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\MusimanModel;

class Musiman extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MusimanModel();
    }

    public function index()
    {
        if (! $this->model->db->tableExists($this->model->table)) {
            return $this->response->setJSON(['data' => [], 'pagination' => ['currentPage'=>1,'perPage'=>0,'total'=>0,'totalPages'=>0]]);
        }

        $q = $this->request->getGet('q');
        $page = max(1, (int)$this->request->getGet('page'));
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $offset = ($page - 1) * $perPage;

        $builder = $this->model;
        if ($q) {
            $builder = $builder->like('periode', $q)->orLike('keterangan', $q);
        }
        $total = $builder->countAllResults(false);
        $items = $builder->orderBy('updated_at', 'DESC')->findAll($perPage, $offset);

        return $this->response->setJSON(['data'=>$items,'pagination'=>['currentPage'=>$page,'perPage'=>$perPage,'total'=>$total,'totalPages'=>ceil($total/$perPage)]]);
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
        $data = $this->request->getPost();
        $id = $this->model->insert($data, true);
        if ($id) return $this->response->setStatusCode(201)->setJSON(['status'=>'success','id'=>$id]);
        return $this->response->setStatusCode(500)->setJSON(['status'=>'error','message'=>'Failed to save']);
    }

    public function update($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $data = $this->request->getRawInput();
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
