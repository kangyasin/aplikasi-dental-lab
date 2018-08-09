<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class product extends CI_Controller {

	public function __construct()
	{
		parent :: __construct();	
		$this->load->model('admin/master_model');
		$this->load->library('cart');
    }


	function index()
	{
		$this->load->view('front/product');
	}

	function category($ID, $name)

	{
		$this->load->view('front/category');
	}

	

	function detail($id_category, $ID, $name)
	{
		//$this->session->unset_userdata('cart_contents');
		
		$this->load->view('front/detail');
	}

	

	function change_flavour($id_product)
	{
		$id_flavour=$this->input->post('flavour');
		
		echo'
			<select name="weight" class="change-weight change-price-weight change-image-weight" id="weight" required style="width:100%; background:#F3F3F3; font-size:12px; padding:10px; border:1px solid #E0E0E0">
				';
					$data_weight_product=$this->master_model->select_in('ms_product_flavour','id_weight, price, discount',"WHERE id_product=$id_product AND id_flavour=$id_flavour");
					for($b=0; $b < count($data_weight_product); $b++)
					{
						$id_flavour_2=$data_weight_product[$b]->ID;
						$id_weight=$data_weight_product[$b]->id_weight;
						
						$data_weight=$this->master_model->select_in('ms_weight','ID, name',"WHERE ID=$id_weight");
						
						$discount_weight=$data_weight_product[$b]->discount;
						
						if($discount_weight==0)
						{
							$price_weight='- &pound;'.$data_weight_product[$b]->price;
							$price_to_cart=$data_weight_product[$b]->price;
						}else
						{
							$price_weight='- &pound;'.$data_weight_product[$b]->discount;
							$price_to_cart=$data_weight_product[$b]->discount;
						}
							
						if($id_flavour==$id_flavour_2)
						{
							$selected='selected="selected"';
						}else
						{
							$selected='';
						}
						echo'
							<option value="'.$data_weight[0]->ID.'" '.$selected.'>
								'.$data_weight[0]->name.' '.$price_weight.'
							</option>
						';
					}
				echo'
			</select>
			
			<input name="price" type="hidden" value="'.$price_to_cart.'"/>
			
			<script>
				$(document).ready(function() 
				{
					$(".change-weight").change(function()
					{
						var weight = $(this).val();
						
						$.ajax({
							 type: "POST",
							 dataType: "html",
							 url: "'.base_url().'product/change_weight/'.$id_product.'",
							 data:"weight="+weight,
							 success: function(msg)
							 {
								$(".change_weight_price").html(msg);
							 }
						}); 	
					});
					
					$(".change-price-weight").change(function()
					{
						var weight = $(this).val();
						var flavour =$("#flavour").val();
						
						$.ajax({
							 type: "POST",
							 dataType: "html",
							 url: "'.base_url().'product/change_price_2/"+flavour+"/'.$id_product.'",
							 data:"weight="+weight,
							 success: function(msg)
							 {
								$(".change_price").html(msg);
							 }
						}); 	
					});
					
					$(".change-image-weight").change(function()
					{
						var weight = $(this).val();
						var flavour =$("#flavour").val();
						
						$.ajax({
							 type: "POST",
							 dataType: "html",
							 url: "'.base_url().'product/change_main_image_2/"+flavour+"/'.$id_product.'",
							 data:"weight="+weight,
							 success: function(msg)
							 {
								$(".change_main_image").html(msg);
							 }
						}); 	
					});
				});
			</script>
		';
	}
	
	public function change_price($id_product)
	{
		$id_flavour=$this->input->post('flavour');
		
		$check_flavour=$this->master_model->mst_check('ms_product_flavour','id_product',$id_product);
                                                                
		if($check_flavour==false)
		{
			$price='0';
			$discount='0';
		}else
		{
			$data_product_flavour=$this->master_model->select_in('ms_product_flavour','price, discount',"WHERE id_product=$id_product AND id_flavour=$id_flavour");
			$price=$data_product_flavour[0]->price;
			$discount=$data_product_flavour[0]->discount;
		}
		 
		if($discount==0)
		{
			echo'';
		}else
		{
			echo'
				<div class="col-md-12">
					<span style="color:#17CDF6">
						<strong><i class="fa fa-star"></i> ON SALE</strong>
					</span>
				</div>
			';
		}
		
		echo'
			<div class="col-md-3">
				<h4 class="pull-left">&pound; </h4> 
				<span style="color:#000; font-size:36px; font-weight:bold">
					';
						if($discount==0)
						{
							$price2=$price;
						}else
						{
							$price2=$discount;
						}
					echo'
					'.$price2.'
					<input name="price" type="hidden" value="'.$price2.'"/>
				</span>
			</div>
			';
			if($discount==0)
			{
				echo'';
			}else
			{
				echo'
					<div class="col-md-4" style="line-height:14px; padding-top:10px; color:#CCC; font-size:12px">
						ORIGINALLY
						<br />
						<span style="text-decoration:line-through">
							&pound;'.$price.'
						</span>
					</div>
				';
			}
	}
	
	public function change_weight($id_flavour, $id_product)
	{
		$id_weight=$this->input->post('weight');
		
		$data_product_flavour=$this->master_model->select_in('ms_product_flavour','price, discount',"WHERE id_product=$id_product AND id_flavour=$id_flavour AND id_weight=$id_weight");
		if($data_product_flavour[0]->discount==0)
		{
			$price_to_cart=$data_product_flavour[0]->price;
		}else
		{
			$price_to_cart=$data_product_flavour[0]->discount;
		}
		
		echo'<input name="price" type="hidden" value="'.$price_to_cart.'"/>';
	}
	
	
	public function change_price_2($id_flavour, $id_product)
	{
		$id_weight=$this->input->post('weight');
		
		$check_flavour=$this->master_model->mst_check('ms_product_flavour','id_product',$id_product);
                                                                
		if($check_flavour==false)
		{
			$price='0';
			$discount='0';
		}else
		{
			$data_product_flavour=$this->master_model->select_in('ms_product_flavour','price, discount',"WHERE id_product=$id_product AND id_flavour=$id_flavour AND id_weight=$id_weight");
			$price=$data_product_flavour[0]->price;
			$discount=$data_product_flavour[0]->discount;
		}
		 
		if($discount==0)
		{
			echo'';
		}else
		{
			echo'
				<div class="col-md-12">
					<span style="color:#17CDF6">
						<strong><i class="fa fa-star"></i> ON SALE</strong>
					</span>
				</div>
			';
		}
		
		echo'
			<div class="col-md-3">
				<h4 class="pull-left">&pound; </h4> 
				<span style="color:#000; font-size:36px; font-weight:bold">
					';
						if($discount==0)
						{
							$price2=$price;
						}else
						{
							$price2=$discount;
						}
					echo'
					'.$price2.'
					<input name="price" type="hidden" value="'.$price2.'"/>
				</span>
			</div>
			';
			if($discount==0)
			{
				echo'';
			}else
			{
				echo'
					<div class="col-md-4" style="line-height:14px; padding-top:10px; color:#CCC; font-size:12px">
						ORIGINALLY
						<br />
						<span style="text-decoration:line-through">
							&pound;'.$price.'
						</span>
					</div>
				';
			}
	}
	
	
	public function change_main_image($id_weight, $id_product)
	{
		$id_flavour=$this->input->post('flavour');
		
		$data_gallery=$this->master_model->select_in('ms_product_flavour','image',"WHERE id_product=$id_product AND id_flavour=$id_flavour AND id_weight=$id_weight");
		$count_gallery=count($data_gallery);

		if($count_gallery==0)
		{
			$image='noimage.jpg';
		}else
		{
			$image=$data_gallery[0]->image;
		}
		
		echo'
			<script src="'.base_url().'assets/js/jquery.js" ></script> 
        	<script src="'.base_url().'assets/js/zoom.js" ></script> 
			
			<img id="zoom_03" src="'.base_url().'uploads/products/'.$image.'" data-zoom-image="'.base_url().'uploads/products/'.$image.'" width="100%"/>
			
			<div class="col-md-12" style="background:#000; text-align:center; padding:10px; margin-bottom:5px;">
				';
					$data_gallery_2=$this->master_model->select_in('ms_product_flavour','image_facts',"WHERE id_product=$id_product AND main=1");
					$count_gallery_2=count($data_gallery_2);

					if($count_gallery_2==0)
					{
						$image_facts='noimage.jpg';
					}else
					{
						$image_facts=$data_gallery_2[0]->image_facts;
					}
				echo'
				<a href="'.base_url().'uploads/nutrition/'.$image_facts.'" data-lightbox-gallery="food-gallery">
					<i class="fa fa-info" aria-hidden="true"></i> Nutritional Facts
				</a>
				';
					$data_gallery_3=$this->master_model->select_in('ms_product_flavour','image_facts',"WHERE id_product=$id_product AND main=0 ORDER BY sort ASC");
					for($f=0; $f < count($data_gallery_3); $f++)
					{
						echo'
							<a href="'.base_url().'uploads/nutrition/'.$data_gallery_3[$f]->image_facts.'" data-lightbox-gallery="food-gallery" style="display:none">
								<img src="'.base_url().'uploads/nutrition/'.$data_gallery_3[$f]->image_facts.'" width="100%"/>
							</a>
						';
					}
				echo'
			</div>
			
			<div id="gallery_01">
				';
					$data_gallery_2=$this->master_model->select_in('ms_product_flavour','id_product, id_flavour, id_weight, image',"WHERE id_product=$id_product ORDER BY sort ASC");
					for($g=0; $g < count($data_gallery_2); $g++)
					{
						if($data_gallery_2[$g]->id_flavour==$id_flavour && $data_gallery_2[$g]->id_weight==$id_weight && $data_gallery_2[$g]->id_product==$id_product)
						{
							$active_image='class="active"';
						}else
						{
							$active_image='';
						}
						echo'
							<a href="#" data-image="'.base_url().'uploads/products/'.$data_gallery_2[$g]->image.'" data-zoom-image="'.base_url().'uploads/products/'.$data_gallery_2[$g]->image.'" '.$active_image.'>
								<img id="zoom_01" src="'.base_url().'uploads/products/'.$data_gallery_2[$g]->image.'" width="24%" />
							</a>
						';
					}
				echo'
			</div>
			
										
			<script>
				$("#zoom_01").bind("click", function(e) {  
				  var ez =   $("#zoom_01").data("elevateZoom");	
					$.fancybox(ez.getGalleryList());
				  return false;
				});
				
				$("#zoom_03").elevateZoom({
					gallery : "gallery_01",
					galleryActiveClass: "active"
				}); 
			</script>
		';
	}
	
	public function change_main_image_2($id_flavour, $id_product)
	{
		$id_weight=$this->input->post('weight');
		
		$data_gallery=$this->master_model->select_in('ms_product_flavour','image',"WHERE id_product=$id_product AND id_flavour=$id_flavour AND id_weight=$id_weight");
		$count_gallery=count($data_gallery);

		if($count_gallery==0)
		{
			$image='noimage.jpg';
		}else
		{
			$image=$data_gallery[0]->image;
		}
		
		echo'
			<script src="'.base_url().'assets/js/jquery.js" ></script> 
        	<script src="'.base_url().'assets/js/zoom.js" ></script> 
			
			<img id="zoom_03" src="'.base_url().'uploads/products/'.$image.'" data-zoom-image="'.base_url().'uploads/products/'.$image.'" width="100%"/>
			
			<div class="col-md-12" style="background:#000; text-align:center; padding:10px; margin-bottom:5px;">
				<a href="'.base_url().'uploads/nutrition/5.png" data-lightbox-gallery="food-gallery">
					<i class="fa fa-info" aria-hidden="true"></i> Nutritional Facts
				</a>
				<a href="'.base_url().'uploads/nutrition/6.png" data-lightbox-gallery="food-gallery" style="display:none">
					<img src="'.base_url().'uploads/nutrition/6.png"width="100%"/>
				</a>
			</div>
			
			<div id="gallery_01">
				';
					$data_gallery_2=$this->master_model->select_in('ms_product_flavour','id_product, id_flavour, id_weight, image',"WHERE id_product=$id_product ORDER BY sort ASC");
					for($g=0; $g < count($data_gallery_2); $g++)
					{
						if($data_gallery_2[$g]->id_flavour==$id_flavour && $data_gallery_2[$g]->id_weight==$id_weight && $data_gallery_2[$g]->id_product==$id_product)
						{
							$active_image='class="active"';
						}else
						{
							$active_image='';
						}
						echo'
							<a href="#" data-image="'.base_url().'uploads/products/'.$data_gallery_2[$g]->image.'" data-zoom-image="'.base_url().'uploads/products/'.$data_gallery_2[$g]->image.'" '.$active_image.'>
								<img id="zoom_01" src="'.base_url().'uploads/products/'.$data_gallery_2[$g]->image.'" width="24%" />
							</a>
						';
					}
				echo'
			</div>
								
			<script>
				$("#zoom_01").bind("click", function(e) {  
				  var ez =   $("#zoom_01").data("elevateZoom");	
					$.fancybox(ez.getGalleryList());
				  return false;
				});
				
				$("#zoom_03").elevateZoom({
					gallery : "gallery_01",
					galleryActiveClass: "active"
				}); 
			</script>
		';
	}
	
	
	public function get_product()
	{
		$product=$this->input->get('product');
		$data_product=$this->master_model->select_in('ms_product','name',"WHERE name LIKE '%$product%' AND publish=1");
		for($c=0; $c < count($data_product); $c++)
		{
			$name=$data_product[$c]->name;
			echo'
				<option value="'.$name.'">
			';
		}
	}
	
	public function search()
	{
		$product=$this->input->post('search_product');
		
		$check_product=$this->master_model->select_in('ms_product','ID, id_category, name',"WHERE name LIKE '%$product%' AND publish=1");
		$count=count($check_product);
		
		if($count=='')
		{
			echo'failed';
		}else
		{
			echo 'detail/'.$check_product[0]->id_category.'/'.$check_product[0]->ID.'/'.str_replace(' ','-', str_replace('%','', strtolower($check_product[0]->name))).'';
		}
	}
	
}

?>