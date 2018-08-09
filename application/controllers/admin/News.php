<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class news extends CI_Controller {

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
    		$data['data_news']=$this->master_model->mst_data('ms_news_category');
    
    		$this->load->view('admin/news/main', $data);
	    }
	}

	public function insert_news($menuid)
	{
		$ID = $this->master_model->mst_last_id('ms_news_category');

		$data = array(
			'ID' => $ID,
			'name' => $this->input->post('name'),
			'sort' => $ID
		);

		$this->db->insert('ms_news_category', $data);

		redirect('admin/news/index/'.$menuid);
	}
	
	public function edit_category($menuid)
	{
		$ID=$this->input->post('ID');
		
		$data_edit=$this->master_model->mst_data_edit('ms_news_category', $ID);
		echo'
			<div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit Article Category</h4>
            </div>

			<form action="'.base_url().'admin/news/edit_category_process/'.$menuid.'/'.$ID.'" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label>Name *</label>
						<input type="text" name="name" class="form-control" placeholder="Name" required="required" value="'.$data_edit[0]->name.'">
					</div>
				</div>

				<div class="modal-footer">
					<input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">
					<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px;">Close</button>
				</div>
			</form>
		';
	}
	
	public function edit_category_process($menuid, $ID)
	{
		$data = array(

			'name' => $this->input->post('name'),
			
		);

		$this->db->where('ID', $ID);
		$this->db->update('ms_news_category', $data);

		redirect('admin/news/index/'.$menuid);
	}
	
	
	
	public function delete($menuid, $ID)
	{
		$this->db->where('ID', $ID);
		$this->db->delete('ms_news_category');
		
		$this->db->where('id_category', $ID);
		$this->db->delete('ms_news');
		
		$data_news=$this->master_model->select_in('ms_news','image',"WHERE id_category=$ID");
		
		for($a=0; $a < count($data_news); $a++)
		{
			$image=$data_news[$a]->image;
			
			unlink('./uploads/news/'.$image);
		}

		redirect('admin/news/index/'.$menuid);
	}
	
	public function detail($menuid, $id_category)
	{
		$data['data_news']=$this->master_model->select_in('ms_news', '*', "WHERE id_category=$id_category ORDER BY date_in DESC");
		$this->load->view('admin/news/detail', $data);
	}
	
	function insert($menuid, $id_category)
	{
		$this->load->view('admin/news/insert');
	}
	
	
	public function insert_process($menuid, $id_category)
	{
		$date=$this->input->post('date');
			
		$date=strtotime($date);
		
		$ID = $this->master_model->mst_last_id('ms_news');
			
		if($_FILES['ImageUpload']['name']=='')
		{
			$data = array(
				'ID' => $ID,
				'id_category' => $id_category,
				'name' => $this->input->post('name'),
				'note' => $this->input->post('desc'),
				'date_in' => date('Y-m-d', $date),
				'publish' => 1,
				'sort' => $ID
			);
			
			$this->db->insert('ms_news', $data);
		}else
		{
			$Image 		= $ID.'.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
			$Image_temp = $ID.'_temp.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
	
			$config['file_name']      = $ID.'_temp';
			$config['upload_path']    = './uploads/news/';
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
			}else{
				$fileImage_temp 	= './uploads/news/'.$Image_temp;
				if (file_exists($fileImage_temp)){unlink($fileImage_temp);}
				$fileImage 	= './uploads/news/'.$Image;
				if (file_exists($fileImage) && $Image!= ''){unlink($fileImage);}
				$config['file_name']      = $ID;
				$this->upload->initialize($config);
				$this->upload->do_upload('ImageUpload');
			}
	
			$data = array(
				'ID' => $ID,
				'id_category' => $id_category,
				'name' => $this->input->post('name'),
				'note' => $this->input->post('desc'),
				'date_in' => date('Y-m-d', $date),
				'image' => $Image,
				'publish' => 1,
				'sort' => $ID
			);
	
			$this->db->insert('ms_news', $data);
		}

		redirect('admin/news/detail/'.$menuid.'/'.$id_category);
	}
	
	function edit($menuid, $id_category, $ID)
	{
		$data['data_edit']=$this->master_model->mst_data_edit('ms_news', $ID);
		
		$this->load->view('admin/news/edit', $data);
	}
	
	
	
	
	
	public function delete_news($menuid, $id_category, $ID, $image)
	{
		$this->db->where('ID', $ID);

		$this->db->delete('ms_news');
		
		unlink('./uploads/news/'.$image);

		redirect('admin/news/detail/'.$menuid.'/'.$id_category);
	}
	
	
	public function edit_process($menuid, $id_category, $ID)
	{
		$date=$this->input->post('date');
		
		$date=strtotime($date);
		
		if($_FILES['ImageUpload']['name']=='')
		{
			$data = array(
				'id_category' => $this->input->post('category'),
				'name' => $this->input->post('name'),
				'note' => $this->input->post('desc'),
				'date_in' => date('Y-m-d', $date),
				'publish' => 1,
			);
			
			$this->db->where('ID',$ID);
			$this->db->update('ms_news', $data);
		}else
		{
			$Image 		= $ID.'.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
			$Image_temp   = $ID.'_temp.'.substr($_FILES['ImageUpload']['name'], strrpos($_FILES['ImageUpload']['name'], '.') + 1);
	
			$config['file_name']      = $ID.'_temp';
			$config['upload_path']    = './uploads/news/';
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
				$fileImage_temp 	= './uploads/news/'.$Image_temp;
				if (file_exists($fileImage_temp)){unlink($fileImage_temp);}
				$fileImage 	= './uploads/news/'.$Image;
				if (file_exists($fileImage) && $Image!= ''){unlink($fileImage);}
				$config['file_name']      = $ID;
				$this->upload->initialize($config);
				$this->upload->do_upload('ImageUpload');
			}
	
			$data = array(
				'id_category' => $this->input->post('category'),
				'name' => $this->input->post('name'),
				'note' => $this->input->post('desc'),
				'date_in' => date('Y-m-d', $date),
				'image' => $Image,
				'publish' => 1,
			);
			$this->db->where('ID',$ID);
			$this->db->update('ms_news', $data);
		}

		redirect('admin/news/detail/'.$menuid.'/'.$id_category);
	}
	
	function publish($menuid, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_news_category');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_news_category');
		}
		redirect('admin/news/index/'.$menuid);
	}
	
	function publish_detail($menuid, $id_category, $ID, $publish)
	{
		if($publish==0)
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','1');
			$this->db->update('ms_news');
		}else
		{
			$this->db->where('ID', $ID);
			$this->db->set('publish','0');
			$this->db->update('ms_news');
		}
		redirect('admin/news/detail/'.$menuid.'/'.$id_category);
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
