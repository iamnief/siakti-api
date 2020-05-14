<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Staff extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('StaffModel', 'staff');
	}

	function index_get() {
        $nip = $this->get('nip');

        if ($nip === NULL) {
            $res = $this->staff->getStaff();    
        } else{
            $res = $this->staff->getStaff($nip);
        }

        if($res){
            $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Success Get Staff',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '404',
                'responseDesc' => 'NIP Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        } 
    }

    function index_post() {
        $data = array(
            'nip' => $this->post('nip'),
            'nama' => $this->post('nama'),
            'alamat' => $this->post('alamat'),
            'kec_staff' => $this->post('kec_staff'),
            'kel_staff' => $this->post('kel_staff'),
            'kota_staff' => $this->post('kota_staff'),
            'tlp_staff' => $this->post('tlp_staff'),
            'email_staff' => $this->post('email_staff'),
            'usr_name' => $this->post('usr_name'),
            'password' => $this->post('password'),
            'prodi_prodi_id' => $this->post('prodi_prodi_id'),
        );

        if($this->staff->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New Staff Has Been Created',
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
        $nip = $this->put('nip');

        $data = array(
            'nip' => $nip,
            'nama' => $this->put('nama'),
            'alamat' => $this->put('alamat'),
            'kec_staff' => $this->put('kec_staff'),
            'kel_staff' => $this->put('kel_staff'),
            'kota_staff' => $this->put('kota_staff'),
            'tlp_staff' => $this->put('tlp_staff'),
            'email_staff' => $this->put('email_staff'),
            'usr_name' => $this->put('usr_name'),
            'password' => $this->put('password'),
            'prodi_prodi_id' => $this->put('prodi_prodi_id'),
        );

        if($this->staff->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'Staff Has Been Updated',
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
        $nip = $this->delete('nip');

        if($nip === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an NIP'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->staff->delete($nip) > 0){
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $nip
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'NIP Not Found',
                    'responseData' => $nip
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>