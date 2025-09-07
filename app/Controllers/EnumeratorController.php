<?php

namespace App\Controllers;

use App\Models\EnumeratorModel;
use CodeIgniter\Controller;

class EnumeratorController extends Controller
{

    public function __construct()
    {
        $this->enumeratorModel = new EnumeratorModel();
    }


    public function store()
    {
        $model = new EnumeratorModel();

        $data = [
            'nama'       => $this->request->getPost('nama'),
            'alamat'     => $this->request->getPost('alamat'),
            'hp_telepon' => $this->request->getPost('hp_telepon'),
        ];

        if ($model->insert($data)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Enumerator berhasil ditambahkan'
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data'
            ]);
        }
    }

    public function read()
    {
        $model = new EnumeratorModel();

        // Ambil parameter dari AJAX
        $page   = (int) $this->request->getGet('page') ?: 1;
        $search = $this->request->getGet('search') ?? '';

        $perPage = 5; // jumlah data per halaman

        // Query dasar
        $builder = $model;

        if ($search) {
            $builder = $builder->like('nama', $search)
            ->orLike('hp_telepon', $search)
            ->orLike('alamat', $search);
        }

        // Hitung total data
        $total = $builder->countAllResults(false); // false biar query tetap bisa dilanjutkan

        // Pagination manual
        $offset = ($page - 1) * $perPage;

        $data = $builder->orderBy('created_at', 'DESC')
                        ->findAll($perPage, $offset);

        // Hitung total halaman
        $totalPages = ceil($total / $perPage);

        // Kirim response JSON
        return $this->response->setJSON([
            'data'       => $data,
            'pagination' => [
                'currentPage' => $page,
                'totalPages'  => $totalPages,
                'totalData'   => $total,
                'perPage'     => $perPage
            ]
        ]);
    }

    
    // GET data enumerator by id
    public function getById($id)
    {
        $data = $this->enumeratorModel->find($id);

        if ($data) {
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $data
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Data tidak ditemukan'
        ]);
    }

    // UPDATE enumerator
    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama'       => 'required',
            'alamat'     => 'permit_empty',
            'hp_telepon' => 'permit_empty'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $validation->getErrors()
            ]);
        }

        $data = [
            'nama'       => $this->request->getPost('nama'),
            'alamat'     => $this->request->getPost('alamat'),
            'hp_telepon' => $this->request->getPost('hp_telepon'),
        ];

        $this->enumeratorModel->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui'
        ]);
    }


    public function delete($id)
{
    $data = $this->enumeratorModel->find($id);

    if (!$data) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Data tidak ditemukan'
        ]);
    }

    $this->enumeratorModel->delete($id);

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'Data berhasil dihapus'
    ]);
}

public function getEnumerators()
{
    $search = $this->request->getGet('q'); // ambil query search dari select2

    $builder = $this->enumeratorModel
        ->select('id, nama');

    if ($search) {
        $builder->like('nama', $search);
    }

    $result = $builder->findAll(10); // limit 10 hasil

    $data = [];
    foreach ($result as $row) {
        $data[] = [
            'id' => $row['id'],
            'text' => $row['nama']
        ];
    }

    return $this->response->setJSON($data);
}


}