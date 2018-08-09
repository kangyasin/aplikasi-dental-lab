<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class contact extends CI_Controller {
	public function __construct()

	{

		parent :: __construct();	

		$this->load->model('admin/master_model');
    }

	function index($menuid)
	{		
       $user_id = $this->session->userdata('UserID');
	    $check=$this->master_model->auth_read($user_id, $menuid);
	    
	    if($check==false)
	    {
	        redirect('admin/admin_login/redirectNoAuthUser');
	    }else
	    {
		    $this->load->view('admin/contact');
	    }
	}
	
	function update($menuid)
	{
		$ID=1;
		
		$data=array
		(
			'address'  =>$this->input->post('address'),
			'phone'	=>$this->input->post('phone'),
			'fax'	  =>$this->input->post('fax'),
			'email'	=>$this->input->post('email'),
			'location' =>$this->input->post('location'),
		);
		$this->db->where('ID', $ID);
		$this->db->update('ms_contact', $data);
		
		redirect('admin/contact/index/'.$menuid);
	}

}
?>