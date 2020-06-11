<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class KelasPenggantiModel extends CI_Model{

	public function getKelasPengganti($kd_gantikls = NULL){
		if($kd_gantikls === NULL){
			$all = $this->db->get('tik.kls_pengganti')->result_array();
			return $all;
		} else {
			$this->db->where('kd_gantikls', $kd_gantikls);
			$data = $this->db->get('tik.kls_pengganti')->result_array();
			return $data;
		}
	}

	public function getKelasPenggantiMahasiswa($thn_akad_id ,$kodeklas, $tgl_pengganti){
		$this->db->select('min(wk.jam_mulai) as jam_mulai, max(wk.jam_selesai) as jam_selesai, 
			kp.ruangan_namaruang, mk.namamk, 
			st.nama as nama_dosen');
		$this->db->from('tik.kls_pengganti as kp');
		$this->db->join('tik.wkt_kuliah as wk', 'kp.wkt_kuliah_kode_jam = wk.kode_jam');
		$this->db->join('tik.jadwal_kul as jk', 'kp.jadwal_kul_kodejdwl = jk.kodejdwl');
		$this->db->join('tik.matakuliah as mk', 'jk.matakuliah_kodemk = mk.kodemk');
		$this->db->join('tik.staff as st', 'jk.staff_nip = st.nip');
		$this->db->group_by('kp.ruangan_namaruang, mk.namamk, st.nama');
		$this->db->where('jk.thn_akad_thn_akad_id', $thn_akad_id);
		$this->db->where('jk.kelas_kodeklas', $kodeklas);
		$this->db->where('tgl_pengganti', $tgl_pengganti);
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function getKelasPenggantiDosen($thn_akad_id ,$nip, $tgl_pengganti){
		$this->db->select('min(wk.jam_mulai) as jam_mulai, max(wk.jam_selesai) as jam_selesai, 
			kp.ruangan_namaruang, mk.namamk, 
			kls.namaklas');
        $this->db->from('tik.kls_pengganti as kp');
        $this->db->join('tik.wkt_kuliah as wk', 'kp.wkt_kuliah_kode_jam = wk.kode_jam');
        $this->db->join('tik.jadwal_kul as jk', 'kp.jadwal_kul_kodejdwl = jk.kodejdwl');
        $this->db->join('tik.matakuliah as mk', 'jk.matakuliah_kodemk = mk.kodemk');
		$this->db->join('tik.kelas as kls', 'jk.kelas_kodeklas = kls.kodeklas');
		$this->db->group_by('kp.ruangan_namaruang, mk.namamk, kls.namaklas');
		$this->db->where('jk.thn_akad_thn_akad_id', $thn_akad_id);
		$this->db->where('jk.staff_nip', $nip);
		$this->db->where('tgl_pengganti', $tgl_pengganti);
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function insert($data){
		$insert = $this->db->insert('tik.kls_pengganti', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kd_gantikls', $data['kd_gantikls']);
		$update = $this->db->update('tik.kls_pengganti', $data);
		return $this->db->affected_rows();
	}

	public function delete($kd_gantikls){
		$this->db->where('kd_gantikls', $kd_gantikls);
		$delete = $this->db->delete('tik.kls_pengganti');
		return $this->db->affected_rows();
	}
}

 ?>