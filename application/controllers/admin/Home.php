<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class home extends CI_Controller {

	public function __construct()

	{

		parent :: __construct();	

		$this->load->model('admin/master_model');
    }


	function index($menuid, $info='')
	{	
	    $user_id = $this->session->userdata('UserID');
	    $check=$this->master_model->auth_read($user_id, $menuid);
	    
	    if($check==false)
	    {
	        redirect('admin/admin_login/redirectNoAuthUser');
	    }else
	    {
    		$this->load->view('admin/monitoring');
	    }
	}
	
	
	function read($menuid, $id_parent)
	{	
        define("menuid",$menuid);
        $user_id = $this->session->userdata('UserID');
        $this->redirectNoAuthRead($user_id, $menuid);

		$data['data_consultation']=$this->master_model->select_in('ts_consultation','*',"WHERE ID=$id_parent");
		$this->load->view('admin/read', $data);
	}

}
?>