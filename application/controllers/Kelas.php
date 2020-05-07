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
                'status' => true,
                'data' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'ID Not Found'
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
                'status' => true,
                'message' => 'New Kelas Has Been Created',
                'data' => $data
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to Create New Data!'
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
                'status' => true,
                'message' => 'Kelas Has Been Updated',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to Update Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete(){
        $kode_kls = $this->delete('kodeklas');

        if($kode_klas === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->kelas->delete($kode_kls) > 0){
                $this->response([
                    'status' => true,
                    'kodeklas' => $kode_kls,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>