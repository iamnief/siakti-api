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
                'responseCode' => '200',
                'responseDesc' => 'Succes Get Tahun Akad',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '404',
                'responseDesc' => 'ID Not Found',
                'responseData' => $id
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
                'responseCode' => '00',
                'responseDesc' => 'New Tahun Akad Has Been Created',
                'data' => $data
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Create New Data!'
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
                'responseCode' => '00',
                'responseDesc' => 'Tahun Akad Has Been Updated',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Update Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete(){
        $id = $this->delete('thn_akad_id');

        if($id === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->tahunakad->delete($id) > 0){
                $this->response([
                    'responseCode' =>'00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $id  
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'ID Nout Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>