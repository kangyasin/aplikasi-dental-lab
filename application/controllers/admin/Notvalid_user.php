<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notvalid_user extends CI_Controller {

	

	public function __construct(){

		parent::__construct();

		// code for construtct here

		$this->load->model('admin/master_model');

		$this->load->model('admin/admin_menu_model');

		$this->load->model('admin/admin_group_model');	

	}

	

	

	function redirect_user()

	{

		$this->load->view('admin/notAccessiblePage');

	}

}

?>