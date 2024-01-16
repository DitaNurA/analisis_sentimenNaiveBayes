<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct() {
        parent::__construct();
        
          redirect('naivebayes');
          /*if($this->session->userdata('login')!==NULL){
        }*/
    }
	public function index(){
    
        $this->load->view("dashboard");
    }
}
