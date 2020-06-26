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
        $this->response($res);
    }

    function index_post() {
        $data = array(
            'tgl' => $this->post('tgl'),
            'jam_msk' => $this->post('jam_msk'),
            'jam_keluar' => $this->post('jam_keluar'),
            'materi' => $this->post('materi'),
            'mahasiswa_nim' => $this->post('mahasiswa_nim'),
            'staff_nip' => $this->post('staff_nip'),
            'pertemuanke' => $this->post('pertemuanke'),
            'jadwal_kul_kodejdwl' => $this->post('jadwal_kul_kodejdwl'),
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
        $data = $this->put();

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