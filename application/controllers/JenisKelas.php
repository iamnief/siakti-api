<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class JenisKelas extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('JenisKelasModel', 'jeniskelas');
	}

	function index_get() {
        $namajnskls = $this->get('nama_jnskls');

        if ($namajnskls === NULL) {
            $res = $this->jeniskelas->getJenisKelas();    
        } else{
            $res = $this->jeniskelas->getJenisKelas($namajnskls);
        }

        if($res){
            $this->response([
                'status' => true,
                'data' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'namajnskls Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        } 
    }

    function index_post() {
        $data = array(
            'nama_jnskls' => $this->post('nama_jnskls'),
        );

        if($this->jeniskelas->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'NewJenis Kelas Has Been Created',
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
        $namajnskls = $this->put('nama_jnskls');

        $data = array(
            'nama_jnskls' => $namajnskls,
        );

        if($this->jeniskelas->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Jenis Kelas Has Been Updated',
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
        $namajnskls = $this->delete('nama_jnskls');

        if($namajnskls === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an namajnskls'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->jeniskelas->delete($namajnskls) > 0){
                $this->response([
                    'status' => true,
                    'nama_jnskls' => $namajnskls,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'namajnskls Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>