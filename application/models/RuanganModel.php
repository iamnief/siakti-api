<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class RuanganModel extends CI_Model{

	public function getAll(){
		$all = $this->db->get('tik.ruangan')->result();

		$response['status'] = 200;
		$response['error'] = false;
		$response['data'] = $all;

		return $response;
	}

	public function getOne($namaruang){
		$this->db->where('namaruang', $namaruang);
		$data = $this->db->get('tik.ruangan')->result();

		$response['status'] = 200;
		$response['error'] = false;
		$response['data'] = $data;

		return $response;
	}

	public function insertNew($data){
		if (empty($data['namaruang']) || empty($data['kapasitas']) || empty($data['lokasi_gedung']) || empty($data['status']) ) {
			$msg = 'kok kosong sih';
			return $msg;
		} else{
			$insert = $this->db->insert('tik.ruangan', $data);

			if ($insert) {
				$response['status'] = 200;
				$response['error'] = false;
				$response['data'] = $data;

				return $response;
			} else{
				$response['status'] = 502;
				$response['error'] = true;
				$response['data'] = 'Gagal insert';

				return $response;
			}
		}
	}

	public function update($data){
		if (empty($data['namaruang']) || empty($data['kapasitas']) || empty($data['lokasi_gedung']) || empty($data['status']) ) {
			$msg = 'kok kosong sih';
			return $msg;
		} else{
			$this->db->where('namaruang', $data['namaruang']);
			$update = $this->db->update('tik.ruangan', $data);

			if ($update) {
				$response['status'] = 200;
				$response['error'] = false;
				$response['data'] = $data;

				return $response;
			} else{
				$response['status'] = 502;
				$response['error'] = true;
				$response['data'] = 'Gagal updet';

				return $response;
			}
		}
	}

	public function delete($namaruang){
		if ($namaruang == '') {
			$msg = 'kok kosong sih';
			return $msg;
		} else{
			$this->db->where('namaruang', $namaruang);
			$delete = $this->db->delete('tik.ruangan');

			if ($delete) {
				$response['status'] = 200;
				$response['error'] = false;
				$response['data'] = "Hapus data sukses";

				return $response;
			} else{
				$response['status'] = 502;
				$response['error'] = true;
				$response['data'] = 'Gagal delet';

				return $response;
			}
		}
	}

	public function getSarpras($namaruang){
		if ($namaruang == '') {
			$msg = 'kok kosong sih';
			return $msg;
		} else{
			
		}
	}

}

 ?>