<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class group extends CI_Controller {
    function __construct()

	{

        parent::__construct();

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
    		$data['data_menu']      = $this->master_model->select_in('ms_menu','ID, name',"WHERE parent_number=0 AND type='B' ORDER BY sort ASC");
    	 	$data['usergroupmst'] = $this->master_model->select_in('user_group','ID, name',"WHERE ID <> '1' ORDER BY name ASC");
    		$this->load->view('admin/group/main', $data);
	    }

	}

	
	function insert_group_process($menuid)
	{
		$read_flg     = $this->input->post('read_flg');
		
		$ID = $this->master_model->mst_last_id('user_group');

		$data = array
		(
			'ID'   => $ID,
			'name' => $this->input->post('name'),
			'sort'   => $ID,
		);

		$this->db->insert('user_group', $data);

		$data_menu=$this->master_model->mst_data('ms_menu');
		for($a=0; $a < count($data_menu); $a++)
		{
			$id_menu=$data_menu[$a]->ID;
			
			$id_detail=$this->master_model->mst_last_id('user_group_detail');
			$data=array(
				'ID' => $id_detail,
				'id_group'=> $ID,
				'id_menu'=> $id_menu,
				'read_flg'=> 0,
				'sort'=> $id_detail
			);
			
			$this->db->insert('user_group_detail', $data);
		}
		
		for($b=0; $b < count($read_flg); $b++)
		{
			$this->set_checked($ID, $read_flg);
		}
		

		//$this->admin_group_model->InsertUserGroupDetail($UserGroupID);

		//$this->SetChecked($UserGroupID, $ReadFlg);

		redirect('admin/group/index/'.$menuid);
	}
	
	
	
	function insert_group()
	{
		$data_menu=$this->master_model->mst_data('ms_menu');
		for($a=0; $a < count($data_menu); $a++)
		{
			$id_menu=$data_menu[$a]->ID;
			$id_detail=$this->master_model->mst_last_id('user_group_detail');
			$data=array(
				'ID' => $id_detail,
				'id_group'=> 2,
				'id_menu'=> $id_menu,
				'read_flg'=> 1,
				'sort'=> $id_detail
			);
			
			$this->db->insert('user_group_detail', $data);
		}
		
	}
	
	function change_password_2()
	{
		$password=md5(sha1('1234'));
		
		echo $password;
	}

	

	function edit_process_group($menuid, $ID)
	{		
		//print_array($this->input->post());
		//exit;
		
		$name		 = $this->input->post('name');
		$read_flg     = $this->input->post('read_flg');
		
		$data=array(
			'name'=>$name,
		);
		$this->db->where('ID', $ID);
		$this->db->update('user_group', $data);
		
		$this->master_model->set_null_detail($ID);
			
		$this->set_checked($ID, $this->input->post('read_flg'));
		
		//$this->set_checked($ID, $this->input->post('read_flg'));
		
		redirect('admin/group/index/'.$menuid);
	}

	

	function set_checked($ID, $read_flg)
	{
		$strBaca = "";
		
		for ($i=0; $i < count($read_flg); $i++)
		{
			$strBaca = $strBaca."'".$read_flg[$i]."',";
		}

		$read_flg = substr($strBaca, 1, strlen($strBaca)-3);

		$this->master_model->update_user_group_detail($ID, $read_flg);
	}

	

	public function delete_group($menuid, $ID)
	{
		$this->db->where('ID', $ID);

		$this->db->delete('user_group');

		$this->db->where('id_group', $ID);
		$this->db->delete('user_group_detail');
		
		$this->db->where('id_group', $ID);
		$this->db->delete('user');
		
	  	redirect('admin/group/index/'.$menuid);
	}
	
	
	function edit_group($menuid)
	{
		$ID=$this->input->post('ID');
		
		$data['data_edit'] = $this->master_model->edit_group_detail($ID);
		$data['menuid'] = $menuid;
		$data['ID'] = $ID;
		
		$this->load->view('admin/group/group_edit', $data);
	}
	

	function edit_group_process($menuid,$UserGroupID)
	{
		$MenuID      = $this->input->post('MenuID');
		
		$ReadFlg     = $this->input->post('ReadFlg');

		$UserGroupName = $this->input->post('UserGroupName');



		$this->admin_group_model->SetNullUserGroupDetail($UserGroupID);

		$this->SetChecked($UserGroupID, $ReadFlg);

		$dataUserGroup=array(
			'UserGroupName'=>$UserGroupName,
		);

		$this->db->where('UserGroupID', $UserGroupID);

		$this->db->update('usergroupmst', $dataUserGroup);


		redirect('admin/useradmin/usergroup/'.$menuid);
	}


	

	public function user($menuid, $id_group)

	{
		$data['data_user']		    = $this->master_model->select_in('user','*',"WHERE id_group=$id_group AND ID<>1 ORDER BY ID ASC");

		$this->load->view('admin/group/user',$data);
	}
	
	public function edit_user($menuid, $err='')
	{
		$ID   = $this->input->post('ID');

		$data_edit = $this->master_model->mst_data_edit('user',$ID);
		$id_group=$data_edit[0]->id_group;
		
		echo '
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit User</h4>
		</div>
		<div class="modal-body">

			<form action="'.base_url().'admin/groudp/edit_proccess_user/'.$menuid.'/'.$ID.'" method="post" name="createUser" class="contact">

				<div class="form-group">
					<label>Nama User</label>
					<input type="text" name="name" id="name" class="form-control" value="'.$data_edit[0]->name.'">
				</div>

				<div class="form-group">
					<label>Password</label>
					';
					?>
					<div class="form-group input-group">
						<input type="password" id="password2" name="password" class="form-control" required placeholder="Password" autocomplete="off"/>
						<label class="input-group-addon">
						  <input type="checkbox" style="display:none"
							onclick="(function(e, el){
							  document.getElementById('password2').type = el.checked ? 'text' : 'password';
							  el.parentNode.lastElementChild.innerHTML = el.checked ? '<i class=\'glyphicon glyphicon-eye-close\'>' : '<i class=\'glyphicon glyphicon-eye-open\'>';
							  })(event, this)">
						   <span><i class="glyphicon glyphicon-eye-open"></i></span>
						</label>
					</div>
                    <?php
					echo'
				</div>

				<div class="form-group">
					<label> Type </label>
					<select name="UserGroupID" id="UserGroupID" required class="form-control">
						'; 
							$data_group = $this->master_model->select_in('user_group','*',"WHERE ID <> 1");

							for($a=0; $a < count($data_group); $a++)
							{
								$ID   = $data_group[$a]->ID;
								$name = $data_group[$a]->name;
								
								if($id_group == $ID)
								{
									$selected='selected="selected"';
								}else
								{
									$selected='';
								}
								echo ' <option value="'.$ID.'" '.$selected.'>'.$name.'</option>';
							}
						echo'
					</select>
				</div>
        	</form>
		</div>
		<div class="modal-footer">
			<input type="submit" class="btn btn-info btn-fill pull-right" value="Simpan" id="save">
			<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px;">Tutup</button>
		</div>
		';
	}
	
	public function delete_user($menuid, $id_group, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('user');
		
		redirect('admin/group/user/'.$menuid.'/'.$id_group);
	}
	
	public function reset_password($menuid, $id_group, $ID)
	{
		$password=md5(sha1(123));
		
		$data=array
		(
			'password'=>$password
		);
		$this->db->where('ID', $ID);
		$this->db->update('user', $data);
		
		redirect('admin/group/user/'.$menuid.'/'.$id_group);
	}
	
	public function change_password($menuid)
	{
		$this->load->view('admin/group/change_password');
	}
	
	public function get_password($menuid, $id_admin)
	{
		$password=$this->input->post('password');
		
		//echo $password;
		
		$password=md5(sha1($password));
		
		$get_passord=$this->master_model->select_in('user','ID',"WHERE ID=$id_admin AND password='$password'");
		$count=count($get_passord);
		
		echo $count;
	}
	
	public function change_password_proccess($menuid, $id_admin)
	{
		$data=array
		(
			'password'=>md5(sha1($this->input->post('password'))),
		);
		$this->db->where('ID',$id_admin);
		$this->db->update('user',$data);
		
		redirect('admin/group/change_password/'.$menuid);
	}
	
	
	public function create_user($menuid, $id_group)
	{
		$ID=$this->master_model->mst_last_id('user');
		$data = array(
			'ID'		   => $ID,
			'name'         => $this->input->post('name'),
			'password'     => md5(sha1($this->input->post('password'))),
			'id_group'     => $id_group,
			'since'        => date('Y-m-d'),
			'sort'		 => $ID,
		);
		$this->db->insert('user', $data);
		$confirmText = "new user added";
		
		redirect('admin/group/user/'.$menuid.'/'.$id_group);
	}

}

?>