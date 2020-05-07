<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class WaktuKuliah extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('WaktuKuliahModel', 'waktukuliah');
	}

	function index_get() {
        $kode_jam = $this->get('kode_jam');

        if ($kode_jam === NULL) {
            $res = $this->waktukuliah->getWaktuKuliah();    
        } else{
            $res = $this->waktukuliah->getWaktuKuliah($kode_jam);
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
            'kode_jam' => $this->post('kode_jam'),
            'jam_mulai' => $this->post('jam_mulai'),
            'jam_selesai' => $this->post('jam_selesai'),
        );

        if($this->waktukuliah->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Waktu Kuliah Has Been Created',
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
        $kode_jam = $this->put('kode_jam');

        $data = array(
            'kode_jam' => $kode_jam,
            'jam_mulai' => $this->put('jam_mulai'),
            'jam_selesai' => $this->put('jam_selesai'),
        );

        if($this->waktukuliah->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Waktu Kuliah Has Been Updated',
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
        $kode_jam = $this->delete('kode_jam');

        if($kode_jam === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->waktukuliah->delete($kode_jam) > 0){
                $this->response([
                    'status' => true,
                    'kode_jam' => $kode_jam,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>