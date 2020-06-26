<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class AbsenMhsModel extends CI_Model{

	public function getAbsenMhs($mahasiswa_nim = NULL, $absensi_kd_absendsn = NULL){
		if($mahasiswa_nim === NULL || $absensi_kd_absendsn === NULL){
			$all = $this->db->get('tik.absen_mhs')->result_array();
			return $all;
		} else {
			$this->db->where('mahasiswa_nim', $mahasiswa_nim);
			$this->db->where('absensi_kd_absendsn', $absensi_kd_absendsn);
			$data = $this->db->get('tik.absen_mhs')->result_array();
			return $data;
		}
	}

	public function getAbsenMhsInKelas($absensi_kd_absendsn){
		$this->db->select('m.nama_mhs, am.mahasiswa_nim, am.status');
		$this->db->from('tik.absen_mhs as am');
		$this->db->join('tik.mahasiswa as m','am.mahasiswa_nim=m.nim');
		$this->db->where('absensi_kd_absendsn', $absensi_kd_absendsn);
		return $this->db->get()->result_array();
	}

	public function insert($data){
		$insert = $this->db->insert('tik.absen_mhs', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('mahasiswa_nim', $data['mahasiswa_nim']);
		$this->db->where('absensi_kd_absendsn', $data['absensi_kd_absendsn']);
		$update = $this->db->update('tik.absen_mhs', $data);
		return $this->db->affected_rows();
	}

	public function delete($mahasiswa_nim, $absensi_kd_absendsn){
		$this->db->where('mahasiswa_nim', $mahasiswa_nim);
		$this->db->where('absensi_kd_absendsn', $absensi_kd_absendsn);
		$delete = $this->db->delete('tik.absen_mhs');
		return $this->db->affected_rows();
	}
}

 ?>