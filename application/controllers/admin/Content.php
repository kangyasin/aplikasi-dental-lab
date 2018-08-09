<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class content extends CI_Controller {

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
    		$data['data_content']=$this->master_model->mst_data('ms_content');
    
    		$this->load->view('admin/content/main', $data);
	    }
	}

	function insert($menuid)
	{	
		$this->load->view('admin/content/insert');
	}
	
	
	public function insert_process($menuid)
	{
		$ID = $this->master_model->mst_last_id('ms_content');
			
		$data = array(
			'ID' => $ID,
			'name' => $this->input->post('name'),
			'note' => $this->input->post('desc'),
			'publish' => 1,
			'sort' => $ID
		);
		
		$this->db->insert('ms_content', $data);
		
		redirect('admin/content/index/'.$menuid);
	}
	
	
	
	function edit($menuid, $ID)
	{	 
		$data['data_edit']=$this->master_model->mst_data_edit('ms_content', $ID);
		
		$this->load->view('admin/content/edit', $data);
	}
	
	
	
	
	
	public function delete_content($menuid, $ID)
	{
		$this->db->where('ID', $ID);

		$this->db->delete('ms_content');

		redirect('admin/content/index/'.$menuid);
	}
	
	
	public function edit_process($menuid, $ID)
	{
		$data = array(
			'name' => $this->input->post('name'),
			'note' => $this->input->post('desc'),
			'publish' => 1,
		);
		
		$this->db->where('ID',$ID);
		$this->db->update('ms_content', $data);
		

		redirect('admin/content/index/'.$menuid);
	}
	
	function publish($menuid, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_content');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_content');
		}
		redirect('admin/content/index/'.$menuid);
	}
	
	function update_category($menuid)
	{
		$ID          = $this->input->post('ID');
		$sort       	= $this->input->post('sort');


		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_news_category', "sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/news/index/'.$menuid);
	}
	
}
?>