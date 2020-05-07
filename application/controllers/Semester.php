<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Semester extends REST_Controller{

	function __construct($config = 'rest'){
		parent::__construct($config);
		$this->load->model('SemesterModel', 'semester');
	}

	function index_get() {
        $id = $this->get('semester_nm');

        if ($id === NULL) {
            $res = $this->semester->getSemester();    
        } else{
            $res = $this->semester->getSemester($id);
        }

        if($res){
            $this->response([
                'status' => true,
                'data' => $res
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'ID Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        } 
    }

    function index_post() {
        $data = array(
            'semester_nm' => $this->post('semester_nm'),
        );

        if($this->semester->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'New Semester Has Been Created',
                'data' => $data
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to Create New Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_put(){
        $id = $this->put('semester_nm');

        $data = array(
            'semester_nm' => $id,
        );

        if($this->semester->update($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'Semester Has Been Updated',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to Update Data!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function index_delete(){
        $id = $this->delete('semester_nm');

        if($id === NULL){
            $this->response([
                'status' => false,
                'message' => 'Provide an ID'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if($this->semester->delete($id) > 0){
                $this->response([
                    'status' => true,
                    'semester_nm' => $id,
                    'message' => 'Deleted'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID Nout Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>