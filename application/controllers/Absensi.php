<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Absensi extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('AbsensiModel', 'absensi');
	}

	function index_get() {
        $kd_absendsn = $this->get('kd_absendsn');

        if ($kd_absendsn === NULL) {
            $res = $this->absensi->getAbsensi();    
        } else{
            $res = $this->absensi->getAbsensi($kd_absendsn);
        }

        if($res){
            $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Success Get absensi',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '404',
                'responseDesc' => 'ID Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        } 
    }

    function index_post() {
        $data = array(
            'kd_absendsn' => $this->post('kd_absendsn'),
            'tgl' => $this->post('tgl'),
            'jam_msk' => $this->post('jam_msk'),
            'jam_keluar' => $this->post('jam_keluar'),
            'materi' => $this->post('materi'),
            'mahasiswa_nim' => $this->post('mahasiswa_nim'),
            'staff_nip' => $this->post('staff_nip'),
            'pertemuanke' => $this->post('pertemuanke'),
            'jadwal_kul_kode_jadwal' => $this->post('jadwal_kul_kode_jadwal'),
            'kls_pengganti_kd_gantikls' => $this->post('kls_pengganti_kd_gantikls')
        );

        if($this->absensi->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New Absensi Has Been Created',
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
        $kd_absendsn = $this->put('kd_absendsn');

        $data = array(
            'kd_absendsn' => $kd_absendsn,
            'tgl' => $this->put('tgl'),
            'jam_msk' => $this->put('jam_msk'),
            'jam_keluar' => $this->put('jam_keluar'),
            'materi' => $this->put('materi'),
            'mahasiswa_nim' => $this->put('mahasiswa_nim'),
            'staff_nip' => $this->put('staff_nip'),
            'pertemuanke' => $this->put('pertemuanke'),
            'jadwal_kul_kode_jadwal' => $this->put('jadwal_kul_kode_jadwal'),
            'kls_pengganti_kd_gantikls' => $this->put('kls_pengganti_kd_gantikls')
        );

        if($this->absensi->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'Absensi Has Been Updated',
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
        $kd_absendsn = $this->delete('kd_absendsn');

        if($kd_absendsn === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->absensi->delete($kd_absendsn) > 0){
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $kd_absendsn
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'ID Not Found',
                    'responseData' => $kd_absendsn
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>