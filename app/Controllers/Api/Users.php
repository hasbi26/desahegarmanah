<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RTModel;

class Users extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->rtModel = new RTModel();
    }

    public function index()
    {
        // if base table 'user' missing, return empty
        if (! $this->model->db->tableExists($this->model->table)) {
            return $this->response->setJSON(['data' => [], 'pagination' => ['currentPage'=>1,'perPage'=>0,'total'=>0,'totalPages'=>0]]);
        }

        $q = trim((string)($this->request->getGet('q') ?? ''));
        $page = max(1, (int)($this->request->getGet('page') ?? 1));
        $perPage = (int)($this->request->getGet('perPage') ?? 10);

        $builder = $this->model->db->table('user u')
            ->select('u.id, u.username, u.email, u.role, u.rt_id, u.is_active, r.rt, r.rw')
            ->join('rts r', 'r.id = u.rt_id', 'left');
        if ($q !== '') {
            $builder->groupStart()->like('u.username', $q)->orLike('u.email', $q)->groupEnd();
        }
    $countBuilder = clone $builder;
    $total = $countBuilder->countAllResults(false);
    $items = $builder->orderBy('u.id', 'DESC')->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

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
        $payload = $this->request->getPost();
        if (empty($payload['username']) || empty($payload['password']) || empty($payload['rt_id']) || empty($payload['role'])) {
            return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'Missing required fields']);
        }
        $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        $id = $this->model->insert($payload, true);
        return $this->response->setStatusCode($id?201:500)->setJSON($id?['status'=>'success','id'=>$id]:['status'=>'error','message'=>'Failed to save']);
    }

    public function update($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $payload = $this->request->getRawInput();
        if (isset($payload['password']) && $payload['password'] !== '') {
            $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        } else {
            unset($payload['password']);
        }
        $this->model->update($id, $payload);
        return $this->response->setJSON(['status'=>'success','message'=>'Updated']);
    }

    public function delete($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $this->model->delete($id);
        return $this->response->setJSON(['status'=>'success','message'=>'Deleted']);
    }
}
