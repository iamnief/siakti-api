<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Prodi extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('ProdiModel', 'prodi');
	}

	function index_get() {
        $id = $this->get('prodi_id');

        if ($id === NULL) {
            $res = $this->prodi->getProdi();    
        } else{
            $res = $this->prodi->getProdi($id);
        }

        if($res){
            $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Success Get Prodi',
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
            'namaprod' => $this->post('namaprod'),
            'jenprod' => $this->post('jenprod'),
            'jurusan_kodejur' => $this->post('jurusan_kodejur'),
            'prodi_id' => $this->post('prodi_id'),
        );

        if($this->prodi->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New Prodi Has Been Created',
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
        $id = $this->put('prodi_id');

        $data = array(
            'namaprod' => $this->put('namaprod'),
            'jenprod' => $this->put('jenprod'),
            'jurusan_kodejur' => $this->put('jurusan_kodejur'),
            'prodi_id' => $this->put('prodi_id'),
        );

        if($this->prodi->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'Prodi Has Been Updated',
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
        $id = $this->delete('prodi_id');

        if($id === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->prodi->delete($id) > 0){
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $id
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'ID Nout Found',
                    'responseData' => $id
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>