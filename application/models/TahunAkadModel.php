<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class TahunAkadModel extends CI_Model{

	public function getTahunAkad($id = NULL){
		if($id === NULL){
			$all = $this->db->get('tik.thn_akad')->result_array();
			return $all;
		} else {
			$this->db->where('thn_akad_id', $id);
			$data = $this->db->get('tik.thn_akad')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.tahun_akad', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('thn_akad_id', $data['thn_akad_id']);
		$update = $this->db->update('tik.thn_akad', $data);
		return $this->db->affected_rows();
	}

	public function delete($kode_jam){
		$this->db->where('thn_akad_id', $kode_jam);
		$delete = $this->db->delete('tik.thn_akad');
		return $this->db->affected_rows();
	}
}

 ?>