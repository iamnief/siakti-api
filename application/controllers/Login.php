<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
	}

	function login_get(){
        $username = $this->post('username');
        $password = $this->post('password');
        $where = array(
            'usr_name' => $username,
            'password' => $password
        );

        $cek_m = $this->db->get_where('tik.mahasiswa',$where)->num_rows();
        $cek_d = $this->db->get_where('tik.staff',$where)->num_rows();

        if($cek_m > 0){
            $res = $this->db->get_where('tik.mahasiswa',$where)->result_array();
            $data_session = array(
                'usr_name' => $username,
                'password' => $password
            );
            $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Sukses Login Mahasiswa',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
            $this->session->set_userdata($data_session);
        }
        elseif ($cek_d > 0) {
            $this->db->get_where('tik.staff',$where)->result_array();
            $data_session = array(
                'usr_name' => $username,
                'password' => $password
            );
            $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Success Login Dosen',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
            $this->session->set_userdata($data_session);
        }
        else{
            $this->response([
                'responseCode' => '404',
                'responseDesc' => 'Account Not Found',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
?>