<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class LihatJadwal extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
	}

	function LihatJadwalDosen_get(){
        // select * from tik.jadwal_kul where nip = '4617010043')
        $id = $this->get('usr_name');
        // $id = $this->session->userdata($data_session['usr_name']);
        $data = $this->db->get_where('tik.mhs_jdwal',$where)->result_array();
        $res = $data;
        $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Sukses Lihat Jadwal Dosen',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);
    }

    function LihatJadwalMahasiswa_get(){
        // select * from tik.jadwal_kul where kodejdwl in (select jadwal_kul_kodejdwl from tik.mhs_jdwal where mahasiswa_nim = '4617010043')
        $id = $this->get('usr_name');
        // $id = $this->session->userdata($data_session['usr_name']);
        #Create where clause
        $this->db->select('select jadwal_kul_kodejdwl');
        $this->db->from('tik.mhs_jdwal');
        $this->db->where('mahasiswa_nim',$id);
        $where_clause = $this->db->get_compiled_select();

        #Create main query
        $this->db->select('*');
        $this->db->from('tik.mhs_jdwal');
        $data = $this->db->get_where("`kodejdwl` IN ($where_clause)")->result_array();
        $res  = $data;
        $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Sukses Lihat Jadwal Mahasiswa',
                'responseData' => $res
            ], REST_Controller::HTTP_OK);


    }
}
?>