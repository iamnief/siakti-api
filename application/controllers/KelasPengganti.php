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
        $this->response($res);
    }

    function index_post()
    {
        $data = $this->post();

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
        // $data = array(
        //     'kd_gantikls' => $this->put('kd_gantikls'),
        //     'tgl_batal' => $this->put('tgl_batal'),
        //     'jadwal_kul_kodejdwl' => $this->put('jadwal_kul_kodejdwl'),
        //     'ruangan_namaruang' => $this->put('ruangan_namaruang'),
        //     'wkt_kuliah_kode_jam' => $this->put('wkt_kuliah_kode_jam'),
        //     'tgl_pengganti' => $this->put('tgl_pengganti')
        // );

        $data = $this->put();

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

    // Dosen membatalkan kelas
    function batalkelas_post()
    {
        $post = $this->post();
        $n = 0;
        $kode = intval($post['kode']);
        $jml_jam = intval($post['jml_jam']);
        if ($post['tipe_kelas'] == 'normal') {
            for ($i = 0; $i < $jml_jam; $i++) {
                $input = array(
                    'tgl_batal' => $post['tgl_batal'],
                    'jadwal_kul_kodejdwl' => $kode + $i,
                    'status' => 'belum diajukan'
                );
                $n += $this->kls_pengganti->insert($input);
            }
        } else if ($post['tipe_kelas'] == 'pengganti') {
            for ($i = 0; $i < $jml_jam; $i++) {
                $input = array(
                    'kd_gantikls' => $kode,
                    'ruangan_namaruang' => null,
                    'wkt_kuliah_kode_jam' => null,
                    'tgl_pengganti' => null
                );
                $this->kls_pengganti->update($input);
            }
        }
        $this->response(['jml_jam' => $n]);
    }

    // KPS melihat kelas pengganti
    function prodi_get($prodi_id = '')
    {
        if ($prodi_id == '') {
            $this->response([]);
        } else {
            $this->response($this->kls_pengganti->getKelasPenggantiProdi($prodi_id));
        }
    }

    // Dosen mengajukan kelas pengganti
    function ajukan_put($update = '')
    {
        $n = 0;
        $jam = $this->put('kode_jam');
        $kd_gantikls = intval($this->put('kd_gantikls'));
        for ($i = 0; $i < count($jam); $i++) {
            $data = array(
                'tgl_pengganti' => $this->put('tgl_pengganti'),
                'ruangan_namaruang' => $this->put('namaruang'),
                'kd_gantikls' => $kd_gantikls + $i,
                'wkt_kuliah_kode_jam' => $jam[$i],
                'status' => 'diajukan'
            );
            $n += $this->kls_pengganti->update($data);
        }
        $this->response($n . ' data diupdate');
    }

    // KPS menyetujui kelas pengganti
    function verif_put()
    {
        $jml_jam = intval($this->put('jml_jam'));
        $kode = intval($this->put('kd_gantikls'));
        $n = 0;

        for ($i=0; $i < $jml_jam; $i++) { 
            # code...
            $data = array(
                'kd_gantikls' => $kode + $i,
                'status' => 'disetujui'
            );
            $n += $this->kls_pengganti->update($data);
        }
        $this->response($n . ' data diupdate');
    }
}
