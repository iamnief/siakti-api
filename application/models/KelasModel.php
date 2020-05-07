<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class KelasModel extends CI_Model{

	public function getKelas($kode_kls = NULL){
		if($kode_kls === NULL){
			$all = $this->db->get('tik.kelas')->result_array();
			return $all;
		} else {
			$this->db->where('kodeklas', $kode_kls);
			$data = $this->db->get('tik.kelas')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.kelas', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kodeklas', $data['kodeklas']);
		$update = $this->db->update('tik.kelas', $data);
		return $this->db->affected_rows();
	}

	public function delete($kode_kls){
		$this->db->where('kodeklas', $kode_kls);
		$delete = $this->db->delete('tik.kelas');
		return $this->db->affected_rows();
	}
}

 ?>