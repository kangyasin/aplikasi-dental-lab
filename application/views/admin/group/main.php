
	<?php

		$this->load->view('admin/master/header');

		$menuid = $this ->uri->segment(4);

    ?>

    

    <script>
		$(function() 
		{
			$(".edit").click(function()
			{
			   var ID = $(this).attr('alt');
			   $.ajax({
				    type: "POST",
					url: "<?php echo base_url().'admin/group/edit_group/'.$menuid.'';?>",
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
                Daftar Group
                <small>advanced tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url();?>admin/home/index/8"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Group</li>
            </ol>
        </section>


        <section class="content">
            <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Data Group</h3>
                         <a class="btn btn-info btn-fill pull-right" style="cursor:pointer" data-toggle="modal" data-target="#tambah_group">
                            Tambah Group
                        </a>
                    </div>
        
                    <div class="box-body">  
                        <table id="example1" class="table table-bordered table-striped">

                            <thead>

                            	<th>No.</th>

                                <th>User Group</th>

                                <th>Edit</th>

                                <th>Delete</th>

                            </thead>

                            <?php
							for($a=0 ; $a<count($usergroupmst) ; $a++)
							{ 
								$ID=$usergroupmst[$a]->ID;
								$name=$usergroupmst[$a]->name;
								$b=$a+1;
								
								$data_user=$this->master_model->select_in('user','ID',"WHERE id_group=$ID");
								
								$count=count($data_user);
							?>



                            <tr>

								<td><?php echo $b;?></td>

                                <td>
                                	<a href="<?php echo base_url();?>admin/group/user/<?php echo $menuid.'/'.$ID;?>">
										<?php echo $name; ?>
                                    </a>
                                    
                                    <a href="<?php echo base_url();?>admin/group/user/<?php echo $menuid.'/'.$ID;?>" class="text-aqua">
                                    	[<?php echo $count;?> User]
                                    </a>
                                </td>

                                <td>

                                	<a alt="<?php echo $ID;?>" class="text-green edit" style="cursor:pointer" data-toggle="modal" data-target="#edit-modal">

                                        <i class="fa fa-edit"></i>

                                    </a>

                                </td>

                                <td>

                                	<a href="<?php echo base_url() ;?>admin/group/delete_group/<?php echo $menuid.'/'.$ID;?>" class="text-red">

                                        <i class="fa fa-trash-o"></i>

                                    </a>

                                </td>

                              </tr>

                            <?php } ?>

                        </table>



        	</div>

          

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>

  

  

  

  <div class="modal fade" id="tambah_group" role="dialog">

        <div class="modal-dialog">

          <div class="modal-content" style="z-index:999">

          

            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 class="modal-title">Tambah Group</h4>

            </div>

            	<form id="frm1" action="<?php echo site_url(); ?>admin/group/insert_group_process/<?php echo $menuid;?>" method="post" class="contact">

                <div class="modal-body">                	

                    <script type="text/javascript">
						checked=false;
						function checkedAll (frm1) {var aa= document.getElementById('frm1'); if (checked == false)
						{
							checked = true
						}else{
							checked = false
						}
						for (var i =0; i < aa.elements.length; i++){ aa.elements[i].checked = checked;}
						}
					</script>


                    <label>
                        Nama Group
                    </label>
                    <input type="text" name="name" id="UserGroupName" class="form-control" required="required">

					<br />
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>MENU</th>
                                <th>
                                    <input type='checkbox' name='checkall' onclick='checkedAll(frm1);'>
                                    Ceklist Semua Akses
                                </th>
                            </tr>
                        </thead>

                    	<tbody>
                            <?php 
							  	for($a=0 ; $a<count($data_menu) ; $a++)
								{
									$b=$a+1;
									$ID=$data_menu[$a]->ID;
									$name=$data_menu[$a]->name;
							?>

                                <tr>
                                    <td>
                                        <strong><?php echo $name;?></strong>
                                    </td>
                                    <td>
                                    	<input type="checkbox" name="read_flg[]" value="<?php echo $ID;?>">
                                    </td>
                                </tr>

                          		<?
                               		//panggil child
                                    $menuMstChild = $this->master_model->select_in('ms_menu','ID, name',"WHERE parent_number=$ID AND type = 'B' ORDER BY sort ASC");
                                    for($b=0 ; $b<count($menuMstChild) ; $b++)
									{
										$subMenuID=$menuMstChild[$b]->ID;
										$subMenuName=$menuMstChild[$b]->name;
								?>

                                    <tr>
                                        <td>
                                            <div style="margin-left:20px;">
                                            	<?php echo $subMenuName?>
                                            </div>
                                        </td>
                                        <td>
                                        	<input type="checkbox" name="read_flg[]" value="<?php echo $subMenuID;?>">
                                        </td>
                                    </tr>



                           			<? 	



									} //b



                            	} // a



							?>

                            </tbody>



                        </table>



                </div>

                <div class="modal-footer">

                	<input type="submit" class="btn btn-info btn-fill pull-right" value="Simpan">

                    <button type="button" class="btn btn-default pull-right" style="margin-right:5px;" data-dismiss="modal">Batal</button>

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



<?php $this->load->view('admin/master/footer');?>



			