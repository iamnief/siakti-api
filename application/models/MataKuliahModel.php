<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class MataKuliahModel extends CI_Model{

	public function getMataKuliah($kodemk = NULL){
		if($kodemk === NULL){
			$all = $this->db->get('tik.matakuliah')->result_array();
			return $all;
		} else {
			$this->db->where('kodemk', $kodemk);
			$data = $this->db->get('tik.matakuliah')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.matakuliah', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kodemk', $data['kodemk']);
		$update = $this->db->update('tik.matakuliah', $data);
		return $this->db->affected_rows();
	}

	public function delete($kodemk){
		$this->db->where('kodemk', $kodemk);
		$delete = $this->db->delete('tik.matakuliah');
		return $this->db->affected_rows();
	}
}

 ?>