<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class about extends CI_Controller {

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
    		$data['data_about']=$this->master_model->select_in('ms_about', '*', "WHERE ID=1");
    		$this->load->view('admin/about/main', $data);
	    }
	}
	
	function insert($menuid)
	{		
		$this->load->view('admin/about/insert');
	}
	
	function update_process($menuid, $ID)
	{
		$name=$this->input->post('name');
		
		//$ID=$this->master_model->mst_last_id('ms_about');
		
		$data=array
		(
			'name'  => $name,
			'note'  => $this->input->post('desc'),
		);
		$this->db->where('ID',$ID);
		$this->db->update('ms_about', $data);
		
		redirect('admin/about/index/'.$menuid);
	}
	
	
	function edit($menuid, $ID)
	{		
		$data['data_edit']=$this->master_model->mst_data_edit('ms_about', $ID);
		$this->load->view('admin/about/edit', $data);
	}
	
	function next($menuid, $ID)
	{
		$ID=$ID+1;
		
		redirect('admin/about/edit/'.$menuid.'/'.$ID);
	}
	
	function previous($menuid, $ID)
	{
		$ID=$ID-1;
		
		redirect('admin/about/index/'.$menuid.'/'.$ID);
	}
	
	function edit_process($menuid, $ID)
	{
		$name=$this->input->post('name');
		$name_e=$this->input->post('name_e');
		
		$data=array
		(
			'name'  => $name,
			'name_e'=> $name_e,
			'note'  => $this->input->post('desc'),
			'note_e'=> $this->input->post('desc2'),
		);
		
		$this->db->where('ID', $ID);
		$this->db->update('ms_about', $data);
		
		redirect('admin/about/index/'.$menuid);
	}
	
	function update($menuid)
	{
		$ID          = $this->input->post('ID');
		$sort       	= $this->input->post('sort');


		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_about', "sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/about/index/'.$menuid);
	}
	
	function publish($menuid, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_about');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_about');
		}
		redirect('admin/about/index/'.$menuid);
	}

}
?>