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
            'namaprod' => $this->post('namaprod'),
            'jenprod' => $this->post('jenprod'),
            'jurusan_kodejur' => $this->post('jurusan_kodejur'),
            'prodi_id' => $this->post('prodi_id'),
        );

        if($this->prodi->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Prodi Has Been Created',
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
        $id = $this->put('prodi_id');

        $data = array(
            'namaprod' => $this->put('namaprod'),
            'jenprod' => $this->put('jenprod'),
            'jurusan_kodejur' => $this->put('jurusan_kodejur'),
            'prodi_id' => $this->put('prodi_id'),
        );

        if($this->prodi->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Prodi Has Been Updated',
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
        $id = $this->delete('prodi_id');

        if($id === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->prodi->delete($id) > 0){
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID Nout Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>