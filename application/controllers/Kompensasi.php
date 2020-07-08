<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Kompensasi extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('KompensasiModel', 'kompensasi');
    }

    function index_get($nim='', $tgl='')
    {
        $res = $this->kompensasi->getKompensasi($nim, $tgl);
        $this->response($res);
    }

    function coba_get($nim='')
    {
        // $res = $this->kompensasi->getAbsen($nim);
        $res = $this->kompensasi->hitungKompen($nim);
        $this->response($res);
    }
}
