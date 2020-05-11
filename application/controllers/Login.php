<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
	}

	function login_post(){
        $username = $this->post('username');
        $password = $this->post('password');
        $where = array(
            'usr_name' => $username,
            'password' => $password
        );

        $cek_m = $this->db->get_where('tik.mahasiswa',$where)->num_rows();
        $cek_d = $this->db->get_where('tik.staff',$where)->num_rows();

        if($cek_m > 0){
            $data_session = array(
                'usr_name' => $username,
                'password' => $password
            );
            $this->session->set_userdata($data_session);
        }
        elseif ($cek_d > 0) {
            $data_session = array(
                'usr_name' => $username,
                'password' => $password
            );
            $this->session->set_userdata($data_session);
        }
        else{
            echo "gagal login";
        }
    }
}
?>