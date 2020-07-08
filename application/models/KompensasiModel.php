<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KompensasiModel extends CI_Model
{

    var $table;

    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->table = 'tik.kompensasi';
    }

    public function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }

    public function update($data)
    {
        $this->db->where('tgl', $data['tgl']);
        $this->db->where('mahasiswa_nim', $data['mahasiswa_nim']);
        $update = $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function getKompensasi($mahasiswa_nim = '', $tgl = '')
    {
        if ($mahasiswa_nim === '' && $tgl === '') {
            $all = $this->db->get($this->table)->result_array();
            return $all;
        } else if ($mahasiswa_nim === '') {
            $this->db->where('tgl', $tgl);
            $data = $this->db->get($this->table)->result_array();
            return $data;
        } else if ($tgl === '') {
            $this->db->where('mahasiswa_nim', $mahasiswa_nim);
            $data = $this->db->get($this->table)->result_array();
            return $data;
        } else {
            $this->db->where('mahasiswa_nim', $mahasiswa_nim);
            $this->db->where('tgl', $tgl);
            $data = $this->db->get($this->table)->result_array();
            return $data;
        }
    }

    public function hitungKompen($telat = 0)
    {
        $kompen = 0;

        if ($telat < 5) {
            $kompen = $telat;
        } else if ($telat >= 5 && $telat <= 100) {
            $kompen = $telat * 5;
        } else if ($telat > 100) {
            $kompen = $telat * 2;
        }

        return $kompen;
    }

    public function updateKompenAbsen ($nim, $tgl)
    {
        $kompen = 0;
        $tak_hadir = 0;

        $absensi = $this->getAbsen($nim);
        foreach ($absensi as $key => $absen_mk) {
            # code...
            if ($absen_mk['status'] == 'Izin' || $absen_mk['status'] == 'Sakit') {
                $tak_hadir += 0;
            } else {
                $tak_hadir += intval($absen_mk['telat']);
            }
        }

        $kompen += $this->hitungKompen($tak_hadir);
        $data = array(
            'tgl' => $tgl,
            'mahasiswa_nim' => $nim,
            'kompen' => $kompen
        );

        $kompensasi = $this->getKompensasi($nim, $tgl);

        if (count($kompensasi) < 1){
            $hasil = $this->insert($data);
        } else {
            $data['kompen'] = intval($kompensasi[0]['kompen']) + $kompen;
            $hasil = $this->update($data);
        }

        return array('jumlah'=>$hasil, 'data'=>$data);
    }

    public function getAbsen($nim)
    {
        $this->db->select('am.status, am.telat, a.jam_msk, a.jam_keluar');
        $this->db->from('tik.absen_mhs as am');
        $this->db->join('tik.absensi as a', 'am.absensi_kd_absendsn = a.kd_absendsn');
        $this->db->where('am.mahasiswa_nim', $nim);
        $this->db->where('a.tgl', date('d-m-Y'));
        $data = $this->db->get()->result_array();
        return $data;
    }
}
