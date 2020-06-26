<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class AbsenMhs extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('AbsenMhsModel', 'absen_mhs');
        $this->load->model('MahasiswaModel', 'mahasiswa');
        $this->load->model('AbsensiModel', 'absensi');
        $this->load->model('JadwalKuliahModel', 'jadwal');
        $this->load->model('KelasPenggantiModel', 'kelaspengganti');
        $this->load->model('TahunAkadModel', 'thn_akad');
    }

    function index_get()
    {
        $absensi_kd_absendsn = $this->get('absensi_kd_absendsn');
        $mahasiswa_nim = $this->get('mahasiswa_nim');

        $res = $this->absen_mhs->getAbsenMhs($absensi_kd_absendsn, $mahasiswa_nim);

        $this->response($res);
    }

    function index_post()
    {
        $data = array(
            'absensi_absensi_kd_absendsn' => $this->post('absensi_absensi_kd_absendsn'),
            'mahasiswa_nim' => $this->post('mahasiswa_nim'),
            'mhs_jdwal_kodemhs_jdwl' => $this->post('mhs_jdwal_kodemhs_jdwl'),
            'jam_msk' => $this->post('jam_msk'),
            'jam_keluar' => $this->post('jam_keluar'),
            'telat' => $this->post('telat'),
            'status' => $this->post('status')
        );

        if ($this->absen_mhs->insert($data) > 0) {
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New AbsenMhs Has Been Created',
                'responseData' => $data
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Create New Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_put()
    {
        $data = $this->put();

        if ($this->absen_mhs->update($data) > 0) {
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'AbsenMhs Has Been Updated',
                'responseData' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Update Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete()
    {
        $absensi_kd_absendsn = $this->delete('absensi_kd_absendsn');
        $mahasiswa_nim = $this->delete('mahasiswa_nim');

        if ($mahasiswa_nim === NULL || $absensi_kd_absendsn === NULL) {
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide absensi_kd_absendsn and mahasiswa_nim'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->absen_mhs->delete($absensi_kd_absendsn) > 0) {
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $absensi_kd_absendsn
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'ID Not Found',
                    'responseData' => $absensi_kd_absendsn
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    function mulaikelas_post()
    {
        $kodeklas = $this->post('kodeklas');
        $data_absensi['tgl'] = $this->post('tgl');

        if ($this->post('tipe_kelas') == 'normal') {
            $data_absensi['jadwal_kul_kodejdwl'] = $this->post('jadwal_kul_kodejdwl');
        } else if ($this->post('tipe kelas') == 'pengganti') {
            $data_absensi['kls_pengganti_kd_gantikls'] = $this->post('kls_pengganti_kd_gantikls');
        }

        $absensi = $this->absensi->getAbsensiByTglJad($data_absensi);
        $absensi_kd_absendsn = $absensi[0]['kd_absendsn'];

        $mahasiswa = $this->mahasiswa->getMahasiswaByKelas($kodeklas);
        $n = 0;

        foreach ($mahasiswa as $key => $value) {
            $absen = array(
                'absensi_kd_absendsn' => $absensi_kd_absendsn,
                'mahasiswa_nim' => $value['nim'],
                'status' => 'Alpha'
            );
            $n += $this->absen_mhs->insert($absen);
        }

        $this->response([
            'jml_mhs' => $n
        ]);
    }

    function absenkelas_get($kd_absendsn)
    {
        $this->response($this->absen_mhs->getAbsenMhsInKelas($kd_absendsn));
    }

    function scan_post()
    {
        $thn_akad = $this->thn_akad->getTahunAkadAktif();
        $thn_akad_id = $thn_akad[0]['thn_akad_id'];
        $namaruang = $this->post('namaruang');
        $hari = $this->post('hari');
        $waktu = $this->post('waktu');
        $tgl = $this->post('tgl');
        $nim = $this->post('nim');
        $kelas_kodeklas = $this->post('kelas_kodeklas');

        // Jadwal Kuliah
        $jk = $this->jadwal->getJadwalForAbsen($thn_akad_id, $namaruang, $hari, $waktu);

        // Kelas Pengganti
        $kp = $this->kelaspengganti->getKelasPenggantiForAbsen($thn_akad_id, $namaruang, $tgl, $waktu);

        $absensi = null;
        $response = null;

        if (count($jk) <= 0 && count($kp) <= 0) { // Jika tidak ada jadwal maupun kelas pengganti

            $response = [
                'message' => 'Tidak Ada Kelas',
                'code' => 'X01'
            ];
        } else if (count($kp) == 1) { // Jika ada Kelas Pengganti

            if ($kelas_kodeklas == $kp[0]['kelas_kodeklas']) { // Jika kelas sesuai

                $data_absensi = array(
                    'kls_pengganti_kd_gantikls' => $kp[0]['kodejdwl'],
                    'tgl' => $tgl
                );

                $absensi = $this->absensi->getAbsensiByTglJad($data_absensi);
            } else { // Jika kelas tidak sesuai

                $response = [
                    'message' => 'Bukan Kelas Anda',
                    'code' => 'X03'
                ];
            }
        } else if (count($jk) == 1) { // Jika ada Jadwal Kuliah

            $is_batal = $this->kelaspengganti->isKelasBatalJadwal($jk[0]['kodejdwl'], $tgl);

            if (!$is_batal) { // Jika kelas tidak batal

                if ($kelas_kodeklas == $jk[0]['kelas_kodeklas']) { // Jika kelas sesuai

                    $data_absensi = array(
                        'jadwal_kul_kodejdwl' => $jk['kodejdwl'],
                        'tgl' => $tgl
                    );
                    $absensi = $this->absensi->getAbsensiByTglJad($data_absensi);
                } else { // Jika kelas tidak sesuai

                    $response = [
                        'message' => 'Bukan Kelas Anda',
                        'code' => 'X03'
                    ];
                }
            } else { // Jika kelas batal

                $response = [
                    'message' => 'Tidak Ada Kelas',
                    'code' => 'X01'
                ];
            }
        }

        if (is_array($absensi)) {
            if (count($absensi) == 0) { // Jika belum dicatat di tabel absensi (kelas belum mulai)

                $response = [
                    'message' => 'Kelas Belum dimulai',
                    'code' => 'X02'
                ];
            } else { // Jika sudah ada di tabel absensi (kelas sudah mulai)

                $absen_mhs = $this->absen_mhs->getAbsenMhs($nim, $absensi[0]['kd_absendsn']);

                if ($absensi[0]['jam_keluar'] == null) { // Jika kelas belum selesai

                    if ($absen_mhs[0]['jam_masuk'] == null) { // Jika mahasiswa belum absen

                        $update_absen = array(
                            'jam_masuk' => $waktu,
                            'status' => 'Hadir',
                            'mahasiswa_nim' => $nim,
                            'absensi_kd_absendsn' => $absensi[0]['kd_absendsn']
                        );

                        $update = $this->absen_mhs->update($update_absen);

                        if ($update <= 0) { // Jika Gagal Absen

                            $response = [
                                'message' => 'Gagal Absen Masuk',
                                'code' => 'X05'
                            ];
                        } else { // Jika Berhasil Absen

                            $response = [
                                'message' => 'Absen Masuk Berhasil Tercatat',
                                'code' => 'Y01',
                                'data' => array(
                                    'namamk' => $kp[0]['namamk']
                                )
                            ];
                        }
                    } else { // Jika mahasiswa sudah absen masuk

                        $response = [
                            'message' => 'Anda Sudah Absen Masuk Sebelumnya',
                            'code' => 'X04'
                        ];
                    }
                } else { // Jika kelas sudah selesai

                    if ($absen_mhs[0]['jam_masuk'] == null) { // Jika mahasiswa belum absen masuk

                        $this->response([
                            'message' => 'Kelas Sudah Selesai',
                            'code' => 'X06'
                        ]);
                    } else if ($absen_mhs[0]['jam_keluar'] == null) { // Jika mahasiswa belum absen keluar

                        $update_absen = array(
                            'jam_keluar' => $waktu,
                            'status' => 'Hadir',
                            'mahasiswa_nim' => $nim,
                            'absensi_kd_absendsn' => $absensi[0]['kd_absendsn']
                        );

                        $update = $this->absen_mhs->update($update_absen);

                        if ($update <= 0) { // Jika Gagal Absen

                            $response = [
                                'message' => 'Gagal Absen Keluar',
                                'code' => 'X05'
                            ];
                        } else { // Jika Berhasil Absen

                            $response = [
                                'message' => 'Absen Keluar Berhasil Tercatat',
                                'code' => 'Y02',
                                'data' => array(
                                    'namamk' => $kp[0]['namamk']
                                )
                            ];
                        }
                    } else { // Jika mahasiswa sudah absen keluar

                        $response = [
                            'message' => 'Anda Sudah Absen Keluar Sebelumnya',
                            'code' => 'Y02'
                        ];
                    }
                }
            }
        }
        $this->response($response);
    }
}
