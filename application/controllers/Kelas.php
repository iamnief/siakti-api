<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kelas extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('KelasModel', 'kelas');
	}

	function index_get() {
        $kode_kls = $this->get('kodeklas');

        if ($kode_kls === NULL) {
            $res = $this->kelas->getKelas();    
        } else{
            $res = $this->kelas->getKelas($kode_kls);
        }

        if($res){
            $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Success Get Kelas',
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
            'kodeklas' => $this->post('kodeklas'),
            'namaklas' => $this->post('namaklas'),
            'jns_kls_nama_jnskls' => $this->post('jns_kls_nama_jnskls'),
            'prodi_prodi_id' => $this->post('prodi_prodi_id'),
        );

        if($this->kelas->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New Kelas Has Been Created',
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
        $kode_kls = $this->put('kodeklas');

        $data = array(
            'kodeklas' => $this->put('kodeklas'),
            'namaklas' => $this->put('namaklas'),
            'jns_kls_nama_jnskls' => $this->put('jns_kls_nama_jnskls'),
            'prodi_prodi_id' => $this->put('prodi_prodi_id'),
        );

        if($this->kelas->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'Kelas Has Been Updated',
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
        $kode_kls = $this->delete('kodeklas');

        if($kode_kls === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->kelas->delete($kode_kls) > 0){
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $kode_kls
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'ID Not Found',
                    'responseData' => $kode_kls
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>