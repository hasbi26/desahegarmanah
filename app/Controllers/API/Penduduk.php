<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Models\PendudukIntiModel;
use App\Models\PendudukMutasiModel;
use App\Models\PendudukTinggalModel;
use App\Models\RumahTanggaModel;
use App\Models\RTModel;

class Penduduk extends BaseController
{
    protected $intiModel;
    protected $mutasiModel;
    protected $tinggalModel;
    protected $rumahModel;
    protected $rtModel;

    public function __construct()
    {
        $this->intiModel = new PendudukIntiModel();
        $this->mutasiModel = new PendudukMutasiModel();
        $this->tinggalModel = new PendudukTinggalModel();
        $this->rumahModel = new RumahTanggaModel();
        $this->rtModel = new RTModel();
    }

    // GET /api/penduduk?page=1&q=...
    public function index()
    {
        // Guard: if the main table doesn't exist yet, return empty
        if (! $this->intiModel->db->tableExists($this->intiModel->table)) {
            return $this->response->setJSON(['data' => [], 'pagination' => ['currentPage'=>1,'perPage'=>0,'total'=>0,'totalPages'=>0]]);
        }

        $q = $this->request->getGet('q');
        $page = max(1, (int)$this->request->getGet('page'));
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        $offset = ($page - 1) * $perPage;

        $builder = $this->intiModel->select('penduduk_new.*, penduduk_tinggal.rt_id')
            ->join('penduduk_tinggal', 'penduduk_tinggal.penduduk_id = penduduk_new.id', 'left');

        if ($q) {
            $builder = $builder->groupStart()
                ->like('penduduk_new.nama_lengkap', $q)
                ->orLike('penduduk_new.nik', $q)
                ->orLike('penduduk_new.no_kk', $q)
                ->orLike('penduduk_new.alamat', $q)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $items = $builder->orderBy('penduduk_new.updated_at', 'DESC')->findAll($perPage, $offset);

        return $this->response->setJSON([
            'data' => $items,
            'pagination' => [
                'currentPage' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => (int)ceil($total / $perPage),
            ]
        ]);
    }

    // GET /api/penduduk/(:num)
    public function show($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'ID required']);
        $inti = $this->intiModel->find($id);
        if (!$inti) return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Not found']);
        $tinggal = $this->tinggalModel->where('penduduk_id', $id)->first() ?? [];
        $mutasi = $this->mutasiModel->where('penduduk_id', $id)->first() ?? [];
        $rumah = $this->rumahModel->where('penduduk_id', $id)->first() ?? [];

        return $this->response->setJSON(['status' => 'success', 'data' => array_merge($inti, $tinggal, $mutasi, $rumah)]);
    }

    // POST /api/penduduk
    public function store()
    {
        $inti = $this->request->getPost([
            'nama_lengkap','nik','no_kk','tempat_lahir','tanggal_lahir','jenis_kelamin','pendidikan','status_perkawinan','agama','pekerjaan','alamat'
        ]);
        $mutasi = $this->request->getPost(['kelahiran','pendatang','kematian','pindah']);
        $tinggal = $this->request->getPost(['rt_id','status_rumah','luas_tanah','luas_bangunan']);
        $rumah = $this->request->getPost(['air','listrik','sampah','limbah']);

        foreach (['kelahiran','pendatang','kematian','pindah'] as $f) {
            $mutasi[$f] = isset($mutasi[$f]) ? 1 : 0;
        }

        // Basic validation
        if (empty($inti['nama_lengkap']) || empty($inti['nik']) || empty($tinggal['rt_id'])) {
            return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'Missing required fields']);
        }

    $db = \Config\Database::connect();
        $db->transStart();
        $pendudukId = $this->intiModel->insert($inti, true);
        $mutasi['penduduk_id'] = $pendudukId;
        $this->mutasiModel->insert($mutasi);
        $tinggal['penduduk_id'] = $pendudukId;
        $this->tinggalModel->insert($tinggal);
        $rumah['penduduk_id'] = $pendudukId;
        $this->rumahModel->insert($rumah);
        $db->transComplete();

        if (!$db->transStatus()) {
            return $this->response->setStatusCode(500)->setJSON(['status'=>'error','message'=>'Failed to save']);
        }

        return $this->response->setStatusCode(201)->setJSON(['status'=>'success','id'=>$pendudukId]);
    }

    // PUT /api/penduduk/(:num)
    public function update($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $inti = $this->request->getRawInput();
        $this->intiModel->update($id, $inti);
        return $this->response->setJSON(['status'=>'success','message'=>'Updated']);
    }

    // DELETE /api/penduduk/(:num)
    public function delete($id = null)
    {
        if (!$id) return $this->response->setStatusCode(400)->setJSON(['status'=>'error','message'=>'ID required']);
        $this->intiModel->delete($id);
        return $this->response->setJSON(['status'=>'success','message'=>'Deleted']);
    }
}
