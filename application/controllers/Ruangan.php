<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Ruangan extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('RuanganModel', 'ruangan');
	}

	function index_get() {
        $id = $this->get('namaruang');

        if ($id === NULL) {
            $res = $this->ruangan->getRuangan();    
        } else{
            $res = $this->ruangan->getRuangan($id);
        }
        $this->response($res);
    }

    function index_post() {
        $data = array(
            'namaruang' => $this->post('namaruang'),
            'kapasitas' => $this->post('kapasitas'),
            'lokasi_gedung' => $this->post('lokasi_gedung'),
            'status' => $this->post('status')
        );

        if($this->ruangan->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New Ruangan Has Been Created',
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
        $id = $this->put('namaruang');

        $data = array(
            'namaruang' => $id,
            'kapasitas' => $this->put('kapasitas'),
            'lokasi_gedung' => $this->put('lokasi_gedung'),
            'status' => $this->put('status')
        );

        if($this->ruangan->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'Ruangan Has Been Updated',
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
        $id = $this->delete('namaruang');

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
