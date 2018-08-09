<?php 

	$this->load->view('admin/master/header');
	$fromPge = $this->uri->segment(2);
	$funct   = $this->uri->segment(3);
	$menuid  = $this->uri->segment(4);
	
	$id_admin=$this->session->userdata('id_admin');
	
	//print_array($this->session->userdata)
	
?>




	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Rubah Password
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin/home/index/8"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Rubah Password</li>
            </ol>
        </section>
                
  <section class="content">
      <div class="row">
      
        <div class="col-xs-12">
          
          <div class="box">
          	<form action="<?php echo base_url();?>admin/group/change_password_proccess/<?php echo $menuid.'/'.$id_admin;?>" method="post">
                <div class="box-header">
                  <h3 class="box-title"> </h3>
                  <button type="submit" id="save" class="btn btn-info btn-fill pull-right">Simpan</button>
                </div>
                <div class="box-body">
                	<script type="text/javascript">
						$(document).ready(function()
						{
							$(".old_password").focusout(function (e)
							{
								var password = $("#password1").val();
								
								$.ajax({
									type:"POST",
									url: "<?php echo base_url().'admin/group/get_password/'.$menuid.'/'.$id_admin.'';?>",
									data: "password="+password,    
									success: function(data)
									{
										if(data==0)
										{
											alert('Password lama yang ada masukkan salah!');
											return false;
										}else
										{
											return true;
										}
									}
								});
							});
							
							$("#save").click(function (e)
							{
								var password = $("#password1").val();
								
								//alert(password);
								//return false;
								
								$.ajax({
									type:"POST",
									url: "<?php echo base_url().'admin/group/get_password/'.$menuid.'/'.$id_admin.'';?>",
									data: "password="+password,    
									success: function(data)
									{
										if(password=='')
										{
											alert('Anda belum memasukkan password lama!');
										}else
										{
											if(data==0)
											{
												alert('Password lama yang ada masukkan salah!');
												return false;
											}else
											{
												return true;
											}
										}
									}
								});
							});

						});
					</script>
                        
                    <label>Password Lama</label>
                    <div class="form-group input-group">
                        <input type="password" id="password1" name="old_password" class="form-control" required placeholder="Password" autocomplete="off"/>
                        <label class="input-group-addon">
                          <input type="checkbox" style="display:none"
                            onclick="(function(e, el){
                              document.getElementById('password1').type = el.checked ? 'text' : 'password';
                              el.parentNode.lastElementChild.innerHTML = el.checked ? '<i class=\'glyphicon glyphicon-eye-close\'>' : '<i class=\'glyphicon glyphicon-eye-open\'>';
                              })(event, this)">
                           <span><i class="glyphicon glyphicon-eye-open"></i></span>
                        </label>
                    </div>
                    
                    <label>Password Baru</label>
                    <div class="form-group input-group">
                        <input type="password" id="password2" name="password" class="form-control" required="required" placeholder="Password" autocomplete="off"/>
                        <label class="input-group-addon">
                          <input type="checkbox" style="display:none"
                            onclick="(function(e, el){
                              document.getElementById('password2').type = el.checked ? 'text' : 'password';
                              el.parentNode.lastElementChild.innerHTML = el.checked ? '<i class=\'glyphicon glyphicon-eye-close\'>' : '<i class=\'glyphicon glyphicon-eye-open\'>';
                              })(event, this)">
                           <span><i class="glyphicon glyphicon-eye-open"></i></span>
                        </label>
                    </div>
                    
                    <script type="text/javascript">
						$(document).ready(function()
						{
							$(".re_password").focusout(function (e)
							{
								var password2 = $("#password2").val();
								var password3 = $("#password3").val();
								
								//alert(password);
								//return false;
								
								if(password2==password3)
								{
									return true;
								}else
								{
									alert('Password lama yang ada masukkan salah!');
									return false;
								}
								
							});
							
							$("#save").click(function (e)
							{
								var password2 = $("#password2").val();
								var password3 = $("#password3").val();
								
								//alert(password);
								//return false;
								
								if(password2==password3)
								{
									return true;
								}else
								{
									alert('Password lama yang ada masukkan salah!');
									return false;
								}
								
							});
						});
					</script>
                    
                    <label>Ulangi Password Baru</label>
                    <div class="form-group input-group">
                        <input type="password" id="password3" name="re_password" class="form-control re_password" required="required" placeholder="Password" autocomplete="off"/>
                        <label class="input-group-addon">
                          <input type="checkbox" style="display:none"
                            onclick="(function(e, el){
                              document.getElementById('password3').type = el.checked ? 'text' : 'password';
                              el.parentNode.lastElementChild.innerHTML = el.checked ? '<i class=\'glyphicon glyphicon-eye-close\'>' : '<i class=\'glyphicon glyphicon-eye-open\'>';
                              })(event, this)">
                           <span><i class="glyphicon glyphicon-eye-open"></i></span>
                        </label>
                    </div>
                    
                </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
  


    <?php $this->load->view('admin/master/footer'); ?>