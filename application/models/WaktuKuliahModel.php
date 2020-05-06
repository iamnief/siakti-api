<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class WaktuKuliahModel extends CI_Model{

	public function getAll(){
		$all = $this->db->get('tik.wkt_kuliah')->result();

		if($all == NULL){
            $response['status'] = 404;
		    $response['error'] = true;
		    $response['data'] = $all;
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['data'] = $all;
        }

		return $response;
	}

	public function getOne($kode_jam){
		$this->db->where('kode_jam', $kode_jam);
        $data = $this->db->get('tik.wkt_kuliah')->result();
        
        if($data == NULL){
            $response['status'] = 404;
		    $response['error'] = true;
		    $response['data'] = 'Not Found';
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['data'] = $data;
        }

		return $response;
	}

	public function insertNew($data){
		if (empty($data['kode_jam']) || empty($data['jam_mulai']) || empty($data['jam_selesai'])) {
			$msg = 'Missing Value';
			return $msg;
		} else{
			$insert = $this->db->insert('tik.wkt_kuliah', $data);

			if ($insert) {
				$response['status'] = 200;
				$response['error'] = false;
				$response['data'] = $data;

				return $response;
			} else{
				$response['status'] = 502;
				$response['error'] = true;
				$response['data'] = 'Insert failed';

				return $response;
			}
		}
	}

	public function update($data){
		if (empty($data['kode_jam']) || empty($data['jam_mulai']) || empty($data['jam_selesai'])) {
			$msg = 'Missing Value';
			return $msg;
		} else{
			$this->db->where('kode_jam', $data['kode_jam']);
			$update = $this->db->update('tik.wkt_kuliah', $data);

			if ($update == true) {
				$response['status'] = 200;
				$response['error'] = false;
				$response['data'] = $data;

				return $response;
			} else if ($update == false){
                $response['status'] = 404;
		        $response['error'] = true;
                $response['data'] = 'Not Found';
            } else {
				$response['status'] = 502;
				$response['error'] = true;
				$response['data'] = 'Update Failed';

				return $response;
			}
		}
	}

	public function delete($kode_jam){
		if ($kode_jam == '') {
			$msg = 'Missing Value';
			return $msg;
		} else {
			$this->db->where('kode_jam', $kode_jam);
			$delete = $this->db->delete('tik.wkt_kuliah');

			if ($delete == true) {
				$response['status'] = 200;
				$response['error'] = false;
				$response['data'] = "Delete Success";

				return $response;
			} else if ($delete == false){
                $response['status'] = 404;
		        $response['error'] = true;
                $response['data'] = 'Not Found';
            } else {
				$response['status'] = 502;
				$response['error'] = true;
				$response['data'] = 'Delete Failed';

				return $response;
			}
		}
	}

}

 ?>