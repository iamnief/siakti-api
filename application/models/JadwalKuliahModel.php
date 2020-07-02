<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class JadwalKuliahModel extends CI_Model{

	public function getJadwalKuliah($kodejdwl = NULL){
		if($kodejdwl === NULL){
			$all = $this->db->get('tik.jadwal_kul')->result_array();
			return $all;
		} else {
			$this->db->where('kodejdwl', $kodejdwl);
			$data = $this->db->get('tik.jadwal_kul')->result_array();
			return $data;
		}
	}

	public function getJamIsi($kode, $hari, $pilih){
		$this->db->select('wkt_kuliah_kode_jam as kode_jam');
		$this->db->from('tik.jadwal_kul');
		$this->db->where('hari', $hari);
		if ($pilih == 'ruangan'){
			$this->db->where('ruangan_namaruang', $kode);
		} else if ($pilih == 'kelas'){
			$this->db->where('kelas_kodeklas', $kode);
		} else if ($pilih == 'dosen'){
			$this->db->where('staff_nip', $kode);
		} else {
			return [];
		}
		$this->db->order_by('wkt_kuliah_kode_jam');
		return $this->db->get()->result_array();
	}

	public function getJadwalForAbsen($thn_akad_id, $namaruang, $hari, $waktu){
		$this->db->select('jk.kodejdwl, jk.kelas_kodeklas, jk.matakuliah_kodemk, 
		wk.jam_mulai, wk.jam_selesai');
		$this->db->from('tik.jadwal_kul as jk');
		$this->db->join('tik.wkt_kuliah as wk', 'jk.wkt_kuliah_kode_jam = wk.kode_jam');
		$this->db->where('jk.thn_akad_thn_akad_id', $thn_akad_id);
		$this->db->where('jk.ruangan_namaruang', $namaruang);
		$this->db->where('jk.hari', $hari);
		$this->db->where('wk.jam_mulai <=', $waktu);
		$this->db->where('wk.jam_selesai >=', $waktu);
		$data = $this->db->get()->result_array();

		if (count($data) <= 0) return $data;
		else {
			return $this->getJadwalForAbsen2(
				$thn_akad_id, 
				$namaruang, 
				$hari, 
				$data[0]['kelas_kodeklas'],
				$data[0]['matakuliah_kodemk']
			);
		}
	}

	public function getJadwalForAbsen2($thn_akad_id, $namaruang, $hari, $kodeklas, $kodemk){
		$this->db->select('min(jk.kodejdwl) as kodejdwl, jk.kelas_kodeklas, kls.namaklas, mk.namamk');
		$this->db->from('tik.jadwal_kul as jk');
		$this->db->join('tik.kelas as kls', 'jk.kelas_kodeklas = kls.kodeklas');
		$this->db->join('tik.matakuliah as mk', 'jk.matakuliah_kodemk = mk.kodemk');
		$this->db->group_by('jk.kelas_kodeklas, kls.namaklas, mk.namamk');
		$this->db->where('jk.thn_akad_thn_akad_id', $thn_akad_id);
		$this->db->where('jk.ruangan_namaruang', $namaruang);
		$this->db->where('jk.hari', $hari);
		$this->db->where('jk.kelas_kodeklas', $kodeklas);
		$this->db->where('jk.matakuliah_kodemk', $kodemk);
		return $this->db->get()->result_array();
	}

	public function getJadwalKuliahMahasiswa($thn_akad_id ,$kodeklas, $hari){
		$this->db->select('min(wk.jam_mulai) as jam_mulai, max(wk.jam_selesai) as jam_selesai, 
			jk.ruangan_namaruang, mk.namamk, min(jk.kodejdwl) as kodejdwl, st.nama as nama_dosen');
		$this->db->from('tik.jadwal_kul as jk');
		$this->db->join('tik.matakuliah as mk', 'jk.matakuliah_kodemk = mk.kodemk');
		$this->db->join('tik.staff as st', 'jk.staff_nip = st.nip');
		$this->db->join('tik.wkt_kuliah as wk', 'jk.wkt_kuliah_kode_jam = wk.kode_jam');
		$this->db->group_by('jk.ruangan_namaruang, mk.namamk, st.nama');
		$this->db->where('jk.thn_akad_thn_akad_id', $thn_akad_id);
		$this->db->where('jk.kelas_kodeklas', $kodeklas);
		$this->db->where('hari', $hari);
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function getJadwalKuliahDosen($thn_akad_id ,$nip, $hari, $tgl){
		$absensi = "(select * from tik.absensi where tgl = '".$tgl."') as ab";

		$this->db->select('min(jk.kodejdwl) as kodejdwl, min(wk.jam_mulai) as jam_mulai, 
			max(wk.jam_selesai) as jam_selesai, jk.ruangan_namaruang, mk.namamk, 
			kls.kodeklas, kls.namaklas, count(wk.jam_mulai) as jml_jam, max(ab.kd_absendsn) as kd_absendsn, 
			min(ab.jam_msk) as abs_jam_msk, max(ab.jam_keluar) as abs_jam_keluar');
		$this->db->from('tik.jadwal_kul as jk');
		$this->db->join('tik.matakuliah as mk', 'jk.matakuliah_kodemk = mk.kodemk');
		$this->db->join('tik.kelas as kls', 'jk.kelas_kodeklas = kls.kodeklas');
		$this->db->join('tik.wkt_kuliah as wk', 'jk.wkt_kuliah_kode_jam = wk.kode_jam');
		$this->db->join($absensi, 'jk.kodejdwl = ab.jadwal_kul_kodejdwl', 'left');
		$this->db->group_by('jk.ruangan_namaruang, mk.namamk, kls.kodeklas, kls.namaklas');
		$this->db->where('jk.thn_akad_thn_akad_id', $thn_akad_id);
		$this->db->where('jk.staff_nip', $nip);
		$this->db->where('hari', $hari);
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function insert($data){
		$insert = $this->db->insert('tik.jadwal_kul', $data);
		return $this->db->affected_rows();
	}

	public function update($data){
		$this->db->where('kodejdwl', $data['kodejdwl']);
		$update = $this->db->update('tik.jadwal_kul', $data);
		return $this->db->affected_rows();
	}

	public function delete($kodejdwl){
		$this->db->where('kodejdwl', $kodejdwl);
		$delete = $this->db->delete('tik.jadwal_kul');
		return $this->db->affected_rows();
	}
}

 ?>