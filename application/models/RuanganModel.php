<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class RuanganModel extends CI_Model{

	public function getRuangan($id = NULL){
		if($id === NULL){
			$all = $this->db->get('tik.ruangan')->result_array();
			return $all;
		} else {
			$this->db->where('namaruang', $id);
			$data = $this->db->get('tik.ruangan')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.ruangan', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('namaruang', $data['namaruang']);
		$update = $this->db->update('tik.ruangan', $data);
		return $this->db->affected_rows();
	}

	public function delete($id){
		$this->db->where('namaruang', $id);
		$delete = $this->db->delete('tik.ruangan');
		return $this->db->affected_rows();
	}

}
