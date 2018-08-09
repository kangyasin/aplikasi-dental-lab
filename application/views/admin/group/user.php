<?php 

	$this->load->view('admin/master/header');
	$fromPge = $this->uri->segment(2);
	$funct   = $this->uri->segment(3);
	$menuid  = $this->uri->segment(4);
	$id_group  = $this->uri->segment(5);
?>


<script>
	$(function() 
	{
		$(".edit").click(function(){
		   //$("#editUser").show();
		   var ID = $(this).attr('alt');
		   $.ajax({
			   	type:"POST",
				url: "<?php echo base_url().'admin/group/edit_user/'.$menuid.'';?>",
				data: "ID=" + ID,    
				success: function(data){
					$(".modal-edit").html(data);
				}
			});	
		});
	});
</script>





     <script type="text/javascript">

		  $(document).ready(function(){
			   $("#save").click(function(){
				var nama = $("#name").val();
				var password = $("#password").val();
				var re_pass = $("#re_pass").val();
				if(nama =='')
				{
				   alert('Kolom Nama tidak boleh kosong');
				   return false;
				}else if(password==''){
					alert('Kolom Password tidak boleh kosong');
					return false;
				}else if(re_pass == ''){
					alert('Kolom Confirm Password tidak boleh kosong');
					return false;
				}

				if(repass != pass )
				{
					alert('Password tidak sesuai');
					return false;
				}
				return true;

			});
		 });

		</script>


             <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Daftar User
                <small>advanced tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin/home/index/8"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url();?>admin/group/index/<?php echo $menuid;?>">Group</a></li>
                <li class="active">
					<?php 
						$data_group=$this->master_model->select_in('user_group','name',"WHERE ID=$id_group");
						echo $name_group=$data_group[0]->name;
					?>
                </li>
            </ol>
        </section>
                
  <section class="content">
      <div class="row">
      
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data User</h3>
              <a class="btn btn-info btn-fill pull-right" data-toggle="modal" data-target="#myModal">Tambah User Baru</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              
                        	<thead>
                            	<tr>
                                	<th>No.</th>
                                    <th>Nama User</th>
                                    <th>Nama Group</th>
                                    <th>Reset</th>
									<th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							for($a=0; $a < count($data_user); $a++)
							{
								$ID = $data_user[$a]->ID;
								$id_group = $data_user[$a]->id_group;
								$password = $data_user[$a]->password;
								$name  = $data_user[$a]->name;
								
								$data_group=$this->master_model->select_in('user_group','name',"WHERE ID=$id_group");
								$name_group=$data_group[0]->name;
								echo'
								<tr>
                                	<td>'.($a+1).'</td>
                                    <td>'.$name.'</td>
									<td>'.$name_group.'</td>
									<td>
									  <a href="'.base_url().'admin/group/reset_password/'.$menuid.'/'.$id_group.'/'.$ID.'" class="btn text-yellow" onClick="return confirm(\'Apakah anda yakin untuk merubah password user admin ini?\')">
									  	Reset Password 
									  </a>
									  Menjadi (123)
									</td>
									<td>
										<a class="edit text-green" style="cursor:pointer" alt="'.$ID.'" data-toggle="modal" data-target="#edit-modal">
											<i class="fa fa-edit"></i>
										 </a>
									</td>
									<td>
									  <a href="'.base_url().'admin/group/delete_user/'.$menuid.'/'.$id_group.'/'.$ID.'" class="text-red" onClick="return confirm(\'Delete this record?\')">  
									  		<i class="fa fa-trash-o"></i>
									  </a> 
									</td>
                                </tr>';

							}

							?>

                             </tbody>
                            </table>

					 </div>
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
  
  
  <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content" style="z-index:999">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Tambah User Baru</h4>
            </div>
                <form action="<?php echo base_url();?>admin/group/create_user/<?php echo $menuid.'/'.$id_group;?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    		
                        <div class="form-group">
                            <label>Nama User</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Password</label>
                            <div class="form-group input-group">
                                <input type="password" id="password" name="password" class="form-control" required placeholder="Password" autocomplete="off"/>
                                <label class="input-group-addon">
                                  <input type="checkbox" style="display:none"
                                    onclick="(function(e, el){
                                      document.getElementById('password').type = el.checked ? 'text' : 'password';
                                      el.parentNode.lastElementChild.innerHTML = el.checked ? '<i class=\'glyphicon glyphicon-eye-close\'>' : '<i class=\'glyphicon glyphicon-eye-open\'>';
                                      })(event, this)">
                                   <span><i class="glyphicon glyphicon-eye-open"></i></span>
                                </label>
                            </div>
                        </div>
                        
                        <script type="text/javascript">
							$(document).ready(function()
							{
								$("#re_pass").change(function (e)
								{
									var password= $("#password").val();
									var re_pass = $(this).val();
									$("#password-result").show();
									 
									if(re_pass == password)
									{
										exist=2;
										$("#password-result").html('<font style="color:#2BB0EA"><i class="fa fa-check" style="color:#2DBE00"></i> Password sesuai</font>');

									}else{
										exist=1;
										$("#password-result").html('<font style="color:#FF024F"><i class="fa fa-times"></i> Password tidak sesuai</font>');
									}
									
								});
								
								$("#save").click(function(){
									if(exist == 1)
									{
										alert('Password tidak sesuai');
										return false;
									}else{
										return true;
									}
								});
								
							});
						</script>
                        
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <span id="password-result" style="display:none"><i class="fa fa-refresh fa-spin"></i></span>
                            <div class="form-group input-group">
                                <input type="password" id="re_pass" name="re_pass" class="form-control" required placeholder="Password" autocomplete="off"/>
                                <label class="input-group-addon">
                                  <input type="checkbox" style="display:none" onclick="(function(e, el){
                                      document.getElementById('re_pass').type = el.checked ? 'text' : 'password';
                                      el.parentNode.lastElementChild.innerHTML = el.checked ? '<i class=\'glyphicon glyphicon-eye-close\'>' : '<i class=\'glyphicon glyphicon-eye-open\'>';
                                      })(event, this)">
                                   <span><i class="glyphicon glyphicon-eye-open"></i></span>
                                </label>
                            </div>
                    
                        </div>
                        <div class="form-group">
                        <label> Type </label>
                       	<select name="usergroup" id="usergroup" required class="form-control">
                            <?php 

                                $data_group = $this->master_model->select_in('user_group', '*', "WHERE ID<>1");

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

                            ?>

                        </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                		<input type="submit" class="btn btn-info btn-fill pull-right" value="Simpan" id="save">
                    	<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px;">Tutup</button>
                    </div>
                </form>
          </div>
        </div>
 	</div>
    
    <div class="modal fade" id="edit-modal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content modal-edit" style="z-index:999">
            	
			</div>
        </div>
 	</div>


    <?php $this->load->view('admin/master/footer'); ?>