<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Mahasiswa extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('MahasiswaModel', 'mahasiswa');
	}

	function index_get() {
        $nim = $this->get('nim');

        if ($nim === NULL) {
            $res = $this->mahasiswa->getMahasiswa();    
        } else{
            $res = $this->mahasiswa->getMahasiswa($nim);
        }
        $this->response($res);
    }

    function index_post() {
        $data = array(
            'nim' => $this->post('nim'),
            'nama_mhs' => $this->post('nama_mhs'),
            'add_mhs' => $this->post('add_mhs'),
            'add_kel_mhs' => $this->post('add_kel_mhs'),
            'add_kec_mhs' => $this->post('add_kec_mhs'),
            'add_kota_mhs' => $this->post('add_kota_mhs'),
            'bpk_mhs' => $this->post('bpk_mhs'),
            'add_bpk_mhs' => $this->post('add_bpk_mhs'),
            'kel_bpk' => $this->post('kel_bpk'),
            'kec_bpk' => $this->post('kec_bpk'),
            'kota_bpk' => $this->post('kota_bpk'),
            'ibu_mhs' => $this->post('ibu_mhs'),
            'add_ibu_mhs' => $this->post('add_ibu_mhs'),
            'kel_ibu' => $this->post('kel_ibu'),
            'kec_ibu' => $this->post('kec_ibu'),
            'kota_ibu' => $this->post('kota_ibu'),
            'tlp_mhs' => $this->post('tlp_mhs'),
            'tlp_bpk' => $this->post('tlp_bpk'),
            'tlp_ibu' => $this->post('tlp_ibu'),
            'profesi_bpk' => $this->post('profesi_bpk'),
            'profesi_ibu' => $this->post('profesi_ibu'),
            'penghasilan_bpk' => $this->post('penghasilan_bpk'),
            'email_mhs' => $this->post('email_mhs'),
            'email_ortu' => $this->post('email_ortu'),
            'kelas_kodeklas' => $this->post('kelas_kodeklas'),
            'thn_akad_thn_akad_id' => $this->post('thn_akad_thn_akad_id'),
            'usr_name' => $this->post('usr_name'),
            'password' => $this->post('password'),
            'pin' => $this->post('pin'),
            'prodi_prodi_id' => $this->post('prodi_prodi_id')
        );

        if($this->mahasiswa->insert($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New Mahasiswa Has Been Created',
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
        $nim = $this->put('nim');

        $data = array(
            'nim' => $nim,
            'nama_mhs' => $this->put('nama_mhs'),
            'add_mhs' => $this->put('add_mhs'),
            'add_kel_mhs' => $this->put('add_kel_mhs'),
            'add_kec_mhs' => $this->put('add_kec_mhs'),
            'add_kota_mhs' => $this->put('add_kota_mhs'),
            'bpk_mhs' => $this->put('bpk_mhs'),
            'add_bpk_mhs' => $this->put('add_bpk_mhs'),
            'kel_bpk' => $this->put('kel_bpk'),
            'kec_bpk' => $this->put('kec_bpk'),
            'kota_bpk' => $this->put('kota_bpk'),
            'ibu_mhs' => $this->put('ibu_mhs'),
            'add_ibu_mhs' => $this->put('add_ibu_mhs'),
            'kel_ibu' => $this->put('kel_ibu'),
            'kec_ibu' => $this->put('kec_ibu'),
            'kota_ibu' => $this->put('kota_ibu'),
            'tlp_mhs' => $this->put('tlp_mhs'),
            'tlp_bpk' => $this->put('tlp_bpk'),
            'tlp_ibu' => $this->put('tlp_ibu'),
            'profesi_bpk' => $this->put('profesi_bpk'),
            'profesi_ibu' => $this->put('profesi_ibu'),
            'penghasilan_bpk' => $this->put('penghasilan_bpk'),
            'email_mhs' => $this->put('email_mhs'),
            'email_ortu' => $this->put('email_ortu'),
            'kelas_kodeklas' => $this->put('kelas_kodeklas'),
            'thn_akad_thn_akad_id' => $this->put('thn_akad_thn_akad_id'),
            'usr_name' => $this->put('usr_name'),
            'password' => $this->put('password'),
            'pin' => $this->put('pin'),
            'prodi_prodi_id' => $this->put('prodi_prodi_id')
        );

        if($this->mahasiswa->update($data) > 0){
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'mahasiswa Has Been Updated',
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
        $nim = $this->delete('nim');

        if($nim === NULL){
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an NIM'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->mahasiswa->delete($nim) > 0){
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'responseData' => $nim
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'NIM Not Found',
                    'responseData' => $nim
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    function verif_post(){
        $nim = $this->post('nim');
        $pin = $this->post('pin');
        $data = $this->mahasiswa->verifMahasiswa($nim, $pin);
        $this->response(['jumlah'=>$data]);
    }
}
?>