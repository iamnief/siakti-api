<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class MataKuliah extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('MataKuliahModel', 'matakuliah');
	}

	function index_get() {
        $kodemk = $this->get('kodemk');

        if ($kodemk === NULL) {
            $res = $this->matakuliah->getMataKuliah();    
        } else{
            $res = $this->matakuliah->getMataKuliah($kodemk);
        }

        if($res){
            $this->response([
                'status' => true,
                'data' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'kodemk Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        } 
    }

    function index_post() {
        $data = array(
            'kodemk' => $this->post('kodemk'),
            'mamamk' => $this->post('namamk'),
            'sks_prak' => $this->post('sks_prak'),
            'jam_prak' => $this->post('jam_prak'),
            'sks_teori' => $this->post('sks_teori'),
            'jam_teori' => $this->post('jam_teori'),
            'cp_mk' => $this->post('cp_mk'),
            'kurikulum_namakur' => $this->post('kurikulum_namakur'),
            'semesterke' => $this->post('semesterke'),
        );

        if($this->matakuliah->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Mata Kuliah Has Been Created',
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
        $kodemk = $this->put('kodemk');

        $data = array(
            'kodemk' => $kodemk,
            'mamamk' => $this->put('namamk'),
            'sks_prak' => $this->put('sks_prak'),
            'jam_prak' => $this->put('jam_prak'),
            'sks_teori' => $this->put('sks_teori'),
            'jam_teori' => $this->put('jam_teori'),
            'cp_mk' => $this->put('cp_mk'),
            'kurikulum_namakur' => $this->put('kurikulum_namakur'),
            'semesterke' => $this->put('semesterke'),
        );

        if($this->matakuliah->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Mata Kuliah Has Been Updated',
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
        $kodemk = $this->delete('kodemk');

        if($kodemk === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an kodemk'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->matakuliah->delete($kodemk) > 0){
                $this->response([
                    'status' => true,
                    'kodemk' => $kodemk,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'kodemk Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>