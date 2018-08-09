<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class transaction extends CI_Controller {
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
			$data['data_transaction']=$this->master_model->select_in('transaction','*',"");
		    $this->load->view('admin/transaction/main', $data);
	    }
	}


			//====================== permintaan ========================//

			public function permintaan($menuid)
			{
			  	$user_id = $this->session->userdata('UserID');
			    $check=$this->master_model->auth_read($user_id, $menuid);

					$from = $this->input->post('start');
					$to = $this->input->post('end');

			    if($check==false)
			    {
			        redirect('admin/admin_login/redirectNoAuthUser');
			    }else
			    {

						if($from <> ''){
							  $data['data_permintaan']=$this->master_model->cari_dataPermintaanBarang();
						}else{
							  $data['data_permintaan']=$this->master_model->dataPermintaanBarang();
						}


			      $this->load->view('admin/permintaan/main', $data);
			    }
			}

			function addpermintaan($menuid)
			{

					$data['data_barang']=$this->master_model->mst_datas('barang');
					$data['data_supplier']=$this->master_model->mst_datas('supplier');
			  $this->load->view('admin/permintaan/insert', $data);
			}


			public function insert_permintaan($menuid)
			{
			  $ID = $this->master_model->mst_last_id('permintaan_barang');
			  $data = array(
			    'ID' => $ID,
			    'id_supplier' => $this->input->post('supplier'),
			    'id_barang' => $this->input->post('barang'),
					 'qty' => $this->input->post('qty'),
					'tanggal_permintaan' => $this->input->post('tanggal_permintaan'),
					'admin' => $this->session->userdata('name_admin')
			  );

			  $this->db->insert('permintaan_barang', $data);

			  redirect('admin/transaction/permintaan/'.$menuid);
			}



			function edit_permintaan($menuid, $ID)
			{
				$data['data_barang']=$this->master_model->mst_datas('barang');
				$data['data_supplier']=$this->master_model->mst_datas('supplier');
				//$data['data_permintaan']=$this->master_model->edit_dataPermintaanBarang($ID);
			  $data['data_edit']=$this->master_model->mst_data_edit('permintaan_barang', $ID);
			  $this->load->view('admin/permintaan/edit', $data);
			}


			public function delete_permintaan($menuid, $ID)
			{
			    $this->db->where('ID', $ID);
			    $this->db->delete('permintaan_barang');
			    redirect('admin/transaction/permintaan/'.$menuid);
			}


			public function edit_process_permintaan($menuid, $ID)
			{
			  $data = array(
				'id_supplier' => $this->input->post('supplier'),
				'id_barang' => $this->input->post('barang'),
				 'qty' => $this->input->post('qty'),
				'tanggal_permintaan' => $this->input->post('tanggal_permintaan')
			  );
			  $this->db->where('ID',$ID);
			  $this->db->update('permintaan_barang', $data);

			  redirect('admin/transaction/permintaan/'.$menuid);
			}


			function changestatus_permintaan($MENU_ID)
			{
				$id = $this->input->get('ID');

				$dataEdit = $this->master_model->dataedits('permintaan_barang','ID',$id);
				$status = $dataEdit[0]['status'];
				$qty = $dataEdit[0]['qty'];
				$id_barang = $dataEdit[0]['id_barang'];

				if($status == 0)
				{

					$echo = '<label class="control control--radio">Belum Terim
		            <input type="radio" name="status" value="0" checked="checked"/>
		            <div class="control__indicator"></div>
		            </label>

		            <label class="control control--radio">Sudah Terima
		            <input type="radio" name="status" value="1"/>
		            <div class="control__indicator"></div>
		            </label>


					';

				}else{

					$echo = '<label class="control control--radio">Belum Terima
		            <input type="radio" name="status" value="0"/>
		            <div class="control__indicator"></div>
		            </label>

		            <label class="control control--radio">Sudah Terima
		            <input type="radio" name="status" value="1" checked="checked"/>
		            <div class="control__indicator"></div>
		            </label>';


				}

				echo'

				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Edit Status Permintaan</h4>
				</div>
				<form action="'.base_url().'admin/transaction/change_statuspermintaan/'.$MENU_ID.'" method="post">
				<input type="hidden" name="ID" value="'.$dataEdit[0]['ID'].'">
				<input type="hidden" name="qty" value="'.$qty.'">
				<input type="hidden" name="id_barang" value="'.$id_barang.'">

					<div class="modal-body">
					  <div class="form-group">
							'.$echo .'
						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-info btn-fill pull-right" value="Save">
						<!--<a class="btn btn-default pull-left" data-dismiss="modal">Close</a> -->
					</div>
				</form>

				';

			}

			function change_statuspermintaan($menuid){

				$ID = $this->input->post('ID');

				$data = array(
			 'status' => $this->input->post('status'),
			 'tanggal_terima' => date('Y-m-d'),
			 'admin' => $this->session->userdata('name_admin')
			 );
			 $this->db->where('ID',$ID);
			 $this->db->update('permintaan_barang', $data);

			 $id_barang = $this->input->post('id_barang');
			 $qty = $this->input->post('qty');


			 $dataBarang = $this->master_model->dataedits('barang','ID',$id_barang);

			 $idBarang = $dataBarang[0]['ID'];
			 $qtyBarang = $dataBarang[0]['stok'];


			 $totQty = $qty + $qtyBarang;

			$datas = array(
				'stok' => $totQty
			);
			$this->db->where('ID',$idBarang);
			$this->db->update('barang', $datas);

			 redirect('admin/transaction/permintaan/'.$menuid);
			}

			//==================== BATAS permintaan ====================//




			//====================== penjualan ========================//

			public function penjualan($menuid)
			{
			    $user_id = $this->session->userdata('UserID');
			    $check=$this->master_model->auth_read($user_id, $menuid);

			    $from = $this->input->post('start');
			    $to = $this->input->post('end');

			    if($check==false)
			    {
			        redirect('admin/admin_login/redirectNoAuthUser');
			    }else
			    {

			      if($from <> ''){
			          $data['data_penjualan']=$this->master_model->cari_dataPenjualan();
			      }else{
			          $data['data_penjualan']=$this->master_model->dataPenjualan();
			      }


			      $this->load->view('admin/penjualan/main', $data);
			    }
			}

			function addpenjualan($menuid)
			{

			    $data['data_barang']=$this->master_model->mst_datas('barang');
			    $data['data_konsumen']=$this->master_model->mst_datas('konsumen');
					$data['data_kurir']=$this->master_model->mst_datas('kurir');
			  	$this->load->view('admin/penjualan/insert', $data);
			}


			public function insert_penjualan($menuid)
			{
			  $ID = $this->master_model->mst_last_id('penjualan_barang');
				$barang = $this->input->post('barang');
				$exp = explode("/",$barang);
				$id_barang = $exp[0];
				$harga = $exp[1];

				$qty = $this->input->post('qty');

				$totharga = $harga * $qty;
			  $data = array(
			    'ID' => $ID,
			    'id_konsumen' => $this->input->post('konsumen'),
			    'id_barang' => $id_barang,
					'id_kurir' => $this->input->post('id_kurir'),
					'harga' => $totharga,
					'qty' => $this->input->post('qty'),
			    'tanggal' => $this->input->post('tanggal'),
					'status' => 0,
			    'admin' => $this->session->userdata('name_admin')
			  );
			  $this->db->insert('penjualan_barang', $data);

			  redirect('admin/transaction/penjualan/'.$menuid);
			}



			function edit_penjualan($menuid, $ID)
			{
				$data['data_barang']=$this->master_model->mst_datas('barang');
				$data['data_konsumen']=$this->master_model->mst_datas('konsumen');
				$data['data_kurir']=$this->master_model->mst_datas('kurir');
			  $data['data_penjualan']=$this->master_model->edit_dataPermintaanBarang($ID);
			  $data['data_edit']=$this->master_model->mst_data_edit('penjualan_barang', $ID);
			  $this->load->view('admin/penjualan/edit', $data);
			}


			public function delete_penjualan($menuid, $ID)
			{
			    $this->db->where('ID', $ID);
			    $this->db->delete('penjualan_barang');
			    redirect('admin/transaction/penjualan/'.$menuid);
			}


			public function edit_process_penjualan($menuid, $ID)
			{

				$barang = $this->input->post('barang');
				$exp = explode("/",$barang);
				$id_barang = $exp[0];
				$harga = $exp[1];

				$qty = $this->input->post('qty');

				$totharga = $harga * $qty;

				$data = array(
			    'id_konsumen' => $this->input->post('konsumen'),
			    'id_barang' => $id_barang,
					'harga' => $totharga,
					'qty' => $this->input->post('qty'),
			    'tanggal' => $this->input->post('tanggal'),
			    'admin' => $this->session->userdata('name_admin')
			  );


			  $this->db->where('ID',$ID);
			  $this->db->update('penjualan_barang', $data);

			  redirect('admin/transaction/penjualan/'.$menuid);
			}


			function pilihkurir($MENU_ID)
			{
			  $id = $this->input->get('ID');
			  $dataKurir = $this->master_model->mst_datas('kurir');


			  echo'

			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal">&times;</button>
			    <h4 class="modal-title">Pilih Kurir</h4>
			  </div>
			  <form action="'.base_url().'admin/transaction/kurir/'.$MENU_ID.'" method="post">
			  <input type="hidden" name="id_penjualan" value="'.$id.'">
			    <div class="modal-body">
			      <div class="form-group">
							';
							for($k=0; $k<count($dataKurir); $k++){
									echo'
									<label class="control control--radio">'.$dataKurir[$k]->nama_kurir.'
									<input type="radio" name="kurir" value="'.$dataKurir[$k]->nama_kurir.'"/>
									<div class="control__indicator"></div>
									</label>
									';
							};
							echo'
			      </div>
			    </div>
			    <div class="modal-footer">
			      <input type="submit" class="btn btn-info btn-fill pull-right" value="Save">
			      <!--<a class="btn btn-default pull-left" data-dismiss="modal">Close</a> -->
			    </div>
			  </form>

			  ';

			}

			function kurir($menuid){

			  $id_penjualan = $this->input->post('id_penjualan');


			  $data = array(
			 'status' => 1,
			 'kurir' => $this->input->post('kurir')
			 );


			 $this->db->where('ID',$id_penjualan);
			 $this->db->update('penjualan_barang', $data);

			 redirect('admin/transaction/penjualan/'.$menuid);
			}

			function gofaktur($menuid, $ID){
				$data['data_faktur'] = $this->master_model->getFaktur($ID);
			 $this->load->view('admin/penjualan/invoice', $data);
			}

			function goinvoice($menuid, $ID){
				$data['data_invoice'] = $this->master_model->getInvoice($ID);
			 $this->load->view('admin/pembayaran/invoice', $data);
			}

			function gosent($menuid, $ID){
			  $data = array(
			 	'status' => 1
			 	);

			 $this->db->where('ID',$ID);
			 $this->db->update('penjualan_barang', $data);

			 redirect('admin/transaction/penjualan/'.$menuid);
			}

			//==================== BATAS penjualan ====================//



			//====================== pembayaran ========================//

			public function pembayaran($menuid)
			{
			    $user_id = $this->session->userdata('UserID');
			    $check=$this->master_model->auth_read($user_id, $menuid);

			    $from = $this->input->post('start');
			    $to = $this->input->post('end');

			    if($check==false)
			    {
			        redirect('admin/admin_login/redirectNoAuthUser');
			    }else{
			      if($from <> ''){
			          $data['data_pembayaran']=$this->master_model->dataPembayaran();
			      }else{
			          $data['data_pembayaran']=$this->master_model->dataPembayaran();
			      }
			      $this->load->view('admin/pembayaran/main', $data);
			    }
			}

			function addpembayaran($menuid)
			{

			    $data['data_penjualan']=$this->master_model->dataPenjualanBayar();
			  	$this->load->view('admin/pembayaran/insert', $data);
			}


			public function insert_pembayaran($menuid)
			{
			  $ID = $this->master_model->mst_last_id('pembayaran');
				$DataPenjualan = $this->master_model->detailPembayaran($this->input->post('id_penjualan'));
				$bayar = $this->input->post('bayar');
				$sisabayar = $DataPenjualan[0]->harga - $bayar;

				$data = array(
				 		'status' => 2,
			  );

			 $this->db->where('ID',$this->input->post('id_penjualan'));
			 $this->db->update('penjualan_barang', $data);

			  $data = array(
			    'ID' => $ID,
			    'id_penjualanbarang' => $this->input->post('id_penjualan'),
			    'total_bayar' => $bayar,
					'sisa_bayar' => $sisabayar,
					'status' => 1,
			    'tanggal_pembayaran' => $this->input->post('tanggal_pembayaran'),
			    'admin' => $this->session->userdata('name_admin')
			  );

			  $this->db->insert('pembayaran', $data);
			  redirect('admin/transaction/pembayaran/'.$menuid);
			}



			function edit_pembayaran($menuid, $ID)
			{
			  $data['data_barang']=$this->master_model->mst_datas('barang');
			  $data['data_supplier']=$this->master_model->mst_datas('supplier');
			  //$data['data_pembayaran']=$this->master_model->edit_dataPermintaanBarang($ID);
			  $data['data_edit']=$this->master_model->mst_data_edit('pembayaran_barang', $ID);
			  $this->load->view('admin/pembayaran/edit', $data);
			}


			public function delete_pembayaran($menuid, $ID)
			{
			    $this->db->where('ID', $ID);
			    $this->db->delete('pembayaran_barang');
			    redirect('admin/transaction/pembayaran/'.$menuid);
			}


			public function edit_process_pembayaran($menuid, $ID)
			{
			  $data = array(
			  'id_supplier' => $this->input->post('supplier'),
			  'id_barang' => $this->input->post('barang'),
			  'tanggal_pembayaran' => $this->input->post('tanggal_pembayaran')
			  );
			  $this->db->where('ID',$ID);
			  $this->db->update('pembayaran_barang', $data);

			  redirect('admin/transaction/pembayaran/'.$menuid);
			}


			function changestatus_pembayaran($MENU_ID)
			{
			  $id = $this->input->get('ID');

			  $dataEdit = $this->master_model->dataedits('pembayaran_barang','ID',$id);
			  $status = $dataEdit[0]['status'];

			  if($status == 0)
			  {

			    $echo = '<label class="control control--radio">Belum Terim
			          <input type="radio" name="status" value="0" checked="checked"/>
			          <div class="control__indicator"></div>
			          </label>

			          <label class="control control--radio">Sudah Terima
			          <input type="radio" name="status" value="1"/>
			          <div class="control__indicator"></div>
			          </label>
			    ';

			  }else{

			    $echo = '<label class="control control--radio">Belum Terima
			          <input type="radio" name="status" value="0"/>
			          <div class="control__indicator"></div>
			          </label>

			          <label class="control control--radio">Sudah Terima
			          <input type="radio" name="status" value="1" checked="checked"/>
			          <div class="control__indicator"></div>
			          </label>';


			  }

			  echo'

			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal">&times;</button>
			    <h4 class="modal-title">Edit Status Permintaan</h4>
			  </div>
			  <form action="'.base_url().'admin/transaction/change_statuspembayaran/'.$MENU_ID.'" method="post">
			  <input type="hidden" name="ID" value="'.$dataEdit[0]['ID'].'">
			    <div class="modal-body">
			      <div class="form-group">
			        '.$echo .'
			      </div>
			    </div>
			    <div class="modal-footer">
			      <input type="submit" class="btn btn-info btn-fill pull-right" value="Save">
			      <!--<a class="btn btn-default pull-left" data-dismiss="modal">Close</a> -->
			    </div>
			  </form>

			  ';

			}

			function change_statuspembayaran($menuid){

			  $ID = $this->input->post('ID');

			  $data = array(
			 'status' => $this->input->post('status'),
			 'tanggal_terima' => date('Y-m-d'),
			 'admin' => $this->session->userdata('name_admin')
			 );
			 $this->db->where('ID',$ID);
			 $this->db->update('pembayaran_barang', $data);

			 redirect('admin/transaction/pembayaran/'.$menuid);
			}

			function getdatapenjualan(){
				$ID = $this->input->get('ID');
				$DataPenjualan = $this->master_model->detailPembayaran($ID);
				echo '
				<table id="example1" class="table table-bordered table-striped">

							<thead>

									<th>Konsumen</th>
									<th>Barang</th>
									<th>Tanggal</th>
									<th>Harga</th>

							</thead>

							<tbody>
							</tbody>

							<td>'.$DataPenjualan[0]->nama_konsumen.'</td>
							<td>'.$DataPenjualan[0]->nama_barang.'</td>
							<td>'.$DataPenjualan[0]->tanggal.'</td>
							<td>'.number_format($DataPenjualan[0]->harga).'</td>

							</table>
				';
			}

			//==================== BATAS pembayaran ====================//




}
?>
