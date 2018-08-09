<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class menu extends CI_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('admin/master_model');	

		$this->load->library('upload');



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
    		$data['data_menu']=$this->master_model->select_in('ms_menu','*',"WHERE menu_level=1");
    		$this->load->view('admin/menu/main',$data);
	    }
	}

	

	public function insert_menu($menuid)
	{
		$ID=$this->master_model->mst_last_id('ms_menu');

		$data=array
		(
			'ID'=>$ID,
			'name'=>$this->input->post('name'),
			'menu_level'=>1,
			'parent_number'=>0,
			'sort'=>$ID,
			'controller'=>$this->input->post('controller'),
			'type'=>'B',
			'icon'=>$this->input->post('icon'),
		);

		$this->db->insert('ms_menu', $data);
		
		$data_group=$this->master_model->mst_data('user_group');
		
		for($a=0; $a < count($data_group); $a++)
		{
			$id_group=$data_group[$a]->ID;
			
			if($id_group==1)
			{
				$flg=1;
			}else
			{
				$flg=0;
			}
			
			$id_detail_group=$this->master_model->mst_last_id('user_group_detail');
			$data_group=array
			(
				'ID'	   =>$id_detail_group,
				'id_group' =>$id_group,
				'id_menu'  =>$ID,
				'read_flg' =>$flg,
				'sort'     =>$id_detail_group
			);
			
			$this->db->insert('user_group_detail', $data_group);
		}
		
		redirect('admin/menu/index/'.$menuid);
	}

	

	function edit_menu($menuid)
	{
		$ID=$this->input->post('ID');

		

		$data_edit=$this->master_model->mst_data_edit('ms_menu',$ID);

		

		echo'

			<div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 class="modal-title">Edit Menu</h4>

            </div>

			<form action='.base_url().'admin/menu/edit_menu_proccess/'.$menuid.'/'.$ID.'" method="post" enctype="multipart/form-data">

				<div class="modal-body">

					<script>

						$(document).ready(function()

						{

							$(".mirror").on("keypress change", function(event)

							{

								var data=$(this).val();

								$(".mirror2").val(data);

							});

						});

					</script>

					<div class="form-group">

						<label>Name *</label>

						<input type="text" name="name" class="form-control mirror" placeholder="Nama Menu" required="required" value="'.$data_edit[0]->name.'">

					</div>

					

					<div class="form-group">

						<label>Controller *</label>

						<input type="text" name="controller" class="form-control mirror2" placeholder="Kontrol Menu" required="required" value="'.$data_edit[0]->controller.'">

					</div>

					

					<div class="form-group">

						<label>Icon</label>

						<input type="text" name="icon" class="form-control" placeholder="Icon" value="'.$data_edit[0]->icon.'">

					</div>

					

				</div>

				<div class="modal-footer">

					<input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">

					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px;">Close</button>

				</div>

			</form>

		';

	}

	

	public function edit_menu_proccess($menuid, $ID)

	{

		$data=array

		(

			'name'=>$this->input->post('name'),

			'controller'=>$this->input->post('controller'),

			'icon'=>$this->input->post('icon'),

		);

		

		$this->db->where('ID', $ID);

		$this->db->update('ms_menu', $data);

		

		redirect('admin/menu/index/'.$menuid);

	}

	

	public function delete_menu($menuid, $ID)
	{		
		$this->db->where('ID', $ID);
		$this->db->delete('ms_menu');

		$this->db->where('parent_number', $ID);
		$this->db->delete('ms_menu');
		
		$this->db->where('id_menu', $ID);
		$this->db->delete('user_group_detail');

		redirect('admin/menu/index/'.$menuid);
	}

	function update_menu($menuid)
	{
		$ID          = $this->input->post('ID');
		$sort       	= $this->input->post('sort');


		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_menu', "sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/menu/index/'.$menuid);
	}

	

	function sub_menu($menuid, $id_parent)

	{
		$data['data_menu']=$this->master_model->select_in('ms_menu','*',"WHERE menu_level=2 AND parent_number=$id_parent");

		

		$this->load->view('admin/menu/sub_menu',$data);

	}

	

	function insert_sub_menu($menuid, $id_category)

	{
		$ID=$this->master_model->mst_last_id('ms_menu');

		$data=array
		(
			'ID'=>$ID,
			'name'=>$this->input->post('name'),
			'name_e'=>$this->input->post('name'),
			'menu_level'=>2,
			'parent_number'=>$this->input->post('category'),
			'sort'=>$ID,
			'controller'=>$this->input->post('controller'),
			'type'=>'B',
		);

		$this->db->insert('ms_menu', $data);
		
		
		$data_group=$this->master_model->mst_data('user_group');
		
		for($a=0; $a < count($data_group); $a++)
		{
			$id_group=$data_group[$a]->ID;
			
			if($id_group==1)
			{
				$flg=1;
			}else
			{
				$flg=0;
			}
			
			$id_detail_group=$this->master_model->mst_last_id('user_group_detail');
			$data_group=array
			(
				'ID'	   =>$id_detail_group,
				'id_group' =>$id_group,
				'id_menu'  =>$ID,
				'read_flg' =>$flg,
				'sort'     =>$id_detail_group
			);
			
			$this->db->insert('user_group_detail', $data_group);
		}
		
		redirect('admin/menu/sub_menu/'.$menuid.'/'.$id_category);
	}

	

	function edit_sub_menu($menuid, $id_category)

	{
		$ID=$this->input->post('ID');

		

		$data_edit=$this->master_model->mst_data_edit('ms_menu',$ID);

		

		echo'

			<div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 class="modal-title">Edit Menu</h4>

            </div>

			<form action='.base_url().'admin/menu/edit_sub_menu_proccess/'.$menuid.'/'.$id_category.'/'.$ID.'" method="post" enctype="multipart/form-data">

				<div class="modal-body">

					<script>

						$(document).ready(function()

						{

							$(".mirror").on("keypress change", function(event)

							{

								var data=$(this).val();

								$(".mirror2").val(data);

							});

						});

					</script>

					<div class="form-group">

						<label>Name *</label>

						<input type="text" name="name" class="form-control mirror" placeholder="Nama Menu" required="required" value="'.$data_edit[0]->name.'">

					</div>
					
					
					<div class="form-group">
						<label>Kategori *</label>
						<select name="category" class="form-control">
							';
								$data_menu=$this->master_model->select_in('ms_menu','ID, name',"WHERE menu_level=1");
								for($a=0; $a < count($data_menu); $a++)
								{
									$ID=$data_menu[$a]->ID;
									$name=$data_menu[$a]->name;

									if($id_category==$ID)
									{
										$select='selected="selected"';
									}else
									{
										$select='';
									}
									echo'
										<option value="'.$ID.'" '.$select.'>'.$name.'</option>
									';
								}
							echo'
						</select>
					</div>

					

					<div class="form-group">

						<label>Controller *</label>

						<input type="text" name="controller" class="form-control mirror2" placeholder="Kontrol Menu" required="required" value="'.$data_edit[0]->controller.'">

					</div>

					

				</div>

				<div class="modal-footer">

					<input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">

					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px;">Close</button>

				</div>

			</form>

		';

	}

	

	public function edit_sub_menu_proccess($menuid, $id_category, $ID)
	{
		$data=array
		(
			'name'=>$this->input->post('name'),
			'controller'=>$this->input->post('controller'),
			'parent_number'=>$this->input->post('category'),
		);

		$this->db->where('ID', $ID);
		$this->db->update('ms_menu', $data);

		redirect('admin/menu/sub_menu/'.$menuid.'/'.$id_category);
	}

	

	public function delete_sub_menu($menuid, $id_category, $ID)
	{		
		$this->db->where('ID', $ID);
		$this->db->delete('ms_menu');

		$this->db->where('id_menu', $ID);
		$this->db->delete('user_group_detail');
		
		redirect('admin/menu/sub_menu/'.$menuid.'/'.$id_category);

	}

	function update_sub_menu($menuid, $id_category)
	{
		$ID          = $this->input->post('ID');
		$sort       	= $this->input->post('sort');


		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_menu', "sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/menu/index/'.$menuid.'/'.$id_category);
	}


	function publish($menuid, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_menu');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_menu');
		}
		redirect('admin/menu/index/'.$menuid);
	}
	
	function publish_sub($menuid, $id_category, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_menu');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_menu');
		}
		redirect('admin/menu/sub_menu/'.$menuid.'/'.$id_category);
	}

}



?>