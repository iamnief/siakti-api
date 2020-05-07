<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class TahunAkadModel extends CI_Model{

	public function getSemester($id = NULL){
		$all = $this->db->get('tik.semester')->result_array();
		return $all;
	}

	public function insert($data){
		$insert = $this->db->insert('tik.semester', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('semester_nm', $data['semester_nm']);
		$update = $this->db->update('tik.semester', $data);
		return $this->db->affected_rows();
	}

	public function delete($id){
		$this->db->where('semester_nm', $id);
		$delete = $this->db->delete('tik.semester');
		return $this->db->affected_rows();
	}
}

 ?>