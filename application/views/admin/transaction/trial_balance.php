	
	<?php 
        $this->load->view('admin/master/header');
        $menuid = $this->uri->segment(4); 
    ?>


	<script>
		$(function()
		{
			$(".edit").click(function()
			{
			   var ID = $(this).attr('alt');
			   $.ajax({
				   	type: "POST",
					dataType: "html",
					url: "<?php echo base_url().'admin/master/edit_flavour/'.$menuid.'';?>",
					data: "ID="+ID,    
					success: function(data)
					{
						$(".modal-edit").html(data);
					}
				});	
			});
		});
    </script>




        <div class="content-wrapper">

            <section class="content-header">

                <h1>
                    Trial Balance
                </h1>

                <ol class="breadcrumb">

                    <li><a href="<?php echo base_url();?>admin/home/index/8"><i class="fa fa-dashboard"></i> Home</a></li>

                    <li class="active">Trial Balance</li>

                </ol>

            </section>


				<section class="content">

      <div class="row">

      

        <div class="col-xs-12">

          
		  <form action="<?php echo base_url();?>admin/master/update_flavour/<?php echo $menuid;?>" method="post">
          <div class="box">

            <div class="box-header">

              <h3 class="box-title">Data Trial Balance</h3>

               	<a class="btn btn-info btn-fill pull-right" data-toggle="modal" data-target="#myModal">Add New</a>
                
            </div>

            

            <div class="box-body">

              <table class="table table-bordered table-striped">
                        <thead>
                            <th>Akun</th>
                            <th>Nama Akun</th>
                            <th>Draft</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Final</th>
                        </thead>
    
                        <tbody>
                        <?php
                            //print_array($this->session->userdata);
							
                            for($a=0 ; $a<count($data_group) ; $a++)
                            { 
                                $ID  = $data_group[$a]->id_setting;
								$subgroup2  = $data_group[$a]->sub_group_2;
                                $b=$a+1;
								
								echo '
								<tr><td colspan="6"><strong>'.$subgroup2.'</strong></td></tr>';
								
								$data_account = $this->master_model->select_in("account_setting","*","where sub_group_2 = '$subgroup2'");
								
								for($c=0; $c<count($data_account); $c++){
									$ID_det  = $data_account[$c]->id_setting;
									$akun_no = $data_account[$c]->akun_no;
									$nama_akun_indonesia = $data_account[$c]->nama_akun_indonesia;
									
									echo '<tr>
											<td align="right">'.$akun_no.' </td>
											<td>'.$nama_akun_indonesia.'</td>
											<td><input type="text" size="4" Name="draft[]" class="form-control" placeholder="draft"></td>
											<td><input type="text" size="4" Name="debet[]" class="form-control" placeholder="debet"></td>
											<td><input type="text" size="4" Name="kredit[]" class="form-control" placeholder="kredit"></td>
											<td><input type="text" size="4" Name="final[]" class="form-control" placeholder="final"></td>
										</tr>';
									
								}
								
								echo'<tr>
											<td align="right" colspan="2"></td>
											<td><input type="text" size="4" Name="draft[]" class="form-control" placeholder="value"></td>
											<td><input type="text" size="4" Name="debet[]" class="form-control" placeholder="value"></td>
											<td><input type="text" size="4" Name="kredit[]" class="form-control" placeholder="value"></td>
											<td><input type="text" size="4" Name="final[]" class="form-control" placeholder="value"></td>
										</tr>';
								
							}
                        ?>
                        <tr>
                        <td colspan="2" align="left"><strong>Laba/Rugi Tahun Jalan</strong></td>
                        <td><input type="text" size="4" Name="draft[]" class="form-control" placeholder="value"></td>
                        <td><input type="text" size="4" Name="debet[]" class="form-control" placeholder="value"></td>
                        <td><input type="text" size="4" Name="kredit[]" class="form-control" placeholder="value"></td>
                        <td><input type="text" size="4" Name="final[]" class="form-control" placeholder="value"></td>
                        </tr>
                        
                        <tr>
                        <td colspan="2" align="left"><strong>Cek Laba</strong></td>
                        <td><input type="text" size="4" Name="draft[]" class="form-control" placeholder="value"></td>
                        <td><input type="text" size="4" Name="debet[]" class="form-control" placeholder="value"></td>
                        <td><input type="text" size="4" Name="kredit[]" class="form-control" placeholder="value"></td>
                        <td><input type="text" size="4" Name="final[]" class="form-control" placeholder="value"></td>
                        </tr>
                        
                         <tr>
                        <td colspan="3" align="left"></td>
                        <td><strong>1.2345.678.901</strong></td>
                        <td><strong>1.2345.678.901</strong></td>
                        <td></td>
                        </tr>
    
                </tbody>
            </table>



                        

          </div>

          <!-- /.box -->

        </div>
        </form>

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>



	<div class="modal fade" id="myModal" role="dialog">

        <div class="modal-dialog">

          <div class="modal-content" style="z-index:9999">

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 class="modal-title">Add Account Setting</h4>

            </div>
                <form action="<?php echo base_url();?>admin/master/insert_flavour/<?php echo $menuid;?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Flavour Name" required="required">
                        </div>
                    </div>
                    <div class="modal-footer">
                		<input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">
                    	<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px;">Close</button>
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


	<?php 
        $this->load->view('admin/master/footer');
    ?>