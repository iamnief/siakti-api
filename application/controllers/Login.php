<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller{

	function __construct($config = 'rest'){
        parent::__construct($config);
		$this->load->model('StaffModel', 'staff');

		date_default_timezone_set("Asia/Jakarta");
	}

	function index_post(){
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
            // $data_session = array(
            //     'usr_name' => $username,
            //     'password' => $password
            // );
            $this->response($res);
        }
        elseif ($cek_d > 0) {
            $res = $this->db->get_where('tik.staff',$where)->result_array();
            $jab_struk = $this->staff->getStaffJab($res[0]['nip'], date('d-m-Y'));

            // $data_session = array(
            //     'usr_name' => $username,
            //     'password' => $password
            // );

            if (count($jab_struk) > 0){
                $res[0]['jab_dsn'] = $jab_struk[0]['jab_struk_nama_jab'];
            }

            $this->response($res);
        }
        else{
            $this->response();
        }
    }
}
?>