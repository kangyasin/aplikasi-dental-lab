<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class goal extends CI_Controller {

	public function __construct()

	{

		parent :: __construct();	

		$this->load->model('admin/master_model');

		$this->load->helper('text');

		

    }

	
	function index()
	{
		$this->load->view('front/goal_product');
	}
	
	
	function category($ID, $name)
	{
		$this->load->view('front/goal_category');
	}

	

	function detail($id_category, $ID, $name)

	{

		$this->load->view('front/goal');

	}

	

}

?>