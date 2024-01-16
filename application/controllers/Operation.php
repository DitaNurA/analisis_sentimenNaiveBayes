<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operation extends CI_Controller {
	function __construct() {
    parent::__construct();
	$this->load->model('NaiveBayes_Model');
	}
	public function savedata(){
		if($this->input->is_ajax_request()){
			$temp = array();
			$index=$this->input->post('index');
			$data=$this->input->post('data');
			//$this->db->truncate("dataset");
			$this->db->insert_batch("dataset",$data);
		}else{
			show_404();
		}
	}
    public function deleteAllData() {
        $this->NaiveBayes_Model->deleteAllData();
        redirect('NaiveBayes/dataset');
    }
}
