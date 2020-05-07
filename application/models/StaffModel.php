<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class StaffModel extends CI_Model{

	public function getStaff($nip = NULL){
		if($nip === NULL){
			$all = $this->db->get('tik.staff')->result_array();
			return $all;
		} else {
			$this->db->where('nip', $nip);
			$data = $this->db->get('tik.staff')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.staff', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('nip', $data['nip']);
		$update = $this->db->update('tik.staff', $data);
		return $this->db->affected_rows();
	}

	public function delete($nip){
		$this->db->where('nip', $nip);
		$delete = $this->db->delete('tik.staff');
		return $this->db->affected_rows();
	}
}

 ?>