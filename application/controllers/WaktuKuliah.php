<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class WaktuKuliah extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('WaktuKuliahModel');
	}

	function index_get() {
        //$this->load->helper('url');
        $kode_jam = $this->uri->segment(2);

        if ($kode_jam == '') {
            $res = $this->WaktuKuliahModel->getAll();
            
        } else{
            $res = $this->WaktuKuliahModel->getOne($kode_jam);
        }

        $this->response($res);
    }

    function index_post() {
        $data = array(
            'kode_jam' => $this->post('kode_jam'),
            'jam_mulai' => $this->post('jam_mulai'),
            'jam_selesai' => $this->post('jam_selesai'),
        );

        $res = $this->WaktuKuliahModel->insertNew($data);
        $this->response($res);
    }

    function index_put(){
        //$this->load->helper('url');
        $kode_jam = $this->uri->segment(2);

        $data = array(
            'kode_jam' => $kode_jam,
            'jam_mulai' => $this->put('jam_mulai'),
            'jam_selesai' => $this->put('jam_selesai'),
        );

        $res = $this->WaktuKuliahModel->update($data);
        $this->response($res);
    }

    function index_delete(){
        $this->load->helper('url');
        $kode_jam = $this->uri->segment(2);

        $res = $this->WaktuKuliahModel->delete($kode_jam);
        $this->response($res);
    }
}
?>