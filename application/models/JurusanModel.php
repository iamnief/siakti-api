<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class JurusanModel extends CI_Model{

	public function getJurusan($kodejur = NULL){
		if($kodejur === NULL){
			$all = $this->db->get('tik.jurusan')->result_array();
			return $all;
		} else {
			$this->db->where('kodejur', $kodejur);
			$data = $this->db->get('tik.jurusan')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.jurusan', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kodejur', $data['kodejur']);
		$update = $this->db->update('tik.jurusan', $data);
		return $this->db->affected_rows();
	}

	public function delete($kodejur){
		$this->db->where('kodejur', $kodejur);
		$delete = $this->db->delete('tik.jurusan');
		return $this->db->affected_rows();
	}
}

 ?>