<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class AbsenMhs extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('AbsenMhsModel', 'absen_mhs');
	}

	function index_get() {
        $absensi_kd_absendsn = $this->get('absensi_kd_absendsn');
        $mhs_jdwal_kodemhs_jdwl = $this->get('mhs_jdwal_kodemhs_jdwl');

        $res = $this->absen_mhs->getAbsenMhs($absensi_kd_absendsn, $mhs_jdwal_kodemhs_jdwl);

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
            'absensi_absensi_kd_absendsn' => $this->post('absensi_absensi_kd_absendsn'),
            'mhs_jdwal_kodemhs_jdwl' => $this->post('mhs_jdwal_kodemhs_jdwl'),
            'jam_msk' => $this->post('jam_msk'),
            'jam_keluar' => $this->post('jam_keluar'),
            'telat' => $this->post('telat'),
            'status' => $this->post('status')
        );

        if($this->absen_mhs->insert($data) > 0){
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

    function index_put(){
        $data = array(
            'absensi_absensi_kd_absendsn' => $this->put('absensi_absensi_kd_absendsn'),
            'mhs_jdwal_kodemhs_jdwl' => $this->put('mhs_jdwal_kodemhs_jdwl'),
            'jam_msk' => $this->put('jam_msk'),
            'jam_keluar' => $this->put('jam_keluar'),
            'telat' => $this->put('telat'),
            'status' => $this->put('status')
        );

        if($this->absen_mhs->update($data) > 0){
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

    function index_delete(){
        $absensi_kd_absendsn = $this->delete('absensi_kd_absendsn');
        $mhs_jdwal_kodemhs_jdwl = $this->delete('mhs_jdwal_kodemhs_jdwl');

        if($mhs_jdwal_kodemhs_jdwl === NULL || $absensi_kd_absendsn === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide absensi_kd_absendsn and mhs_jdwal_kodemhs_jdwl'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->absen_mhs->delete($absensi_kd_absendsn) > 0){
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
}
?>