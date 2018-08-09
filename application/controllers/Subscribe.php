<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class subscribe extends CI_Controller {
	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		
    }
	
	function index()
	{
		$email=$this->input->post('email');
		
		$check_customer=$this->master_model->mst_check('ms_customer', 'email', $email);
		
		if($check_customer==false)
		{
			$ID=$this->master_model->mst_last_id('ms_customer');
			$data=array
			(
				'ID'=>$ID,
				'email'=>$email,
				'status'=>0,
				'sort'=>$ID,
			);
			$this->db->insert('ms_customer', $data);
			
			echo'sucess';
		}else
		{
			echo'failed';
		}
	}
	
}
?>