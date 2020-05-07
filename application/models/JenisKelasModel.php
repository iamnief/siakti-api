<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class JenisKelasModel extends CI_Model{

	public function getJenisKelas($namajnskls = NULL){
		if($namajnskls === NULL){
			$all = $this->db->get('tik.jns_kls')->result_array();
			return $all;
		} else {
			$this->db->where('nama_jnskls', $namajnskls);
			$data = $this->db->get('tik.jns_kls')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.jns_kls', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('nama_jnskls', $data['nama_jnskls']);
		$update = $this->db->update('tik.jns_kls', $data);
		return $this->db->affected_rows();
	}

	public function delete($namajnskls){
		$this->db->where('nama_jnskls', $namajnskls);
		$delete = $this->db->delete('tik.jns_kls');
		return $this->db->affected_rows();
	}
}

 ?>