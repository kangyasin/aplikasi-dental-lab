<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class terms extends CI_Controller {
	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		
    }
	
	function index()
	{ 
		$this->load->view('front/terms');
	}
	
}
?>