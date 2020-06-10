<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class KelasPengganti extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('KelasPenggantiModel', 'kls_pengganti');
    }

    function index_get()
    {
        $kd_gantikls = $this->get('kd_gantikls');

        if ($kd_gantikls === NULL) {
            $res = $this->kls_pengganti->getKelasPengganti();
        } else {
            $res = $this->kls_pengganti->getKelasPengganti($kd_gantikls);
        }

        if ($res) {
            $this->response([
                'responseCode' => '200',
                'responseDesc' => 'Success Get KelasPengganti',
                'ResponseData' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '404',
                'responseDesc' => 'kd_gantikls Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function index_post()
    {
        $data = array(
            'kd_gantikls' => $this->post('kd_gantikls'),
            'tgl_batal' => $this->post('tgl_batal'),
            'jadwal_kul_kodejdwl' => $this->post('jadwal_kul_kodejdwl'),
            'ruangan_namaruang' => $this->post('ruangan_namaruang'),
            'wkt_kuliah_kode_jam' => $this->post('wkt_kuliah_kode_jam'),
            'tgl_pengganti' => $this->post('tgl_pengganti')
        );

        if ($this->kls_pengganti->insert($data) > 0) {
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'New KelasPengganti Has Been Created',
                'ResponseData' => $data
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Create New Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_put()
    {
        $data = array(
            'kd_gantikls' => $this->put('kd_gantikls'),
            'tgl_batal' => $this->put('tgl_batal'),
            'jadwal_kul_kodejdwl' => $this->put('jadwal_kul_kodejdwl'),
            'ruangan_namaruang' => $this->put('ruangan_namaruang'),
            'wkt_kuliah_kode_jam' => $this->put('wkt_kuliah_kode_jam'),
            'tgl_pengganti' => $this->put('tgl_pengganti')
        );

        if ($this->kls_pengganti->update($data) > 0) {
            $this->response([
                'responseCode' => '00',
                'responseDesc' => 'KelasPengganti Has Been Updated',
                'ResponseData' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'responseCode' => '01',
                'responseDesc' => 'Failed to Update Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete()
    {
        $kd_gantikls = $this->delete('kd_gantikls');

        if ($kd_gantikls === NULL) {
            $this->response([
                'responseCode' => '400',
                'responseDesc' => 'Provide an kd_gantikls'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->kls_pengganti->delete($kd_gantikls) > 0) {
                $this->response([
                    'responseCode' => '00',
                    'responseDesc' => 'Deleted',
                    'ResponseData' => $kd_gantikls
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'responseCode' => '01',
                    'responseDesc' => 'kd_gantikls Not Found',
                    'responseData' => $kd_gantikls
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
