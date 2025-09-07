<?php

namespace App\Controllers;

use App\Models\LokasiModel;
use App\Models\KeluargaModel;
use App\Models\PermukimanModel;
use App\Models\AksesPendidikanModel;

class SurveyController extends BaseController
{
    public function simpanDataSurvey()
    {
        // Validasi input
        if (!$this->validate([
            'enumerator_id' => 'required|integer',
            'rt_rw' => 'permit_empty|string',
            'nama_responden' => 'permit_empty|string',
            'alamat_responden' => 'permit_empty|string',
            'nomor_hp' => 'permit_empty|string|max_length[20]',
            'no_telepon_rumah' => 'permit_empty|string|max_length[20]',
            'no_kk' => 'required|string|max_length[20]',
            'nik_kepala_keluarga' => 'required|string|max_length[16]',
            // Tambahkan validasi untuk field lainnya sesuai kebutuhan
        ])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        // Mulai transaction database
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Simpan data ke tabel lokasi
            $lokasiModel = new LokasiModel();
            $lokasiData = [
                'rt_rw' => $this->request->getPost('rt_rw'),
                'nama_responden' => $this->request->getPost('nama_responden'),
                'alamat_responden' => $this->request->getPost('alamat_responden'),
                'nomor_hp' => $this->request->getPost('nomor_hp'),
                'nomor_telepon_rumah' => $this->request->getPost('no_telepon_rumah'),
                'provinsi' => 'Jawa Barat',
                'kabupaten_kota' => 'Sumedang',
                'kecamatan' => 'Sumedang Utara',
                'desa' => 'Jatimulya',
                'desa_id' => 26
            ];
            
            // Debug: Tampilkan data yang akan disimpan
            log_message('debug', 'Data lokasi: ' . print_r($lokasiData, true));
            
            $lokasiId = $lokasiModel->insert($lokasiData);
            
            if (!$lokasiId) {
                // Dapatkan error dari model
                $error = $lokasiModel->errors();
                log_message('error', 'Error menyimpan lokasi: ' . print_r($error, true));
                
                throw new \Exception('Gagal menyimpan data lokasi: ' . print_r($error, true));
            }

            // 2. Simpan data ke tabel keluarga
            $keluargaModel = new KeluargaModel();
            $keluargaData = [
                'nomor_kk' => $this->request->getPost('no_kk'),
                'nik_kepala_keluarga' => $this->request->getPost('nik_kepala_keluarga'),
                'lokasi_id' => $lokasiId,
                'enumerator_id' => $this->request->getPost('enumerator_id'),
            ];
            
            $keluargaId = $keluargaModel->insert($keluargaData);
            if (!$keluargaId) {
                throw new \Exception('Gagal menyimpan data keluarga');
            }

            // 3. Simpan data ke tabel permukiman
            $permukimanModel = new PermukimanModel();
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
                'kondisi_rumah' => $this->request->getPost('kondisi_rumah'),
            ];
            
            $permukimanId = $permukimanModel->insert($permukimanData);
            if (!$permukimanId) {
                throw new \Exception('Gagal menyimpan data permukiman');
            }

            // 4. Simpan data akses pendidikan
            $aksesPendidikanModel = new AksesPendidikanModel();
            $aksesPendidikanData = $this->request->getPost('akses_pendidikan');
            
            if (!empty($aksesPendidikanData)) {
                foreach ($aksesPendidikanData as $data) {
                    // Hanya simpan jika ada data jarak, waktu, atau kemudahan
                    if (!empty($data['jarak_km']) || !empty($data['waktu_tempuh_jam']) || !empty($data['kemudahan'])) {
                        $pendidikanData = [
                            'permukiman_id' => $permukimanId,
                            'fasilitas' => $data['fasilitas'],
                            'jarak_km' => $data['jarak_km'] ?? null,
                            'waktu_tempuh_jam' => $data['waktu_tempuh_jam'] ?? null,
                            'kemudahan' => $data['kemudahan'] ?? null,
                        ];
                        
                        if (!$aksesPendidikanModel->insert($pendidikanData)) {
                            throw new \Exception('Gagal menyimpan data akses pendidikan: ' . $data['fasilitas']);
                        }
                    }
                }
            }

            // Commit transaction
            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                throw new \Exception('Terjadi kesalahan dalam penyimpanan data');
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => [
                    'lokasi_id' => $lokasiId,
                    'keluarga_id' => $keluargaId,
                    'permukiman_id' => $permukimanId
                ]
            ]);

        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            $db->transRollback();
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}