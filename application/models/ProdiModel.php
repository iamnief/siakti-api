<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class ProdiModel extends CI_Model{

	public function getProdi($id = NULL){
		if($id === NULL){
			$all = $this->db->get('tik.prodi')->result_array();
			return $all;
		} else {
			$this->db->where('prodi_id', $id);
			$data = $this->db->get('tik.prodi')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.prodi', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('prodi_id', $data['prodi_id']);
		$update = $this->db->update('tik.prodi', $data);
		return $this->db->affected_rows();
	}

	public function delete($id){
		$this->db->where('prodi_id', $id);
		$delete = $this->db->delete('tik.prodi');
		return $this->db->affected_rows();
	}
}

 ?>