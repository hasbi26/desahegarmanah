<?php
namespace App\Controllers;

use App\Models\EnumeratorModel;
use App\Models\LokasiModel;
use App\Models\KeluargaModel;
use App\Models\PermukimanModel;
use App\Models\AksesPendidikanModel;
use App\Models\AksesKesehatanModel;
use App\Models\AksesTenagaKesehatanModel;
use App\Models\AksesTransportasiModel;
use App\Models\ProgramPemerintahModel;

class KuesionerController extends BaseController
{
    protected $enumeratorModel;
    protected $lokasiModel;
    protected $keluargaModel;
    protected $permukimanModel;
    protected $aksesPendidikanModel;
    protected $aksesKesehatanModel;
    protected $aksesTenagaKesehatanModel;
    protected $aksesTransportasiModel;
    protected $programPemerintahModel;

    public function __construct()
    {
        $this->enumeratorModel = new EnumeratorModel();
        $this->lokasiModel = new LokasiModel();
        $this->keluargaModel = new KeluargaModel();
        $this->permukimanModel = new PermukimanModel();
        $this->aksesPendidikanModel = new AksesPendidikanModel();
        $this->aksesKesehatanModel = new AksesKesehatanModel();
        $this->aksesTenagaKesehatanModel = new AksesTenagaKesehatanModel();
        $this->aksesTransportasiModel = new AksesTransportasiModel();
        $this->programPemerintahModel = new ProgramPemerintahModel();
        
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Kuesioner SDGS',
            'enumerators' => $this->enumeratorModel->findAll()
        ];
        return view('kuesioner/index', $data);
    }

    public function getData()
    {
        $request = service('request');
        $search = $request->getPost('search')['value'];
        $order = $request->getPost('order');
        $limit = $request->getPost('length');
        $offset = $request->getPost('start');
        
        // Query utama dengan join
        $builder = $this->keluargaModel->builder();
        $builder->select('
            keluarga.id,
            keluarga.nomor_kk,
            keluarga.nik_kepala_keluarga,
            lokasi.provinsi,
            lokasi.kabupaten_kota,
            lokasi.kecamatan,
            lokasi.desa,
            enumerator.nama as enumerator_nama
        ');
        $builder->join('lokasi', 'lokasi.id = keluarga.lokasi_id');
        $builder->join('enumerator', 'enumerator.id = keluarga.enumerator_id');
        
        // Pencarian
        if (!empty($search)) {
            $builder->groupStart()
                ->like('keluarga.nomor_kk', $search)
                ->orLike('keluarga.nik_kepala_keluarga', $search)
                ->orLike('lokasi.provinsi', $search)
                ->orLike('lokasi.kabupaten_kota', $search)
                ->orLike('lokasi.kecamatan', $search)
                ->orLike('lokasi.desa', $search)
                ->orLike('enumerator.nama', $search)
            ->groupEnd();
        }
        
        // Jumlah total data
        $totalRecords = $builder->countAllResults(false);
        
        // Pengurutan
        if (!empty($order)) {
            $columns = [
                'keluarga.nomor_kk',
                'keluarga.nik_kepala_keluarga',
                'lokasi.provinsi',
                'lokasi.kabupaten_kota',
                'lokasi.kecamatan',
                'lokasi.desa',
                'enumerator.nama'
            ];
            $builder->orderBy($columns[$order[0]['column']], $order[0]['dir']);
        }
        
        // Pagination
        if ($limit != -1) {
            $builder->limit($limit, $offset);
        }
        
        $data = $builder->get()->getResultArray();
        
        // Format data untuk DataTables
        $result = [
            "draw" => $request->getPost('draw'),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ];
        
        return $this->response->setJSON($result);
    }

    public function create()
    {
        // Jika request AJAX, kembalikan hanya formnya saja

        if ($this->request->isAJAX()) {
            

            $data = [
                'fields_enumerators' => $this->enumeratorModel->db->getFieldNames('enumerator'),
                'fields_lokasi' => $this->lokasiModel->db->getFieldNames('lokasi'),
                'fields_keluarga' => $this->keluargaModel->db->getFieldNames('keluarga'),

                'validation' => \Config\Services::validation(),
                'is_modal' => true // Flag untuk mengetahui ini modal
            ];

            return $this->response->setJSON($data);
           
        }
        
        // Jika bukan AJAX, kembalikan halaman lengkap (fallback)
        $data = [
            'title' => 'Tambah Kuesioner Baru',
            'enumerators' => $this->enumeratorModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('kuesioner/form', $data);
    }

    public function edit($id)
    {
        $keluarga = $this->keluargaModel->find($id);
        if (!$keluarga) {
            return redirect()->to('/kuesioner')->with('error', 'Data tidak ditemukan.');
        }
        
        $lokasi = $this->lokasiModel->find($keluarga['lokasi_id']);
        $permukiman = $this->permukimanModel->where('keluarga_id', $id)->first();
        
        $data = [
            'title' => 'Edit Kuesioner',
            'keluarga' => $keluarga,
            'lokasi' => $lokasi,
            'permukiman' => $permukiman,
            'enumerators' => $this->enumeratorModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        
        return view('kuesioner/form', $data);
    }

    public function save()
    {
        // Validasi input
        $rules = [
            'nomor_kk' => 'required|max_length[20]',
            'nik_kepala_keluarga' => 'required|max_length[16]',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'enumerator_id' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Simpan data lokasi
            $lokasiData = [
                'provinsi' => $this->request->getPost('provinsi'),
                'kabupaten_kota' => $this->request->getPost('kabupaten_kota'),
                'kecamatan' => $this->request->getPost('kecamatan'),
                'desa' => $this->request->getPost('desa'),
                'rt_rw' => $this->request->getPost('rt_rw'),
                'nama_responden' => $this->request->getPost('nama_responden'),
                'alamat_responden' => $this->request->getPost('alamat_responden'),
                'nomor_hp' => $this->request->getPost('nomor_hp'),
                'nomor_telepon_rumah' => $this->request->getPost('nomor_telepon_rumah')
            ];
            
            if ($this->request->getPost('lokasi_id')) {
                $lokasiId = $this->request->getPost('lokasi_id');
                $this->lokasiModel->update($lokasiId, $lokasiData);
            } else {
                $this->lokasiModel->insert($lokasiData);
                $lokasiId = $this->lokasiModel->getInsertID();
            }
            
            // Simpan data keluarga
            $keluargaData = [
                'nomor_kk' => $this->request->getPost('nomor_kk'),
                'nik_kepala_keluarga' => $this->request->getPost('nik_kepala_keluarga'),
                'lokasi_id' => $lokasiId,
                'enumerator_id' => $this->request->getPost('enumerator_id')
            ];
            
            if ($this->request->getPost('keluarga_id')) {
                $keluargaId = $this->request->getPost('keluarga_id');
                $this->keluargaModel->update($keluargaId, $keluargaData);
            } else {
                $this->keluargaModel->insert($keluargaData);
                $keluargaId = $this->keluargaModel->getInsertID();
            }
            
            // Simpan data permukiman
            $permukimanData = [
                'keluarga_id' => $keluargaId,
                'tempat_tinggal' => $this->request->getPost('tempat_tinggal'),
                'status_lahan' => $this->request->getPost('status_lahan'),
                'luas_lantai' => $this->request->getPost('luas_lantai'),
                'luas_lahan' => $this->request->getPost('luas_lahan'),
                'jenis_lantai' => $this->request->getPost('jenis_lantai'),
                'jenis_dinding' => $this->request->getPost('jenis_dinding'),
                'jendela' => $this->request->getPost('jendela'),
                'atap' => $this->request->getPost('atap'),
                'penerangan' => $this->request->getPost('penerangan'),
                'energi_masak' => $this->request->getPost('energi_masak'),
                'sumber_kayu_bakar' => $this->request->getPost('sumber_kayu_bakar'),
                'pembuangan_sampah' => $this->request->getPost('pembuangan_sampah'),
                'fasilitas_mck' => $this->request->getPost('fasilitas_mck'),
                'sumber_air_mandi' => $this->request->getPost('sumber_air_mandi'),
                'fasilitas_bab' => $this->request->getPost('fasilitas_bab'),
                'sumber_air_minum' => $this->request->getPost('sumber_air_minum'),
                'pembuangan_limbah_cair' => $this->request->getPost('pembuangan_limbah_cair'),
                'bawah_sutet' => $this->request->getPost('bawah_sutet'),
                'bantaran_sungai' => $this->request->getPost('bantaran_sungai'),
                'lereng_bukit' => $this->request->getPost('lereng_bukit'),
                'kondisi_rumah' => $this->request->getPost('kondisi_rumah')
            ];
            
            if ($this->request->getPost('permukiman_id')) {
                $permukimanId = $this->request->getPost('permukiman_id');
                $this->permukimanModel->update($permukimanId, $permukimanData);
            } else {
                $this->permukimanModel->insert($permukimanData);
                $permukimanId = $this->permukimanModel->getInsertID();
            }
            
            // Simpan data akses pendidikan (jika ada)
            $fasilitasPendidikan = $this->request->getPost('fasilitas_pendidikan');
            if (!empty($fasilitasPendidikan)) {
                $this->aksesPendidikanModel->where('permukiman_id', $permukimanId)->delete();
                
                foreach ($fasilitasPendidikan as $fp) {
                    if (!empty($fp['fasilitas'])) {
                        $this->aksesPendidikanModel->insert([
                            'permukiman_id' => $permukimanId,
                            'fasilitas' => $fp['fasilitas'],
                            'jarak_km' => $fp['jarak_km'],
                            'waktu_tempuh_jam' => $fp['waktu_tempuh_jam'],
                            'kemudahan' => $fp['kemudahan']
                        ]);
                    }
                }
            }
            
            // Simpan data akses kesehatan (jika ada)
            $fasilitasKesehatan = $this->request->getPost('fasilitas_kesehatan');
            if (!empty($fasilitasKesehatan)) {
                $this->aksesKesehatanModel->where('permukiman_id', $permukimanId)->delete();
                
                foreach ($fasilitasKesehatan as $fk) {
                    if (!empty($fk['fasilitas'])) {
                        $this->aksesKesehatanModel->insert([
                            'permukiman_id' => $permukimanId,
                            'fasilitas' => $fk['fasilitas'],
                            'jarak_km' => $fk['jarak_km'],
                            'waktu_tempuh_jam' => $fk['waktu_tempuh_jam'],
                            'kemudahan' => $fk['kemudahan']
                        ]);
                    }
                }
            }
            
            // Simpan data program pemerintah
            $programPemerintah = $this->request->getPost('program_pemerintah');
            if ($programPemerintah) {
                $programData = [
                    'permukiman_id' => $permukimanId,
                    'blt_dana_desa' => $programPemerintah['blt_dana_desa'] ?? 2,
                    'pkh' => $programPemerintah['pkh'] ?? 2,
                    'bst' => $programPemerintah['bst'] ?? 2,
                    'banpres' => $programPemerintah['banpres'] ?? 2,
                    'bantuan_umkm' => $programPemerintah['bantuan_umkm'] ?? 2,
                    'bantuan_pekerja' => $programPemerintah['bantuan_pekerja'] ?? 2,
                    'bantuan_pendidikan' => $programPemerintah['bantuan_pendidikan'] ?? 2,
                    'lainnya' => $programPemerintah['lainnya'] ?? 2,
                    'keterangan_lainnya' => $programPemerintah['keterangan_lainnya'] ?? ''
                ];
                
                $existingProgram = $this->programPemerintahModel->where('permukiman_id', $permukimanId)->first();
                if ($existingProgram) {
                    $this->programPemerintahModel->update($existingProgram['id'], $programData);
                } else {
                    $this->programPemerintahModel->insert($programData);
                }
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
            }
            
            return redirect()->to('/kuesioner')->with('success', 'Data berhasil disimpan.');
            
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Cari data keluarga
            $keluarga = $this->keluargaModel->find($id);
            if (!$keluarga) {
                return redirect()->to('/kuesioner')->with('error', 'Data tidak ditemukan.');
            }
            
            // Cari data permukiman
            $permukiman = $this->permukimanModel->where('keluarga_id', $id)->first();
            
            // Hapus data terkait
            if ($permukiman) {
                $this->aksesPendidikanModel->where('permukiman_id', $permukiman['id'])->delete();
                $this->aksesKesehatanModel->where('permukiman_id', $permukiman['id'])->delete();
                $this->aksesTenagaKesehatanModel->where('permukiman_id', $permukiman['id'])->delete();
                $this->aksesTransportasiModel->where('permukiman_id', $permukiman['id'])->delete();
                $this->programPemerintahModel->where('permukiman_id', $permukiman['id'])->delete();
                $this->permukimanModel->delete($permukiman['id']);
            }
            
            // Hapus data keluarga dan lokasi
            $this->keluargaModel->delete($id);
            $this->lokasiModel->delete($keluarga['lokasi_id']);
            
            $db->transComplete();
            
            if ($db->transStatus() === FALSE) {
                return redirect()->to('/kuesioner')->with('error', 'Gagal menghapus data.');
            }
            
            return redirect()->to('/kuesioner')->with('success', 'Data berhasil dihapus.');
            
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/kuesioner')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}