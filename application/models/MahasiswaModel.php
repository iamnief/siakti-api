<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class MahasiswaModel extends CI_Model{

	public function getMahasiswa($nim = NULL){
		if($nim === NULL){
			$all = $this->db->get('tik.mahasiswa')->result_array();
			return $all;
		} else {
			$this->db->where('nim', $nim);
			$data = $this->db->get('tik.mahasiswa')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.mahasiswa', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('nim', $data['nim']);
		$update = $this->db->update('tik.mahasiswa', $data);
		return $this->db->affected_rows();
	}

	public function delete($nim){
		$this->db->where('nim', $nim);
		$delete = $this->db->delete('tik.mahasiswa');
		return $this->db->affected_rows();
	}
}

 ?>