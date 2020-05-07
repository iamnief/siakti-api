<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class WaktuKuliahModel extends CI_Model{

	public function getWaktuKuliah($kode_jam = NULL){
		if($kode_jam === NULL){
			$all = $this->db->get('tik.wkt_kuliah')->result_array();
			return $all;
		} else {
			$this->db->where('kode_jam', $kode_jam);
			$data = $this->db->get('tik.wkt_kuliah')->result_array();
			return $data;
		}
	}

	public function insert($data){
		$insert = $this->db->insert('tik.wkt_kuliah', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kode_jam', $data['kode_jam']);
		$update = $this->db->update('tik.wkt_kuliah', $data);
		return $this->db->affected_rows();
	}

	public function delete($kode_jam){
		$this->db->where('kode_jam', $kode_jam);
		$delete = $this->db->delete('tik.wkt_kuliah');
		return $this->db->affected_rows();
	}
}

 ?>