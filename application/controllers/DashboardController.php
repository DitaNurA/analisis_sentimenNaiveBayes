<?php

class Dashboard extends CI_Controller
{
    public function index()
    {
        // Logic untuk menampilkan halaman dashboard
        $var['module'] = "naivebayes/dashboard";
        $var['var_module'] = array();
        $var['content_title'] = "";
        $var['breadcrumb'] = array(
                "Home"=>"",
                "Dashboard"=>"active"
        );
        $this->load->view('main',$var);
       //$this->load->view('dashboard');
       redirect('naivebayes');
    }
}