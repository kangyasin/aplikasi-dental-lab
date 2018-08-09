<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class article extends CI_Controller {

	public function __construct()

	{

		parent :: __construct();	

		$this->load->model('admin/master_model');

		$this->load->helper('text');

		

    }

	

	

	function index()

	{

		$this->load->view('front/article');

	}

	

	function detail($id_category, $ID, $name)

	{

		$this->load->view('front/news');

	}

	

	function category($ID)

	{

		$this->load->view('front/news_category');

	}

	

}

?>