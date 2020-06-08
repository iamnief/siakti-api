<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class AbsenMhsModel extends CI_Model{

	public function getAbsenMhs($mhs_jdwal_kodemhs_jdwl = NULL, $absensi_kd_absendsn = NULL){
		if($mhs_jdwal_kodemhs_jdwl === NULL || $absensi_kd_absendsn === NULL){
			$all = $this->db->get('tik.absen_mhs')->result_array();
			return $all;
		} else {
			$this->db->where('mhs_jdwal_kodemhs_jdwl', $mhs_jdwal_kodemhs_jdwl);
			$this->db->where('absensi_kd_absendsn', $absensi_kd_absendsn);
			$data = $this->db->get('tik.absen_mhs')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.absen_mhs', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('mhs_jdwal_kodemhs_jdwl', $data['mhs_jdwal_kodemhs_jdwl']);
		$this->db->where('absensi_kd_absendsn', $data['absensi_kd_absendsn']);
		$update = $this->db->update('tik.absen_mhs', $data);
		return $this->db->affected_rows();
	}

	public function delete($mhs_jdwal_kodemhs_jdwl, $absensi_kd_absendsn){
		$this->db->where('mhs_jdwal_kodemhs_jdwl', $mhs_jdwal_kodemhs_jdwl);
		$this->db->where('absensi_kd_absendsn', $absensi_kd_absendsn);
		$delete = $this->db->delete('tik.absen_mhs');
		return $this->db->affected_rows();
	}
}

 ?>