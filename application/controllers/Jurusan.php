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
                'responseCode' => '200',
                'responseDesc' => 'Success Get Kodejur',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '404',
                'responseDesc' => 'Kodejur Not Found'
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
                'responseCode' => '00',
                'responseDesc' => 'New Jurusan Has Been Created',
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
        $kodejur = $this->put('kodejur');

        $data = array(
            'kodejur' => $kodejur,
            'namajur' => $this->put('namajur'),
        );

        if($this->jurusan->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'Jurusan Has Been Updated',
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
        $kodejur = $this->delete('kodejur');

        if($kodejur === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an Kodejur'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->jurusan->delete($kodejur) > 0){
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $kodejur
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'Kodejur Not Found',
                    'responseData' => $kodejur
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>