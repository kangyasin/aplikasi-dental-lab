<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class master extends CI_Controller {
	public function __construct()

	{
		parent :: __construct();
		$this->load->model('admin/master_model');

		$this->load->helper('text');
    }


		//====================== barang ========================//

		public function barang($menuid)
		{
			$user_id = $this->session->userdata('UserID');
		    $check=$this->master_model->auth_read($user_id, $menuid);

		    if($check==false)
		    {
		        redirect('admin/admin_login/redirectNoAuthUser');
		    }else
		    {
	    		$data['data_barang']=$this->master_model->mst_datas('barang');
	    		$this->load->view('admin/barang/main', $data);
		    }
		}

		function addbarang($menuid)
		{
			$this->load->view('admin/barang/insert');
		}


		public function insert_barang($menuid)
		{
			$ID = $this->master_model->mst_last_id('barang');
			$data = array(
				'ID' => $ID,
				'nama_barang' => $this->input->post('nama_barang'),
				'harga_barang' => $this->input->post('harga_barang')
			);

			$this->db->insert('barang', $data);

			redirect('admin/master/barang/'.$menuid);
		}



		function edit_barang($menuid, $ID)
		{

			$data['data_edit']=$this->master_model->mst_data_edit('barang', $ID);
			$this->load->view('admin/barang/edit', $data);
		}


		public function delete_barang($menuid, $ID)
		{
				$this->db->where('ID', $ID);
				$this->db->delete('barang');
				redirect('admin/master/barang/'.$menuid);
		}


		public function edit_process_barang($menuid, $ID)
		{
			$data = array(
				'nama_barang' => $this->input->post('nama_barang'),
				'harga_barang' => $this->input->post('harga_barang')
			);
			$this->db->where('ID',$ID);
			$this->db->update('barang', $data);

			redirect('admin/master/barang/'.$menuid);
		}

		//==================== BATAS barang ====================//



		//====================== konsumen ========================//

		public function konsumen($menuid)
		{
		  $user_id = $this->session->userdata('UserID');
		    $check=$this->master_model->auth_read($user_id, $menuid);

		    if($check==false)
		    {
		        redirect('admin/admin_login/redirectNoAuthUser');
		    }else
		    {
		      $data['data_konsumen']=$this->master_model->mst_datas('konsumen');
		      $this->load->view('admin/konsumen/main', $data);
		    }
		}

		function addkonsumen($menuid)
		{
		  $this->load->view('admin/konsumen/insert');
		}


		public function insert_konsumen($menuid)
		{
		  $ID = $this->master_model->mst_last_id('konsumen');
		  $data = array(
		    'ID' => $ID,
		    'nama_konsumen' => $this->input->post('nama_konsumen'),
		    'email' => $this->input->post('email'),
				'alamat' => $this->input->post('alamat'),
				'telp' => $this->input->post('telp')
		  );

		  $this->db->insert('konsumen', $data);

		  redirect('admin/master/konsumen/'.$menuid);
		}



		function edit_konsumen($menuid, $ID)
		{

		  $data['data_edit']=$this->master_model->mst_data_edit('konsumen', $ID);
		  $this->load->view('admin/konsumen/edit', $data);
		}


		public function delete_konsumen($menuid, $ID)
		{
		    $this->db->where('ID', $ID);
		    $this->db->delete('konsumen');
		    redirect('admin/master/konsumen/'.$menuid);
		}


		public function edit_process_konsumen($menuid, $ID)
		{
		  $data = array(
				'nama_konsumen' => $this->input->post('nama_konsumen'),
		    'email' => $this->input->post('email'),
				'alamat' => $this->input->post('alamat'),
				'telp' => $this->input->post('telp')
		  );
		  $this->db->where('ID',$ID);
		  $this->db->update('konsumen', $data);

		  redirect('admin/master/konsumen/'.$menuid);
		}

		//==================== BATAS konsumen ====================//





				//====================== supplier ========================//

				public function supplier($menuid)
				{
				  $user_id = $this->session->userdata('UserID');
				    $check=$this->master_model->auth_read($user_id, $menuid);

				    if($check==false)
				    {
				        redirect('admin/admin_login/redirectNoAuthUser');
				    }else
				    {
				      $data['data_supplier']=$this->master_model->mst_datas('supplier');
				      $this->load->view('admin/supplier/main', $data);
				    }
				}

				function addsupplier($menuid)
				{
				  $this->load->view('admin/supplier/insert');
				}


				public function insert_supplier($menuid)
				{
				  $ID = $this->master_model->mst_last_id('supplier');
				  $data = array(
				    'ID' => $ID,
				    'nama_perusahaan' => $this->input->post('nama'),
				    'email' => $this->input->post('email'),
						'alamat' => $this->input->post('alamat'),
						'telp' => $this->input->post('telp')
				  );

				  $this->db->insert('supplier', $data);

				  redirect('admin/master/supplier/'.$menuid);
				}



				function edit_supplier($menuid, $ID)
				{

				  $data['data_edit']=$this->master_model->mst_data_edit('supplier', $ID);
				  $this->load->view('admin/supplier/edit', $data);
				}


				public function delete_supplier($menuid, $ID)
				{
				    $this->db->where('ID', $ID);
				    $this->db->delete('supplier');
				    redirect('admin/master/supplier/'.$menuid);
				}


				public function edit_process_supplier($menuid, $ID)
				{
				  $data = array(
						'nama_perusahaan' => $this->input->post('nama'),
				    'email' => $this->input->post('email'),
						'alamat' => $this->input->post('alamat'),
						'telp' => $this->input->post('telp')
				  );
				  $this->db->where('ID',$ID);
				  $this->db->update('supplier', $data);

				  redirect('admin/master/supplier/'.$menuid);
				}

				//==================== BATAS supplier ====================//




						//====================== kurir ========================//

						public function kurir($menuid)
						{
						  $user_id = $this->session->userdata('UserID');
						    $check=$this->master_model->auth_read($user_id, $menuid);

						    if($check==false)
						    {
						        redirect('admin/admin_login/redirectNoAuthUser');
						    }else
						    {
						      $data['data_kurir']=$this->master_model->mst_datas('kurir');
						      $this->load->view('admin/kurir/main', $data);
						    }
						}

						function addkurir($menuid)
						{
						  $this->load->view('admin/kurir/insert');
						}


						public function insert_kurir($menuid)
						{
						  $ID = $this->master_model->mst_last_id('kurir');
						  $data = array(
						    'ID' => $ID,
						    'nama_kurir' => $this->input->post('nama'),
								'telp' => $this->input->post('telp')
						  );

						  $this->db->insert('kurir', $data);

						  redirect('admin/master/kurir/'.$menuid);
						}



						function edit_kurir($menuid, $ID)
						{

						  $data['data_edit']=$this->master_model->mst_data_edit('kurir', $ID);
						  $this->load->view('admin/kurir/edit', $data);
						}


						public function delete_kurir($menuid, $ID)
						{
						    $this->db->where('ID', $ID);
						    $this->db->delete('kurir');
						    redirect('admin/master/kurir/'.$menuid);
						}


						public function edit_process_kurir($menuid, $ID)
						{
						  $data = array(
								'nama_kurir' => $this->input->post('nama'),
								'telp' => $this->input->post('telp')
						  );
						  $this->db->where('ID',$ID);
						  $this->db->update('kurir', $data);

						  redirect('admin/master/kurir/'.$menuid);
						}

						//==================== BATAS kurir ====================//



}
?>
