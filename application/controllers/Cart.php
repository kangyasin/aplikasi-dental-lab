<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cart extends CI_Controller {

	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		$this->load->library('cart');
    }

	

	function index()

	{
		$this->load->view('front/cart');
	}
	
	public function order() 
	{		
		//print_array($this->input->post());
		//exit;
		
		$ID=$this->input->post('ID');
		$qty=$this->input->post('qty');
		$flavour=$this->input->post('flavour');
		$weight=$this->input->post('weight');
		$price=$this->input->post('price');
		$name=$this->input->post('name');
		
		$results = $this->cart->contents();
		
		if(!empty($results))
		{
			foreach ($results as $item)
			{
				if ($item['id'] == $ID.'-'.$flavour.'-'.$weight)
				{
					$qty = $item['qty']+$qty;
				}
			}
		}
					
		$data = array(
		   'id'      	 => $ID.'-'.$flavour.'-'.$weight,
		   'qty'     	=> $qty,
		   'price'   	  => $price,
		   'id_product' => $ID,
		   'flavour' 	=> $flavour,
		   'weight'  	 => $weight,
		   'name'       => str_replace('%','',$name) 
		);
			
	   $this->cart->insert($data);
	   
	   redirect('cart');
	}
	
	function delete_cart_item()
	{		
		$rowid  = $this->input->post('rowid');
		$data = array(
			'rowid'   => $rowid,
		   	'qty'     => 0,
		);
			
		$this->cart->update($data); 
		redirect('cart/index');	
	}
	
	function add_qty()
	{
		$rowid  = $this->input->post('rowid');
		
		$cart=$this->cart->contents();
		if(!empty($cart))
		{
			foreach ($cart as $item)
			{
				if ($item['rowid'] == $rowid)
				{
					$qty = $item['qty']+1;
				}
			}
		}
		
		$data = array
		(
		   'rowid' => $rowid,
		   'qty'   => $qty
		);
		
		$this->cart->update($data); 
		
		redirect('cart/index');
	}
	
	function min_qty()
	{
		$rowid  = $this->input->post('rowid');
		
		$cart=$this->cart->contents();
		if(!empty($cart))
		{
			foreach ($cart as $item)
			{
				if ($item['rowid'] == $rowid)
				{
					$qty = $item['qty']-1;
				}
			}
		}
		
		$data = array
		(
		   'rowid' => $rowid,
		   'qty'   => $qty
		);
		
		$this->cart->update($data); 
		
		redirect('cart/index');
	}
	
	public function next()
	{
		//$total=$this->input->post('total');
		
		$this->load->view('front/form');
	}
	
	public function checkout()
	{
		$cart=$this->cart->contents();
		$email=$this->input->post('email');
		
		$ID=$this->master_model->mst_last_id('transaction');
		
		$create_invoice=$this->master_model->create_invoice($ID);
		
		$check_customer=$this->master_model->select_in('ms_customer','ID', "WHERE email='$email'");
		$count_customer=count($check_customer);
		
		if($count_customer==0)
		{
			$id_customer=$this->master_model->mst_last_id('ms_customer');
			$data_customer=array
			(
				'ID'=>$id_customer,
				'name'=>$this->input->post('first_name').' '.$this->input->post('last_name'),
				'email'=>$email,
				'address1'=>$this->input->post('address1'),
				'address2'=>$this->input->post('address2').' '.$this->input->post('city').' '.$this->input->post('state').' '.$this->input->post('zip'),
				'phone'=>$this->input->post('phone'),
				'sort'=>$id_customer,
			);
			$this->db->insert('ms_customer', $data_customer);
		}else
		{
			$id_customer=$check_customer[0]->ID;
			$data_customer=array
			(
				'name'=>$this->input->post('first_name').' '.$this->input->post('last_name'),
				'address1'=>$this->input->post('address1'),
				'address2'=>$this->input->post('address2').' '.$this->input->post('city').' '.$this->input->post('state').' '.$this->input->post('zip'),
				'phone'=>$this->input->post('phone'),
			);
			$this->db->where('email', $email);
			$this->db->update('ms_customer', $data_customer);
		}
		
		$id_transaction=$this->master_model->mst_last_id('transaction');
		$data_transaction=array
		(
			'ID'=>$id_transaction,
			'no_invoice'=>$create_invoice,
			'id_customer'=>$id_customer,
			'date_in'=>date('Y-m-d'),
			'grandtotal'=>$this->cart->total(),
			'status'=>0,
			'sort'=>$id_transaction,
		);
		$this->db->insert('transaction', $data_transaction);
		
		foreach($cart as $k=>$v)
		{
			$rowid  	 = $v['rowid'];
			$id   		= $v['id'];
			$qty	   = $v['qty'];
			$price  	 = $v['price'];
			$ID   	    = $v['id_product'];
			$flavour   = $v['flavour'];
			$weight   	= $v['weight'];
			$name   	  = $v['name'];
			$subtotal  = $v['subtotal'];
			
			$id_transaction_detail=$this->master_model->mst_last_id('transaction_detail');
			$data_transaction=array
			(
				'ID'=>$id_transaction_detail,
				'id_transaction'=>$id_transaction,
				'id_product'=>$ID,
				'id_flavour'=>$flavour,
				'id_weight'=>$weight,
				'qty'=>$qty,
				'price'=>$price,
				'subtotal'=>$subtotal,
				'sort'=>$id_transaction_detail,
			);
			$this->db->insert('transaction_detail', $data_transaction);
		}
		
		$message='
			<table cellpadding="10" cellspacing="0" style="background:#eeeeee" width="100%">
				<tbody>
					<tr>
						<td>
							<table border="0" cellpadding="10" cellspacing="0" style="background:#FFF; margin:0 auto" width="600px">
								<tbody>
									<tr style="background:#000">
										<td align="center" colspan="6">
											<img src="'.base_url().'assets/img/logo.png" style="width: 200px; height: 47px;" /><br />
										</td>
									</tr>
									<tr>
										<td align="left" colspan="6">
											<strong>Order :</strong> '.$create_invoice.'
											<br>
											';
												$today=date('Y-m-d');
												$today=date('M d, Y',strtotime($today));
											$message .='
											<strong>Created Date :</strong> '.$today.'
										</td>
									</tr>
									<tr>
										<td align="left" colspan="6">
											<strong style="color:#EE5B4B">Shipping Address</strong>
											<br>
											'.$this->input->post('first_name').' '.$this->input->post('last_name').'
											<br>
											'.$this->input->post('address1').' '.$this->input->post('address2').', '.$this->input->post('city').'
											<br>
											'.$this->input->post('state').', '.$this->input->post('zip').'
											<br>
											Phone : '.$this->input->post('phone').'
										</td>
									</tr>
									<!--
									<tr>
										<td colspan="3">
											<strong style="color:#EE5B4B">Payment Information</strong>
											<br>
											Check / Money Order
										</td>
										<td colspan="3">
											<strong style="color:#EE5B4B">Delivery Information</strong>
											<br>
											Flat Rate - Fixed
										</td>
									</tr>
									-->
									<tr style="background:#000; color:#fff;">
										<td colspan="3" align="center">
											<strong>Product</strong>
										</td>
										<td align="center">
											<strong>Price</strong>
										</td>
										<td align="center">
											<strong>Qty</strong>
										</td>
										<td align="center">
											<strong>Subtotal</strong>
										</td>
									</tr>
									';
										$total=0;
										$a=1;
										foreach($cart as $k=>$v)
										{
											$rowid  	 = $v['rowid'];
											$id   		= $v['id'];
											$qty	   = $v['qty'];
											$price  	 = $v['price'];
											$ID   	    = $v['id_product'];
											$flavour   = $v['flavour'];
											$weight   	= $v['weight'];
											$name   	  = $v['name'];
											$subtotal  = $v['subtotal'];
											
											
											$data_product=$this->master_model->select_in('ms_product','id_category',"WHERE ID=$ID");
											
											$data_gallery=$this->master_model->select_in('ms_product_flavour','image',"WHERE id_product=$ID AND id_flavour=$flavour AND id_weight=$weight");
											
											$data_variant=$this->master_model->select_in('ms_product_flavour','id_flavour, id_weight, price, discount',"WHERE id_product=$ID");
											$discount=$data_variant[0]->discount;
											
											
											$id_weight=$data_variant[0]->id_weight;
											
											$data_weight=$this->master_model->select_in('ms_weight','name',"WHERE ID=$weight");
											
											$data_flavour=$this->master_model->select_in('ms_flavour','name',"WHERE ID=$flavour");
											
											
											$est_total=$qty*$price;
											$est_total=$total+$est_total;
											
											$message .='
												<tr>
													<td colspan="2">
														<img src="'.base_url().'uploads/products/'.$data_gallery[0]->image.'" width="40">
													</td>
													<td>
														'.$name.'
														<br>
														<span style="font-size:11px">
															'.$data_weight[0]->name.' '.$data_flavour[0]->name.'
														</span>
													</td>
													<td align="center">
														&pound;'.$price.'
													</td>
													<td align="center">
														'.$qty.'
													</td>
													<td align="right">
														&pound;'.$subtotal.'
													</td>
												</tr>
											';
										}
									$message .='
									
									<tr>
										<td colspan="5" align="right">
											<strong>Total :</strong>
										</td>
										<td align="right">
											<strong>&pound;'.$this->cart->total().'</strong>
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
											We will contact you for stock availabilty and best shipping price to you.
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
										</td>
									</tr>
									
									<tr>
										<td align="center" colspan="6" style="background:#000; color:#fff; padding:10px 6px; font-size:11px;">
											Copyright © 2016-2017 M1 Nutrition. All rights reserved. 
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		';
		
		//exit;
		
		$fromEmail = 'info@m1nutrition.co.uk';
		$fromName  = 'm1nutrition.co.uk';
		$toEmail   = $email;
		$subject   = 'New Order #'.$create_invoice;
		$msg       = $message;	
		
		$this->send_message($fromEmail, $fromName, $toEmail, $subject, $msg);	
				
		$message2='
			<table cellpadding="10" cellspacing="0" style="background:#eeeeee" width="100%">
				<tbody>
					<tr>
						<td>
							<table border="0" cellpadding="10" cellspacing="0" style="background:#FFF; margin:0 auto" width="600px">
								<tbody>
									<tr style="background:#000">
										<td align="center" colspan="6">
											<img src="'.base_url().'assets/img/logo.png" style="width: 200px; height: 47px;" /><br />
										</td>
									</tr>
									<tr>
										<td align="left" colspan="6">
											<strong>Order :</strong> '.$create_invoice.'
											<br>
											';
												$today=date('Y-m-d');
												$today=date('M d, Y',strtotime($today));
											$message2 .='
											<strong>Created Date :</strong> '.$today.'
										</td>
									</tr>
									<tr>
										<td align="left" colspan="6">
											<strong style="color:#EE5B4B">Shipping Address</strong>
											<br>
											'.$this->input->post('first_name').' '.$this->input->post('last_name').'
											<br>
											'.$this->input->post('address1').' '.$this->input->post('address2').', '.$this->input->post('city').'
											<br>
											'.$this->input->post('state').', '.$this->input->post('zip').'
											<br>
											Phone : '.$this->input->post('phone').'
										</td>
									</tr>
									<!--
									<tr>
										<td colspan="3">
											<strong style="color:#EE5B4B">Payment Information</strong>
											<br>
											Check / Money Order
										</td>
										<td colspan="3">
											<strong style="color:#EE5B4B">Delivery Information</strong>
											<br>
											Flat Rate - Fixed
										</td>
									</tr>
									-->
									<tr style="background:#000; color:#fff;">
										<td colspan="3" align="center">
											<strong>Product</strong>
										</td>
										<td align="center">
											<strong>Price</strong>
										</td>
										<td align="center">
											<strong>Qty</strong>
										</td>
										<td align="center">
											<strong>Subtotal</strong>
										</td>
									</tr>
									';
										$total=0;
										$a=1;
										foreach($cart as $k=>$v)
										{
											$rowid  	 = $v['rowid'];
											$id   		= $v['id'];
											$qty	   = $v['qty'];
											$price  	 = $v['price'];
											$ID   	    = $v['id_product'];
											$flavour   = $v['flavour'];
											$weight   	= $v['weight'];
											$name   	  = $v['name'];
											$subtotal  = $v['subtotal'];
											
											
											$data_product=$this->master_model->select_in('ms_product','id_category',"WHERE ID=$ID");
											
											$data_gallery=$this->master_model->select_in('ms_product_flavour','image',"WHERE id_product=$ID AND id_flavour=$flavour AND id_weight=$weight");
											
											$data_variant=$this->master_model->select_in('ms_product_flavour','id_flavour, id_weight, price, discount',"WHERE id_product=$ID");
											$discount=$data_variant[0]->discount;
											
											
											$id_weight=$data_variant[0]->id_weight;
											
											$data_weight=$this->master_model->select_in('ms_weight','name',"WHERE ID=$weight");
											
											$data_flavour=$this->master_model->select_in('ms_flavour','name',"WHERE ID=$flavour");
											
											
											$est_total=$qty*$price;
											$est_total=$total+$est_total;
											
											$message2 .='
												<tr>
													<td colspan="2">
														<img src="'.base_url().'uploads/products/'.$data_gallery[0]->image.'" width="40">
													</td>
													<td>
														'.$name.'
														<br>
														<span style="font-size:11px">
															'.$data_weight[0]->name.' '.$data_flavour[0]->name.'
														</span>
													</td>
													<td align="center">
														&pound;'.$price.'
													</td>
													<td align="center">
														'.$qty.'
													</td>
													<td align="right">
														&pound;'.$subtotal.'
													</td>
												</tr>
											';
										}
									$message2 .='
									
									<tr>
										<td colspan="5" align="right">
											<strong>Total :</strong>
										</td>
										<td align="right">
											<strong>&pound;'.$this->cart->total().'</strong>
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
											We will contact you for stock availabilty and best shipping price to you.
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
										</td>
									</tr>
									
									<tr>
										<td colspan="6">
										</td>
									</tr>
									
									<tr>
										<td align="center" colspan="6" style="background:#000; color:#fff; padding:10px 6px; font-size:11px;">
											Copyright © 2016-2017 M1 Nutrition. All rights reserved. 
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		';
		
		$fromEmail = $email;
		$fromName  = 'm1nutrition.co.uk';
		$toEmail   = 'info@m1nutrition.co.uk';
		$subject   = 'New Order #'.$create_invoice;
		$msg       = $message2;		
		
		$this->send_message($fromEmail, $fromName, $toEmail, $subject, $msg);
		
		$this->cart->destroy();
		redirect('checkout/finish');
	}
	
	function send_message($fromEmail, $fromName, $toEmail, $subject, $msg)
	{
		$this->load->library('email');
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		$this->email->from($fromEmail, $fromName);
		$this->email->to($toEmail);
		$this->email->subject($subject);
		$this->email->message($msg);
		$this->email->send();
	}
	
}

?>