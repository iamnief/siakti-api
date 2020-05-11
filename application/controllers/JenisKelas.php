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
                'responseCode' => '200',
                'responseDesc' => 'Success Get Jenis Kelas',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '404',
                'responseDesc' => 'Nama Jenis Kelas Not Found',
            ], REST_Controller::HTTP_NOT_FOUND);
        } 
    }

    function index_post() {
        $data = array(
            'nama_jnskls' => $this->post('nama_jnskls'),
        );

        if($this->jeniskelas->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New Jenis Kelas Data Has Been Created'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Create New Data!',
                'responseData' => $data
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
                'responseCode' => '00',
                'responseDesc' => 'Jenis Kelas Data Has Been Updated',
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
        $namajnskls = $this->delete('nama_jnskls');

        if($namajnskls === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an Nama Jenis Kelas'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->jeniskelas->delete($namajnskls) > 0){
                $this->response([
                    'responseCode' => '00',
                    'respoNseDesc' => 'Deleted',
                    'responseData' => $namajnskls        
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'Nama Jenis Kelas Not Found',
                    'responseData' => $namajnskls
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>