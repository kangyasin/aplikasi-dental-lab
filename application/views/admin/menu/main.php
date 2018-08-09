	
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
					url: "<?php echo base_url().'admin/menu/edit_menu/'.$menuid.'';?>",
					data: "ID="+ID,    
					success: function(data)
					{
						$(".modal-content").html(data);
					}
				});	
			});
		});
    </script>





        <div class="content-wrapper">

            <section class="content-header">

                <h1>

                    Menu Setting

                </h1>

                <ol class="breadcrumb">

                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

                    <li class="active">Menu Setting</li>

                </ol>

            </section>



                



				<section class="content">

      <div class="row">

      

        <div class="col-xs-12">

          
		  <form action="<?php echo base_url();?>admin/menu/update_menu/<?php echo $menuid;?>" method="post">
          <div class="box">

            <div class="box-header">

              <h3 class="box-title">Data Menu</h3>

               	<a class="btn btn-info btn-fill pull-right" data-toggle="modal" data-target="#myModal">Tambah Menu Baru</a>
				<button type="submit" class="btn btn-success btn-fill pull-right" style="margin-right:5px">Update</button>
                
            </div>

            

            <div class="box-body">

              <table id="example1" class="table table-bordered table-striped">



                                <thead>

                                    <th>ID</th>

                                    <th>Nama</th>

                                    <th>Tipe</th>

                                    <th>Sort</th>
                                    
                                    <th>Publish</th>

                                    <th>Edit</th>

                                    <th>Delete</th>

                                </thead>

                                <tbody>



                                <?php
									//print_array($this->session->userdata);
									for($a=0 ; $a<count($data_menu) ; $a++)
									{ 
										$ID  = $data_menu[$a]->ID;
										$b=$a+1;
										
										$data_menu_2=$this->master_model->select_in('ms_menu','ID',"WHERE parent_number=$ID");
								
										$count=count($data_menu_2);
                                ?>


                                <tr>
                                    <td><?php echo $b;?></td>
                                    <td>
                                        <a href="<?=base_url();?>admin/menu/sub_menu/<?php echo $menuid.'/'.$ID;?>" class="text-blue">
                                            <?php echo $data_menu[$a]->name_e;?>
                                        </a>
										
                                        <a href="<?php echo base_url();?>admin/menu/sub_menu/<?php echo $menuid.'/'.$ID;?>" class="text-aqua">
                                            [<?php echo $count;?> Sub]
                                        </a>
                              		</td>



                                    <td><?php echo $data_menu[$a]->type;?></td>



                                     <td>



                                     <input type="text" size="1" Name="sort[]" class="form-control" value="<?=$data_menu[$a]->sort;?>">



                                     <input type="hidden" size="1" Name="ID[]" value="<?=$ID;?>">



                                    </td>
                                    
                                    <td>
                                    	<?php
											if($data_menu[$a]->publish==1)
											{
												$publish='<i class="fa fa-check-square-o" aria-hidden="true"></i>';
											}else
											{
												$publish='<i class="fa fa-square-o" aria-hidden="true"></i>';
											}
										?>
                                        <a href="<?php echo base_url();?>admin/menu/publish/<?php echo $menuid.'/'.$ID.'/'.$data_menu[$a]->publish;?>" class="edit text-blue" style="cursor:pointer">
                                            <?php echo $publish;?>
                                        </a>
                                    </td>



                                    <td>

                                        <a alt="<?php echo $ID;?>" class="edit text-green" data-toggle="modal" data-target="#edit-modal" style="cursor:pointer">

                                            <i class="fa fa-edit"></i>

                                        </a>

                                    </td>

                                    <td>

                                        <a href="<?php echo base_url();?>admin/menu/delete_menu/<?php echo $menuid.'/'.$ID;?>" onClick="return confirm('Delete this record?')" class="text-red">

                                            <i class="fa fa-trash-o"></i>

                                        </a>

                                    </td>

                                </tr>

                                <?php } ?>

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

              <h4 class="modal-title">Tambahkan Menu Baru</h4>

            </div>

                <form action="<?php echo base_url();?>admin/menu/insert_menu/<?php echo $menuid;?>" method="post" enctype="multipart/form-data">

                    <div class="modal-body">

                    	<script>

							$(document).ready(function()

							{

								$(".mirror").on("keypress change", function(event)

								{

									var data=$(this).val();

									$(".mirror2").val(data);

								});

							});

						</script>

                        <div class="form-group">

                            <label>Name *</label>

                            <input type="text" name="name" class="form-control mirror" placeholder="Nama Menu" required="required">

                        </div>

                        

                        <div class="form-group">

                            <label>Controller *</label>

                            <input type="text" name="controller" class="form-control mirror2" placeholder="Kontrol Menu" required="required">

                        </div>

                        

                        <div class="form-group">

                            <label>Icon</label>

                            <input type="text" name="icon" class="form-control" placeholder="Icon">

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

          <div class="modal-content" style="z-index:999">

          

            

            

          </div>

      	</div>

   	</div>





			<?php 



				$this->load->view('admin/master/footer');



			?>