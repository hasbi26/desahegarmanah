<?php

namespace App\Controllers;

use App\Models\MusimanModel;
use App\Models\PendudukIntiModel;

class MusimanController extends BaseController
{
    protected $musimanModel;
    protected $pendudukModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->musimanModel = new MusimanModel();
        $this->pendudukModel = new PendudukIntiModel();
        $this->session = \Config\Services::session();
    }

    private function restrictBuilderByRole($builder)
    {
        $role = (int) $this->session->get('role');
        $rtId = $this->session->get('rt_id');
        if ($role === 2 && $rtId) {
            $builder->where('rt_id', $rtId);
        }
        return $builder;
    }

    public function index()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');

        $q = $this->request->getGet('q');
        $page = max(1, (int) $this->request->getGet('page'));
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);
        if ($q) {
            $builder = $builder->like('periode', $q)
                ->orLike('keterangan', $q);
        }
        $total = $builder->countAllResults(false);
        $items = $builder->orderBy('updated_at', 'DESC')->findAll($perPage, $offset);

        return view('musiman/index', [
            'title' => 'Data Penduduk Musiman',
            'items' => $items,
            'q' => $q,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => (int) ceil($total / $perPage),
        ]);
    }

    public function create()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        return view('musiman/form', ['title' => 'Tambah Musiman', 'item' => null]);
    }

    public function store()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $data = $this->request->getPost([
            'penduduk_id',
            'periode',
            'keterangan',
            'nama_perguruan_tinggi',
            'nama_perusahaan',
            'alamat_tempat_jualan',
            'alasan_lainnya',
            'nama_pondokan',
            'alamat_pondokan',
            'no_telp',
            'alamat_asal'
        ]);

        $role = (int) $this->session->get('role');
        $data['rt_id'] = ($role === 2) ? $this->session->get('rt_id') : (int) $this->request->getPost('rt_id');
        $data['kategori'] = 'Musiman';

        $rules = [
            'rt_id' => 'required|integer',
            'periode' => 'required',
        ];
        if (!$this->validate($rules)) return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $this->musimanModel->insert($data);
        return redirect()->to(base_url('musiman'))->with('success', 'Data musiman berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $item = $this->musimanModel->find($id);
        if (!$item) return redirect()->to('musiman')->with('error', 'Data tidak ditemukan');
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return redirect()->to('musiman')->with('error', 'Tidak memiliki akses');
        }
        return view('musiman/form', ['title' => 'Edit Musiman', 'item' => $item]);
    }

    public function update($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $item = $this->musimanModel->find($id);
        if (!$item) return redirect()->to('musiman')->with('error', 'Data tidak ditemukan');
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return redirect()->to('musiman')->with('error', 'Tidak memiliki akses');
        }
        $data = $this->request->getPost([
            'penduduk_id',
            'periode',
            'keterangan',
            'nama_perguruan_tinggi',
            'nama_perusahaan',
            'alamat_tempat_jualan',
            'alasan_lainnya',
            'nama_pondokan',
            'alamat_pondokan',
            'no_telp',
            'alamat_asal'
        ]);
        if ($role === 2) $data['rt_id'] = $this->session->get('rt_id');
        $this->musimanModel->update($id, $data);
        return redirect()->to(base_url('musiman'))->with('success', 'Data musiman berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $item = $this->musimanModel->find($id);
        if (!$item) return redirect()->to('musiman')->with('error', 'Data tidak ditemukan');
        $role = (int) $this->session->get('role');
        if ($role === 2 && (int)$item['rt_id'] !== (int)$this->session->get('rt_id')) {
            return redirect()->to('musiman')->with('error', 'Tidak memiliki akses');
        }
        $this->musimanModel->delete($id);
        return redirect()->to(base_url('musiman'))->with('success', 'Data musiman berhasil dihapus');
    }

    public function exportPdf()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);
        $items = $builder->orderBy('periode', 'ASC')->findAll();
        $html = view('musiman/pdf', ['items' => $items]);
        if (!class_exists('Dompdf\\Dompdf')) return $this->response->setBody($html);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $this->response->setHeader('Content-Type', 'application/pdf')->setBody($dompdf->output());
    }

    public function exportExcel()
    {
        if (!$this->session->get('logged_in')) return redirect()->to('/');
        $builder = $this->musimanModel;
        $this->restrictBuilderByRole($builder);
        $items = $builder->orderBy('periode', 'ASC')->findAll();

        $filename = 'musiman.csv';
        $headers = ['RT ID', 'PENDUDUK ID', 'PERIODE', 'KETERANGAN'];
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, $headers);
        foreach ($items as $i) {
            fputcsv($csv, [$i['rt_id'], $i['penduduk_id'], $i['periode'], $i['keterangan']]);
        }
        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);
        return $this->response->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }
}
