<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class home extends CI_Controller {
    
	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		
    }
	
	public function index()
	{
	    
		$data['data_banner']=$this->master_model->mst_data('ms_banner');
		$data['data_about']=$this->master_model->mst_data('about');
		
		$this->load->view('front/home', $data);
	}
	
}
?>