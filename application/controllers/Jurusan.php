<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Jurusan extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('JurusanModel', 'jurusan');
	}

	function index_get() {
        $kodejur = $this->get('kodejur');

        if ($kodejur === NULL) {
            $res = $this->jurusan->getJurusan();    
        } else{
            $res = $this->jurusan->getJurusan($kodejur);
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
            'kodejur' => $this->post('kodejur'),
            'namajur' => $this->post('namajur'),
        );

        if($this->jurusan->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Jurusan Has Been Created',
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
        $kodejur = $this->put('kodejur');

        $data = array(
            'kodejur' => $kodejur,
            'namajur' => $this->post('namajur'),
        );

        if($this->jurusan->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Jurusan Has Been Updated',
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
        $kodejur = $this->delete('kodejur');

        if($kodejur === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->jurusan->delete($kodejur) > 0){
                $this->response([
                    'status' => true,
                    'kodejur' => $kodejur,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Kodejur Nout Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>