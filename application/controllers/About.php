<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class about extends CI_Controller {
	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		$this->load->helper('text');
		
    }
	
	function index()
	{
		$this->load->view('front/about');
	}
	
}
?>