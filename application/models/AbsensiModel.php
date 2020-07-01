<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class AbsensiModel extends CI_Model{

	public function getAbsensi($kd_absendsn = NULL){
		if($kd_absendsn === NULL){
			$all = $this->db->get('tik.absensi')->result_array();
			return $all;
		} else {
			$this->db->where('kd_absendsn', $kd_absendsn);
			$data = $this->db->get('tik.absensi')->result_array();
			return $data;
		}
	}

	public function getAbsensiByTglJad($data_absensi){
		if($data_absensi == NULL || !is_array($data_absensi)){
			return null;
		} else {
			$this->db->select('*');
			$this->db->from('tik.absensi');
			$this->db->where($data_absensi);
			$data = $this->db->get()->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.absensi', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kd_absendsn', $data['kd_absendsn']);
		$update = $this->db->update('tik.absensi', $data);
		return $this->db->affected_rows();
	}

	public function delete($kd_absendsn){
		$this->db->where('kd_absendsn', $kd_absendsn);
		$delete = $this->db->delete('tik.absensi');
		return $this->db->affected_rows();
	}
}

 ?>