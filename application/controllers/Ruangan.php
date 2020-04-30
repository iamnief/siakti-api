<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Ruangan extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('RuanganModel');
	}


	function index_get() {
        $this->load->helper('url');
        $namaruang = $this->uri->segment(2);
        if ($namaruang=='') {
            $res = $this->RuanganModel->getAll();
            
        } else{
            $res = $this->RuanganModel->getOne($namaruang);
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

        $res = $this->RuanganModel->insertNew($data);
        $this->response($res);
    }

    function index_put(){
        $this->load->helper('url');
        $namaruang = $this->uri->segment(2);

        $data = array(
            'namaruang' => $namaruang,
            'kapasitas' => $this->put('kapasitas'),
            'lokasi_gedung' => $this->put('lokasi_gedung'),
            'status' => $this->put('status')
        );

        $res = $this->RuanganModel->update($data);
        $this->response($res);
    }

    function index_delete(){
        $this->load->helper('url');
        $namaruang = $this->uri->segment(2);

        $res = $this->RuanganModel->delete($namaruang);
        $this->response($res);
    }
}
?>