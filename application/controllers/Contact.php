<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class contact extends CI_Controller {
	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		$this->load->helper('text');
		
    }
	
	function index()
	{
		$this->load->view('front/contact');
	}
	
	function send_message()
	{
		$captcha = $this->input->post('g-recaptcha-response');
		$secret_key = '6LcPTjQUAAAAAL50CUCRd502hggNsw7Rd9oNhuQ0';
		$error = '</br></br></br></br><h2 align="center"><b>Incorrectly CAPTCHA, sorry!</h2></b>'.header('refresh:5; url='.base_url().'contact');
		if ($captcha != '') 
		{
		   $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secret_key) . '&response=' . $captcha;   
		   $recaptcha = file_get_contents($url);
		   $recaptcha = json_decode($recaptcha, true);
		   
		   
		   if (!$recaptcha['success'])
		   {
				echo $error;
		   }else 
		   {
			    $reason=$this->input->post('reason');
				$title=$this->input->post('title');
				$first_name=$this->input->post('first_name');
				
				
				$this->kirim_email($name, $phone, $email, $message);	
				
				if($name =='')
				{
					return true;
				}else
				{		
					echo '<font color="#00346E">"Email has been sent"</font>';
				}
		 	}
			
		}else
		{
		   echo $error;
		}
	}
	
	function sent_message()
	{
		
		$name=$this->input->post('name');
		$phone=$this->input->post('phone');
		$email=$this->input->post('email');
		$note=$this->input->post('message');
		
		$this->kirim_email($name, $phone, $email, $note);	
		
		if($name =='')
		{
			return true;
		}else
		{		
			echo '<font color="#00346E">"Email has been sent"</font>';
		}
		 	
	}
	
	function kirim_email($name, $phone, $email, $note)
	{
		$fromEmail='info@m1nutrition.co.uk';
		$fromName='sales@m1nutrition.co.uk';
		$toEmail='info@m1nutrition.co.uk';
		$subject='Message from m1nutrition visitor';
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
		
		//echo $msg;
		//exit;
		
		$this->load->library('email');

		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
	   
		$this->email->initialize($config);
	   
		$this->email->from($fromEmail, $fromName);
		$this->email->to($toEmail);
	   
		$this->email->subject($subject);
		$this->email->message($message);
	 
		$this->email->send();
		
		redirect('contact/sucess');
	}
	
	public function sucess()
	{
		$this->load->view('front/message_sent');
	}
	
}
?>