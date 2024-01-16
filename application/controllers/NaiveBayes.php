<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
class NaiveBayes extends CI_Controller {
	function __construct() {
        parent::__construct();
        $database   = include ('database.php'); //config database Grocery
        $config     = include ('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
    		$this->crud->unsetBootstrap();
    		$this->crud->unsetExport();
    		$this->crud->unsetPrint();
	}
    public function index(){
        $var['module'] = "naivebayes/dashboard";
        $var['var_module'] = array();
        $var['content_title'] = "";
        $var['breadcrumb'] = array(
                "Home"=>"",
                "Dashboard"=>"active"
        );
        $this->load->view('main',$var);

    }
		public function tfidf(){
        $var['module'] = "naivebayes/tfidf";
        $var['var_module'] = array();
        $var['content_title'] = "";
        $var['breadcrumb'] = array(
                "Home"=>"",
                "TF-IDF"=>"active"
        );
        $this->load->view('main',$var);

    }
	public function process($page="dataset")
	{
      $var['module'] = "naivebayes/process";
    	$var['var_module'] = array("page"=>$page);
      $var['content_title'] = "Klasifikasi Naive Bayes";
    	$var['breadcrumb'] = array(
    			"Home"=>"",
    			"Naive Bayes"=>"active"
    	);
	    $this->load->view('main',$var);
	}
  function dataset(){
    $var = array();
		$var['gcrud'] = 1;
		$var['content_title'] = "Dataset Analisis Sentimen";
		$var['breadcrumb'] = array(
			"Data History"=>""
		);
		$var['module'] = "naivebayes/gc_dataset";
		$this->crud->setTable('dataset');
		$output = $this->crud->render();
		if ($output->isJSONResponse) {
				header('Content-Type: application/json; charset=utf-8');
				echo $output->output;
				exit;
		}
		$var['css_files']   = $output->css_files;
		$var['js_files']    = $output->js_files;
		$var['output']      = $output->output;
    
		$this->load->view('main',$var);
  }
  function export(){
    $this->load->view('module/export');
  }
  function debug(){
  }
}
