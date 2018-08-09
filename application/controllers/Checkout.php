<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class checkout extends CI_Controller {

	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		$this->load->library('cart');
    }

	

	function finish() 
	{
		$this->load->view('front/checkout');
	}
	
	
}

?>