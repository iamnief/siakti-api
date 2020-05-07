<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class KurikulumModel extends CI_Model{

	public function getKurikulum($namakur = NULL){
		if($namakur === NULL){
			$all = $this->db->get('tik.kurikulum')->result_array();
			return $all;
		} else {
			$this->db->where('namakur', $namakur);
			$data = $this->db->get('tik.kurikulum')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.kurikulum', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('namakur', $data['namakur']);
		$update = $this->db->update('tik.kurikulum', $data);
		return $this->db->affected_rows();
	}

	public function delete($namakur){
		$this->db->where('namakur', $namakur);
		$delete = $this->db->delete('tik.kurikulum');
		return $this->db->affected_rows();
	}
}

 ?>