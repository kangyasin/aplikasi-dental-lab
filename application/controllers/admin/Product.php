<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class product extends CI_Controller {
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
    		$data['category']=$this->master_model->select_in('ms_product_category', '*', "ORDER BY sort ASC");
    		$this->load->view('admin/product/main', $data);
	    }
	}
	
	function insert_category($menuid)
	{
		$ID=$this->master_model->mst_last_id('ms_product_category');
		
		$data=array
		(
			'ID'     => $ID,
			'name'   => $this->input->post('name'),
			'note'   => $this->input->post('note'),
			'sort'   => $ID
		);
		$this->db->insert('ms_product_category', $data);
		
		redirect('admin/product/index/'.$menuid);
	}
	
	function edit_category($menuid)
	{
		$ID=$this->input->post('ID');
		
		$data_edit=$this->master_model->select_in('ms_product_category', '*', "WHERE ID=$ID");
		echo'
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Edit Category</h4>
			</div>
			<form method="post" action="'.base_url().'admin/product/edit_process_category/'.$menuid.'/'.$ID.'">
				<div class="modal-body">
					<div class="form-group">
						<label>Category Name *</label>
						<input type="text" name="name" class="form-control" placeholder="Name Category" required="required" value="'.$data_edit[0]->name.'">
					</div>

					<div class="form-group">
						<label>Description</label>
						<textarea name="note" class="form-control">'.$data_edit[0]->note.'</textarea>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-info btn-fill pull-right" value="Simpan" id="save">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px">Close</button>
				</div>
			</form>
		';
	}
	
	function edit_process_category($menuid, $ID)
	{
		$data_update=array
		(
			'name'=>$this->input->post('name'),
			'note'=>$this->input->post('note')
		);
		$this->db->where('ID',$ID);
		$this->db->update('ms_product_category', $data_update);
		
		redirect('admin/product/index/'.$menuid);
	}
	
	function publish_category($menuid, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_product_category');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_product_category');
		}
		redirect('admin/product/index/'.$menuid);
	}
	
	function delete_category($menuid, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_product_category');
		
		$this->db->where('id_category', $ID);
		$this->db->delete('ms_product');
		
		redirect('admin/product/index/'.$menuid);
	}
	
	function update_category($menuid)
	{
		$ID          = $this->input->post('ID');
		$sort       	= $this->input->post('sort');


		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_product_category', "sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/product/index/'.$menuid);
	}
	
	
	function detail($menuid, $id_category)
	{	
		$data['data_product']=$this->master_model->select_in('ms_product','*',"WHERE id_category=$id_category ORDER BY ID DESC");
		$this->load->view('admin/product/detail', $data);
	}
	
	
	function insert($menuid)
	{		
		$this->load->view('admin/product/insert');
	}
	
	function insert_detail($menuid)
	{
		$submit=$this->input->post('submit');
		$id_category=$this->input->post('id_category');
		
		$ID=$this->master_model->mst_last_id('ms_product');
		
		$data=array
		(
			'ID'     => $ID,
			'id_category'   => $this->input->post('id_category'),
			'name'   => $this->input->post('name'),
			'title'   => $this->input->post('title'),
			'title2'   => $this->input->post('title2'),
			'note'   => $this->input->post('note'),
			'note2'   => $this->input->post('note2'),
			'sort'   => $ID
		);
		$this->db->insert('ms_product', $data);
		
		if($submit==1)
		{
			redirect('admin/product/detail/'.$menuid.'/'.$id_category);
		}else
		{
			redirect('admin/product/insert/'.$menuid.'/'.$id_category);
		}
	}
	
	
	function edit($menuid, $id_category, $ID)
	{		
		$data['data_edit']=$this->master_model->mst_data_edit('ms_product', $ID);
		$this->load->view('admin/product/edit', $data);
	}
	
	function edit_process($menuid, $id_category, $ID)
	{
		$name=$this->input->post('name');
		$submit=$this->input->post('submit');
		
		$data=array
		(
			'name'   => $name,
			'id_category'  => $this->input->post('id_category'),
			'title'   => $this->input->post('title'),
			'title2'   => $this->input->post('title2'),
			'note'   => $this->input->post('note'),
			'note2'   => $this->input->post('note2'),
		);
		$this->db->where('ID', $ID);
		$this->db->update('ms_product', $data);
		
		
		if($submit==1)
		{
			redirect('admin/product/detail/'.$menuid.'/'.$id_category);
		}else
		{
			redirect('admin/product/insert/'.$menuid.'/'.$id_category);
		}
	}
	
	
	function update($menuid, $id_category)
	{
		$ID          = $this->input->post('ID');
		$price       	= $this->input->post('price');
		$sort       	= $this->input->post('sort');

		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_product', "price='$price[$a]', sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/product/detail/'.$menuid.'/'.$id_category);
	}
	
	function publish($menuid, $id_category, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_product');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_product');
		}
		redirect('admin/product/detail/'.$menuid.'/'.$id_category);
	}
	
	function delete($menuid, $id_category, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_product');
		
		redirect('admin/product/detail/'.$menuid.'/'.$id_category);
	}
	
	
	
	function gallery($menuid, $id_category, $id_product)
	{		
		$data['data_gallery']=$this->master_model->select_in('ms_product_gallery','*',"WHERE id_product=$id_product");
		$this->load->view('admin/product/gallery', $data);
	}
	
	function insert_gallery($menuid, $id_category, $id_product)
	{
		$ID=$this->master_model->mst_last_id('ms_product_gallery');
		
		$Image 		= $ID.'.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
		$Image_temp   = $ID.'_temp.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);

		$config['file_name']      = $ID.'_temp';
		$config['upload_path']    = './uploads/product/';
		$config['allowed_types']  = 'gif|jpg|png|';
		$config['max_size']	   = '2000';
		$config['max_width']      = '1500';
		$config['max_height']     = '1500';
		
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload('ImageUpload')) 
		{
			$data = array('error' => $this->upload->display_errors('',''));	
			$error = $data['error'];
			echo '<script language="javascript">alert("'.$error.'!");window.history.go(-1);</script>';
			exit();
		}else
		{
			$fileImage_temp 	= './uploads/product/'.$Image_temp;
			if (file_exists($fileImage_temp)){unlink($fileImage_temp);}
			$fileImage 	= './uploads/product/'.$Image;
			if (file_exists($fileImage) && $Image!= ''){unlink($fileImage);}
			$config['file_name']      = $ID;
			$this->upload->initialize($config);
			$this->upload->do_upload('ImageUpload');	
		}
		
		$data_gallery=$this->master_model->select_in('ms_product_gallery','ID',"WHERE id_product=$id_product");
						 
		$count_gallery=count($data_gallery);
		
		if($count_gallery==0)
		{
			$main=1;
		}else
		{
			$main=0;
		}
		
		$data=array
		(
			'ID'     	   => $ID,
			'id_product'   => $id_product,
			'id_flavour'   => $this->input->post('flavour'),
			'image'  		=> $Image,
			'main'  		 => $main,
			'sort'   		 => $ID,
			'publish'   	  => 1
		);
		$this->db->insert('ms_product_gallery', $data);
		
		redirect('admin/product/gallery/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	public function change_active($menuid, $id_category, $id_product, $ID)
	{
		$this->master_model->set_null('ms_product_gallery', $id_product);
		$this->master_model->set_default('ms_product_gallery', $id_product, $ID);
		
		redirect('admin/product/gallery/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	public function delete_gallery($menuid, $id_category, $id_product, $ID, $image)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_product_gallery');
		unlink('./uploads/product/'.$image);

		redirect('admin/product/gallery/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	function goal($menuid)
	{		
	    $user_id = $this->session->userdata('UserID');
	    $check=$this->master_model->auth_read($user_id, $menuid);
	    
	    if($check==false)
	    {
	        redirect('admin/admin_login/redirectNoAuthUser');
	    }else
	    {
		$data['category']=$this->master_model->select_in('ms_goal_category', '*', "ORDER BY sort ASC");
		$this->load->view('admin/product/goal', $data);
	    }
	}
	
	function insert_goal($menuid)
	{		
		$ID=$this->master_model->mst_last_id('ms_goal_category');
		$data=array
		(
			'ID'     => $ID,
			'name'   => $this->input->post('name'),
			'note'   => $this->input->post('note'),
			'sort'   => $ID
		);
		$this->db->insert('ms_goal_category', $data);
		
		$product=$this->input->post('product');
		for($a=0; $a < count($product); $a++)
		{
			$id_goal=$this->master_model->mst_last_id('ms_goal');
			$data=array
			(
				'ID'     	 => $id_goal,
				'id_goal'	=> $ID,
				'id_product' => $product[$a],
				'sort'   	   => $id_goal
			);
			$this->db->insert('ms_goal', $data);
		}
		
		redirect('admin/product/goal/'.$menuid);
	}
	
	function insert_goal_detail($menuid, $id_category)
	{
		$product=$this->input->post('product');
		
		$id_goal=$this->master_model->mst_last_id('ms_goal');
		$data=array
		(
			'ID'     	 => $id_goal,
			'id_goal'	=> $id_category,
			'id_product' => $product,
			'sort'   	   => $id_goal
		);
		$this->db->insert('ms_goal', $data);
		
		redirect('admin/product/goal_detail/'.$menuid.'/'.$id_category);
	}
	
	function publish_goal_category($menuid, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_goal_category');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_goal_category');
		}
		redirect('admin/product/goal/'.$menuid);
	}
	
	function edit_goal($menuid)
	{
		$ID=$this->input->post('ID');
		
		$data_edit=$this->master_model->select_in('ms_goal_category', '*', "WHERE ID=$ID");
		echo'
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Edit Goal Category</h4>
			</div>
			<form method="post" action="'.base_url().'admin/product/edit_process_goal/'.$menuid.'/'.$ID.'">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Goal *</label>
						<input type="text" name="name" class="form-control" placeholder="Name Jobs" required="required" value="'.$data_edit[0]->name.'">
					</div>
					
					<div class="form-group">
						<label>Product *</label>
						<br />
						';								
							$data_product=$this->master_model->select_in('ms_product','ID, name',"GROUP BY name");
							for($a=0; $a < count($data_product); $a++)
							{
								$id_product=$data_product[$a]->ID;
								
								$check_product=$this->master_model->check_goal('ms_goal','id_product', $id_product, "AND id_goal=$ID");
								
								if($check_product==true)
								{
									$checked='checked="checked"';
								}else
								{
									$checked='';
								}
								echo'
									<input type="checkbox" name="product[]" '.$checked.' value="'.$data_product[$a]->ID.'"> '.$data_product[$a]->name.'
									<br>
								';
							}
						echo'
					</div>
					
					<div class="form-group">
						<label>Deskripsi</label>
						<textarea name="note" class="form-control">'.$data_edit[0]->note.'</textarea>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-info btn-fill pull-right" value="Simpan" id="save">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px">Close</button>
				</div>
			</form>
		';
	}
	
	function edit_process_goal($menuid, $ID)
	{
		$data=array
		(
			'name'   => $this->input->post('name'),
			'note'   => $this->input->post('note'),
		);
		$this->db->where('ID', $ID);
		$this->db->update('ms_goal_category', $data);
	
		$this->db->where('id_goal',$ID);
		$this->db->delete('ms_goal');
		
		$product=$this->input->post('product');
		for($a=0; $a < count($product); $a++)
		{
			$id_goal=$this->master_model->mst_last_id('ms_goal');
			$data=array
			(
				'ID'     	 => $id_goal,
				'id_goal'	=> $ID,
				'id_product' => $product[$a],
				'sort'   	   => $id_goal
			);
			$this->db->insert('ms_goal', $data);
		}
		
		redirect('admin/product/goal/'.$menuid);
	}
	
	function delete_goal($menuid, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_goal_category');
		
		$this->db->where('id_goal', $ID);
		$this->db->delete('ms_goal');
		
		redirect('admin/product/goal/'.$menuid);
	}
	
	function goal_detail($menuid, $id_category)
	{
		$data['data_product']=$this->master_model->get_product($id_category);
		$this->load->view('admin/product/goal_detail', $data);
	}
	
	function delete_goal_detail($menuid, $id_category, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_goal');
		
		redirect('admin/product/goal_detail/'.$menuid.'/'.$id_category);
	}
	
	function update_goal($menuid, $id_category)
	{
		$ID          = $this->input->post('ID');
		$sort       	= $this->input->post('sort');

		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_goal', "sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/product/goal_detail/'.$menuid.'/'.$id_category);
	}
	
	function info($menuid, $id_category, $id_product)
	{		
	    $user_id = $this->session->userdata('UserID');
	    $check=$this->master_model->auth_read($user_id, $menuid);
	    
	    if($check==false)
	    {
	        redirect('admin/admin_login/redirectNoAuthUser');
	    }else
	    {
			$data['data_info']=$this->master_model->select_in('ms_product_info','*',"WHERE id_product=$id_product");
			$this->load->view('admin/product/info', $data);
	    }
	}
	
	function insert_product_info($menuid, $id_category, $id_product)
	{
		$ID=$this->master_model->mst_last_id('ms_product_info');
		$data=array
		(
			'ID'     	 => $ID,
			'id_product' => $id_product,
			'name' => $this->input->post('name'),
			'fill' => $this->input->post('fill'),
			'unit' => $this->input->post('unit'),
			'sort'   	   => $ID
		);
		$this->db->insert('ms_product_info', $data);
		
		redirect('admin/product/info/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	function edit_product_info($menuid, $id_category, $id_product)
	{
		$ID=$this->input->post('ID');
		
		$data_edit=$this->master_model->select_in('ms_product_info', '*', "WHERE ID=$ID");
		echo'
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Edit Product Info</h4>
			</div>
			<form method="post" action="'.base_url().'admin/product/edit_process_info/'.$menuid.'/'.$id_category.'/'.$id_product.'/'.$ID.'">
				<div class="modal-body">
					<div class="form-group">
						<label>Name *</label>
						<input type="text" name="name" class="form-control" placeholder="Name" required="required" value="'.$data_edit[0]->name.'">
					</div>
					<div class="form-group">
						<label>Fill *</label>
						<input type="text" name="fill" class="form-control" placeholder="Fill" required="required" value="'.$data_edit[0]->fill.'">
					</div>
					<div class="form-group">
						<label>Unit</label>
						<input type="text" name="unit" class="form-control" placeholder="Unit" value="'.$data_edit[0]->unit.'">
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px">Close</button>
				</div>
			</form>
		';
	}
	
	function edit_process_info($menuid, $id_category, $id_product, $ID)
	{
		$data=array
		(
			'name'   	   => $this->input->post('name'),
			'fill'   	   => $this->input->post('fill'),
			'unit'   	   => $this->input->post('unit'),
		);
		$this->db->where('ID', $ID);
		$this->db->update('ms_product_info', $data);
		
		redirect('admin/product/info/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	function delete_product_info($menuid, $id_category, $id_product, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_product_info');
		
		redirect('admin/product/info/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	
	function flavour($menuid, $id_category, $id_product)
	{		
	    $user_id = $this->session->userdata('UserID');
	    $check=$this->master_model->auth_read($user_id, $menuid);
	    
	    if($check==false)
	    {
	        redirect('admin/admin_login/redirectNoAuthUser');
	    }else
	    {
			$data['data_flavour']=$this->master_model->select_in('ms_product_flavour','*',"WHERE id_product=$id_product");
			$this->load->view('admin/product/flavour', $data);
	    }
	}
	
	function insert_product_flavour($menuid, $id_category, $id_product)
	{
		$ID=$this->master_model->mst_last_id('ms_product_flavour');
		
		$Image 		= $ID.'.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
		$Image_temp   = $ID.'_temp.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);

		$config['file_name']      = $ID.'_temp';
		$config['upload_path']    = './uploads/products/';
		$config['allowed_types']  = 'gif|jpg|png|';
		$config['max_size']	   = '2000';
		$config['max_width']      = '1500';
		$config['max_height']     = '1500';
		
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload('ImageUpload')) 
		{
			$data = array('error' => $this->upload->display_errors('',''));	
			$error = $data['error'];
			echo '<script language="javascript">alert("'.$error.'!");window.history.go(-1);</script>';
			exit();
		}else
		{
			$fileImage_temp 	= './uploads/products/'.$Image_temp;
			if (file_exists($fileImage_temp)){unlink($fileImage_temp);}
			$fileImage 	= './uploads/products/'.$Image;
			if (file_exists($fileImage) && $Image!= ''){unlink($fileImage);}
			$config['file_name']      = $ID;
			$this->upload->initialize($config);
			$this->upload->do_upload('ImageUpload');	
		}
		
		
		$check_flavour=$this->master_model->mst_check('ms_product_flavour','id_product', $id_product);
		
		if($check_flavour==false)
		{
			$main=1;
		}else
		{
			$main=0;
		}
		
		
		
		$Image2 		= $ID2.'.'.substr($_FILES['ImageUpload2']['name'], strrpos($_FILES['ImageUpload2']['name'], '.') + 1);
		$Image2_temp   = $ID2.'_temp.'.substr($_FILES['ImageUpload2']['name'], strrpos($_FILES['ImageUpload2']['name'], '.') + 1);

		$config['file_name']      = $ID2.'_temp';
		$config['upload_path']    = './uploads/nutrition/';
		$config['allowed_types']  = 'gif|jpg|png|';
		$config['max_size']	   = '2000';
		$config['max_width']      = '1500';
		$config['max_height']     = '1500';
		
		$this->upload->initialize($config);
		
		if(!$this->upload->do_upload('ImageUpload')) 
		{
			$data = array('error' => $this->upload->display_errors('',''));	
			$error = $data['error'];
			echo '<script language="javascript">alert("'.$error.'!");window.history.go(-1);</script>';
			exit();
		}else
		{
			$fileImage2_temp 	= './uploads/nutrition/'.$Image2_temp;
			if (file_exists($fileImage2_temp)){unlink($fileImage2_temp);}
			$fileImage2 	= './uploads/nutrition/'.$Image2;
			if (file_exists($fileImage) && $Image!= ''){unlink($fileImage2);}
			$config2['file_name']      = $ID2;
			$this->upload->initialize($config2);
			$this->upload->do_upload('ImageUpload');	
		}
		
		
		$data=array
		(
			'ID'     	 => $ID,
			'id_product' => $id_product,
			'id_flavour' => $this->input->post('flavour'),
			'id_weight'  => $this->input->post('weight'),
			'price' 	  => $this->input->post('price'),
			'discount'   => $this->input->post('discount'),
			'image'   	  => $Image,
			'image_facts'=> $Image2,
			'main' 	   => $main,
			'publish' 	=> 1,
			'sort'   	   => $ID
		);
		$this->db->insert('ms_product_flavour', $data);
		
		redirect('admin/product/flavour/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	public function change_active_flavour($menuid, $id_category, $id_product, $ID)
	{
		$this->master_model->set_null('ms_product_flavour', $id_product);
		$this->master_model->set_default('ms_product_flavour', $id_product, $ID);
		
		redirect('admin/product/flavour/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	
	function edit_product_flavour($menuid, $id_category, $id_product)
	{
		$ID=$this->input->post('ID');
		
		$data_edit=$this->master_model->select_in('ms_product_flavour', '*', "WHERE ID=$ID");
		echo'
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Edit Product Flavour</h4>
			</div>
			<form method="post" action="'.base_url().'admin/product/edit_process_flavour/'.$menuid.'/'.$id_category.'/'.$id_product.'/'.$ID.'" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label>Flavour *</label>
						<select name="flavour" class="form-control" required>
							<option value="" selected="selected">
								Choose Flavour
							</option>
							';
								$data_flavour=$this->master_model->select_in('ms_flavour','ID, name',"WHERE publish=1");
								for($a=0; $a < count($data_flavour); $a++)
								{
									$ID=$data_flavour[$a]->ID;
									if($data_edit[0]->id_flavour==$ID)
									{
										$select='selected="selected"';
									}else
									{
										$select='';
									}
									echo'
										<option value="'.$data_flavour[$a]->ID.'" '.$select.'>
											'.$data_flavour[$a]->name.'
										</option>
									';
								}
							echo'
						</select>
					</div>
					
					<div class="form-group">
						<label>Weight *</label>
						<select name="weight" class="form-control" required>
							<option value="" selected="selected">
								Choose Weight
							</option>
							';
								$data_weight=$this->master_model->mst_data('ms_weight');
								for($a=0; $a < count($data_weight); $a++)
								{
									$ID=$data_weight[$a]->ID;
									if($data_edit[0]->id_weight==$ID)
									{
										$selected='selected="selected"';
									}else
									{
										$selected='';
									}
									echo'
										<option value="'.$data_weight[$a]->ID.'" '.$selected.'>
											'.$data_weight[$a]->name.'
										</option>
									';
								}
							echo'
						</select>
					</div>
					
					<div class="form-group">
						<label>Price *</label>
						<input type="text" name="price" class="form-control" placeholder="Price" required="required" value="'.$data_edit[0]->price.'">
					</div>
					
					<div class="form-group">
						<label>Discount</label>
						<input type="text" name="discount" class="form-control" placeholder="Discount" value="'.$data_edit[0]->discount.'">
					</div>
					
					<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<img src="'.base_url().'uploads/products/'.$data_edit[0]->image.'" width="100">
							<br>
							<label>Image Product*</label>
							<input type="file" name="ImageUpload" />
							<br/>
							Size : 970x970 px, Max : (1Mb)
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<img src="'.base_url().'uploads/nutrition/'.$data_edit[0]->image_facts.'" width="100">
							<br>
							<label>Image Nutrition Facts*</label>
							<input type="file" name="ImageUpload2" />
							<br/>
							Size : 970x970 px, Max : (1Mb)
						</div>
					</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px">Close</button>
				</div>
			</form>
		';
	}
	
	function edit_process_flavour($menuid, $id_category, $id_product, $ID)
	{
		if($_FILES['ImageUpload']['name']=='')
		{
			$data=array
			(
				'id_flavour'   	   => $this->input->post('flavour'),
				'id_weight'   	   => $this->input->post('weight'),
				'price'   	   => $this->input->post('price'),
				'discount'   	   => $this->input->post('discount'),
			);
			$this->db->where('ID', $ID);
			$this->db->update('ms_product_flavour', $data);
		}else
		{
			$Image 		= $ID.'.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
			$Image_temp   = $ID.'_temp.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
	
			$config['file_name']      = $ID.'_temp';
			$config['upload_path']    = './uploads/products/';
			$config['allowed_types']  = 'gif|jpg|png|';
			$config['max_size']	   = '2000';
			$config['max_width']      = '1500';
			$config['max_height']     = '1500';
			
			$this->upload->initialize($config);
			
			if(!$this->upload->do_upload('ImageUpload')) 
			{
				$data = array('error' => $this->upload->display_errors('',''));	
				$error = $data['error'];
				echo '<script language="javascript">alert("'.$error.'!");window.history.go(-1);</script>';
				exit();
			}else
			{
				$fileImage_temp 	= './uploads/products/'.$Image_temp;
				if (file_exists($fileImage_temp)){unlink($fileImage_temp);}
				$fileImage 	= './uploads/products/'.$Image;
				if (file_exists($fileImage) && $Image!= ''){unlink($fileImage);}
				$config['file_name']      = $ID;
				$this->upload->initialize($config);
				$this->upload->do_upload('ImageUpload');	
			}	
			
			
			$Image2 		= $ID2.'.'.substr($_FILES['ImageUpload2']['name'], strrpos($_FILES['ImageUpload2']['name'], '.') + 1);
			$Image2_temp   = $ID2.'_temp.'.substr($_FILES['ImageUpload2']['name'], strrpos($_FILES['ImageUpload2']['name'], '.') + 1);
	
			$config['file_name']      = $ID2.'_temp';
			$config['upload_path']    = './uploads/nutrition/';
			$config['allowed_types']  = 'gif|jpg|png|';
			$config['max_size']	   = '2000';
			$config['max_width']      = '1500';
			$config['max_height']     = '1500';
			
			$this->upload->initialize($config);
			
			if(!$this->upload->do_upload('ImageUpload')) 
			{
				$data = array('error' => $this->upload->display_errors('',''));	
				$error = $data['error'];
				echo '<script language="javascript">alert("'.$error.'!");window.history.go(-1);</script>';
				exit();
			}else
			{
				$fileImage2_temp 	= './uploads/nutrition/'.$Image2_temp;
				if (file_exists($fileImage2_temp)){unlink($fileImage2_temp);}
				$fileImage2 	= './uploads/nutrition/'.$Image2;
				if (file_exists($fileImage) && $Image!= ''){unlink($fileImage2);}
				$config2['file_name']      = $ID2;
				$this->upload->initialize($config2);
				$this->upload->do_upload('ImageUpload');	
			}
			
			$data=array
			(
				'id_flavour'   	   => $this->input->post('flavour'),
				'id_weight'   	   	=> $this->input->post('weight'),
				'price'   	   		=> $this->input->post('price'),
				'discount'   	   	 => $this->input->post('discount'),
				'image'			=> $Image,
				'image_facts'	  => $Image2
			);
			$this->db->where('ID', $ID);
			$this->db->update('ms_product_flavour', $data);
		}
		
		redirect('admin/product/flavour/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	function delete_product_flavour($menuid, $id_category, $id_product, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_product_flavour');
		
		redirect('admin/product/flavour/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	function edit_gallery($menuid, $id_category, $id_product)
	{
		$ID=$this->input->post('ID');
		
		$data_edit=$this->master_model->select_in('ms_product_gallery', '*', "WHERE ID=$ID");
		echo'
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Edit Product Gallery</h4>
			</div>
			<form method="post" action="'.base_url().'admin/product/edit_process_gallery/'.$menuid.'/'.$id_category.'/'.$id_product.'/'.$ID.'"  enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label>Flavour *</label>
						<select name="flavour" class="form-control" required>
							<option value="" selected="selected">
								Choose Flavour
							</option>
							';
								$data_flavour=$this->master_model->mst_data('ms_flavour');
								
								for($a=0; $a < count($data_flavour); $a++)
								{
									if($data_edit[0]->id_flavour==$data_flavour[$a]->ID)
									{
										$selected='selected="selected"';
									}else
									{
										$selected='';
									}
									echo'
										<option value="'.$data_flavour[$a]->ID.'" '.$selected.'>
											'.$data_flavour[$a]->name.'
										</option>
									';
								}
							echo'
						</select>
					</div>
					<div class="form-group">
						<img src="'.base_url().'uploads/product/'.$data_edit[0]->image.'" width="100">
						<br>
						<label>Image</label>
						<input type="file" name="ImageUpload" />
						<br/>
						Size : 970x970 px, Max : (1Mb)
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px">Close</button>
				</div>
			</form>
		';
	}
	
	function edit_process_gallery($menuid, $id_category, $id_product, $ID)
	{
		$id_flavour=$this->input->post('flavour');
				
		if($_FILES['ImageUpload']['name']=='')
		{
			$data=array
			(
				'id_flavour'   => $id_flavour,
			);
			$this->db->where('ID', $ID);
			$this->db->update('ms_product_gallery', $data);
		}else
		{
			$Image 		= $ID.'.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
			$Image_temp   = $ID.'_temp.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
	
			$config['file_name']      = $ID.'_temp';
			$config['upload_path']    = './uploads/product/';
			$config['allowed_types']  = 'gif|jpg|png|';
			$config['max_size']	   = '2000';
			$config['max_width']      = '1500';
			$config['max_height']     = '1500';
			
			$this->upload->initialize($config);
			
			if(!$this->upload->do_upload('ImageUpload')) 
			{
				$data = array('error' => $this->upload->display_errors('',''));	
				$error = $data['error'];
				echo '<script language="javascript">alert("'.$error.'!");window.history.go(-1);</script>';
				exit();
			}else
			{
				$fileImage_temp 	= './uploads/product/'.$Image_temp;
				if (file_exists($fileImage_temp)){unlink($fileImage_temp);}
				$fileImage 	= './uploads/product/'.$Image;
				if (file_exists($fileImage) && $Image!= ''){unlink($fileImage);}
				$config['file_name']      = $ID;
				$this->upload->initialize($config);
				$this->upload->do_upload('ImageUpload');	
			}	
			
			$data=array
			(
				'id_flavour'   => $flavour,
				'image'  		=> $Image,
			);
			
			$this->db->where('ID', $ID);
			$this->db->update('ms_product_gallery', $data);
		}
		
		redirect('admin/product/gallery/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
	
	function update_gallery($menuid, $id_category, $id_product)
	{
		$ID          = $this->input->post('ID');
		$sort       	= $this->input->post('sort');


		for($a=0 ; $a < count($ID) ; $a++)
		{
			$this->master_model->mst_update('ms_product_gallery', "sort='$sort[$a]'", $ID[$a]);
		}
		
		redirect('admin/product/gallery/'.$menuid.'/'.$id_category.'/'.$id_product);
	}
}
?>