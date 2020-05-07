<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kurikulum extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('KurikulumModel', 'kurikulum');
	}

	function index_get() {
        $namakur = $this->get('namakur');

        if ($namakur === NULL) {
            $res = $this->kurikulum->getKurikulum();    
        } else{
            $res = $this->kurikulum->getKurikulum($namakur);
        }

        if($res){
            $this->response([
                'status' => true,
                'data' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'namakur Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        } 
    }

    function index_post() {
        $data = array(
            'namakur' => $this->post('namakur'),
            'tgl_berlaku' => $this->post('tgl_berlaku'),
            'learn_out_prodi' => $this->post('learn_out_prodi'),
            'prodi_prodi_id' => $this->post('prodi_prodi_id'),
            'thn_akad_thn_akad_id' => $this->post('thn_akad_thn_akad_id'),
        );

        if($this->kurikulum->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Kurikulum Has Been Created',
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
        $namakur = $this->put('namakur');

        $data = array(
            'namakur' => $this->put('namakur'),
            'tgl_berlaku' => $this->put('tgl_berlaku'),
            'learn_out_prodi' => $this->put('learn_out_prodi'),
            'prodi_prodi_id' => $this->put('prodi_prodi_id'),
            'thn_akad_thn_akad_id' => $this->put('thn_akad_thn_akad_id'),
        );

        if($this->kurikulum->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Kurikulum Has Been Updated',
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
        $namakur = $this->delete('namakur');

        if($namakur === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an namakur'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->kurikulum->delete($namakur) > 0){
                $this->response([
                    'status' => true,
                    'namakur' => $namakur,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'namakur Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>