<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class AbsensiModel extends CI_Model{

	public function getAbsensi($kd_absendsn = NULL){
		if($kd_absendsn === NULL){
			$all = $this->db->get('tik.absensi')->result_array();
			return $all;
		} else {
			$this->db->where('kd_absendsn', $kd_absendsn);
			$data = $this->db->get('tik.absensi')->result_array();
			return $data;
		}
	}

	public function getAbsensiByTglJad($data_absensi){
		if($data_absensi == NULL || !is_array($data_absensi)){
			return null;
		} else {
			$this->db->select('*');
			$this->db->from('tik.absensi');
			$this->db->where($data_absensi);
			$data = $this->db->get()->result_array();
			return $data;
		}
	}

	public function getPerkuliahanProdi($prodi_id){
		$this->db->select('a.tgl, a.jam_msk, a.jam_keluar, a.materi, kls.namaklas, st.nama, mk.namamk');
		$this->db->from('tik.absensi as a');
		$this->db->join('tik.jadwal_kul as jk', 'a.jadwal_kul_kodejdwl = jk.kodejdwl');
		$this->db->join('tik.kelas as kls', 'jk.kelas_kodeklas = kls.kodeklas');
		$this->db->join('tik.matakuliah as mk', 'jk.matakuliah_kodemk = mk.kodemk');
		$this->db->join('tik.staff as st', 'jk.staff_nip = st.nip');
		$this->db->where('kls.prodi_prodi_id', $prodi_id);
		$this->db->where('a.status', null);
		$this->db->order_by('a.tgl, a.jam_msk, kls.namaklas');
		return $this->db->get()->result_array();
	}

	public function insert($data){
		$insert = $this->db->insert('tik.absensi', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kd_absendsn', $data['kd_absendsn']);
		$update = $this->db->update('tik.absensi', $data);
		return $this->db->affected_rows();
	}

	public function delete($kd_absendsn){
		$this->db->where('kd_absendsn', $kd_absendsn);
		$delete = $this->db->delete('tik.absensi');
		return $this->db->affected_rows();
	}
}

 ?>