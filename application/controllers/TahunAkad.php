<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class TahunAkad extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('TahunAkadModel', 'tahunakad');
	}

	function index_get() {
        $id = $this->get('thn_akad_id');

        if ($id === NULL) {
            $res = $this->tahunakad->getTahunAkad();    
        } else{
            $res = $this->tahunakad->getTahunAkad($id);
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
            'thn_akad_id' => $this->post('thn_akad_id'),
            'tahun_akad' => $this->post('tahun_akad'),
            'semester_semester_nm' => $this->post('semester_semester_nm'),
        );

        if($this->tahunakad->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Tahun Akad Has Been Created',
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
        $id = $this->put('thn_akad_id');

        $data = array(
            'thn_akad_id' => $id,
            'tahun_akad' => $this->put('tahun_akad'),
            'semester_semester_nm' => $this->put('semester_semester_nm'),
        );

        if($this->tahunakad->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Tahun Akad Has Been Updated',
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
        $id = $this->delete('thn_akad_id');

        if($id === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->tahunakad->delete($id) > 0){
                $this->response([
                    'status' => true,
                    'thn_akad_id' => $id,
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