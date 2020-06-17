<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class JadwalKuliah extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('JadwalKuliahModel', 'jadwalkuliah');
		$this->load->model('KelasPenggantiModel', 'kls_pengganti');
		$this->load->model('TahunAkadModel', 'thn_akad');
	}

	function index_get() {
        $kodejdwl = $this->get('kodejdwl');

        if ($kodejdwl === NULL) {
            $res = $this->jadwalkuliah->getJadwalKuliah();    
        } else{
            $res = $this->jadwalkuliah->getJadwalKuliah($kodejdwl);
        }
        $this->response($res);
    }

    function index_post() {
        $data = array(
            'kodejdwl' => $this->post('kodejdwl'),
            'matakuliah_kodemk' => $this->post('matakuliah_kodemk'),
            'kelas_kodeklas' => $this->post('kelas_kodeklas'),
            'staff_nip' => $this->post('staff_nip'),
            'wkt_kuliah_kode_jam' => $this->post('wkt_kuliah_kode_jam'),
            'ruangan_namaruang' => $this->post('ruangan_namaruang'),
            'thn_akad_thn_akad_id' => $this->post('thn_akad_thn_akad_id'),
            'hari' => $this->post('hari')
        );

        if($this->jadwalkuliah->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New JadwalKuliah Has Been Created',
                'responseData' => $data
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Create New Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_put(){
        $data = array(
            'kodejdwl' => $this->put('kodejdwl'),
            'matakuliah_kodemk' => $this->put('matakuliah_kodemk'),
            'kelas_kodeklas' => $this->put('kelas_kodeklas'),
            'staff_nip' => $this->put('staff_nip'),
            'wkt_kuliah_kode_jam' => $this->put('wkt_kuliah_kode_jam'),
            'ruangan_namaruang' => $this->put('ruangan_namaruang'),
            'thn_akad_thn_akad_id' => $this->put('thn_akad_thn_akad_id'),
            'hari' => $this->put('hari')
        );

        if($this->jadwalkuliah->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'Jadwal Kuliah Has Been Updated',
                'responseData' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Update Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete(){
        $kodejdwl = $this->delete('kodejdwl');

        if($kodejdwl === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->jadwalkuliah->delete($kodejdwl) > 0){
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $kodejdwl
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'ID Not Found',
                    'responseData' => $kodejdwl
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    function mahasiswa_get($kelas, $tgl) {
        $hari = date("N", strtotime($tgl));
        
        $thn_akad = $this->thn_akad->getTahunAkadAktif();
        $thn_akad_id = $thn_akad[0]['thn_akad_id'];
        
        $jk = $this->jadwalkuliah->getJadwalKuliahMahasiswa($thn_akad_id, $kelas, $hari);
        $kp = $this->kls_pengganti->getKelasPenggantiMahasiswa($thn_akad_id, $kelas, $tgl);
        
        $res = array_merge($jk, $kp);
        
        usort($res, function ($a, $b){
            return $a['jam_mulai'] < $b['jam_mulai'] ? -1 : 1;
        });
        
        $this->response($res);
    }

    function dosen_get($nip, $tgl) {
        $hari = date("N", strtotime($tgl));
        
        $thn_akad = $this->thn_akad->getTahunAkadAktif();
        $thn_akad_id = $thn_akad[0]['thn_akad_id'];
        
        $jk = $this->jadwalkuliah->getJadwalKuliahDosen($thn_akad_id, $nip, $hari, $tgl);
        $kp = $this->kls_pengganti->getKelasPenggantiDosen($thn_akad_id, $nip, $tgl);
        
        $res = array_merge($jk, $kp);
        
        usort($res, function ($a, $b){
            return $a['jam_mulai'] < $b['jam_mulai'] ? -1 : 1;
        });
        
        $this->response($res);
    }
}
?>