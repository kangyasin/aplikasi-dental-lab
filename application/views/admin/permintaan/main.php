

	<?php

        $this->load->view('admin/master/header');

        $menuid = $this->uri->segment(4);
				$today = date('Y-m-d');
$startdate = date( "Y-m-d", strtotime( "$today -1 month" ) );

    ?>

		<style>

        .control-group {

          display: inline-block;

          vertical-align: top;

          background: #fff;

          text-align: left;

          box-shadow: 0 1px 2px rgba(0,0,0,0.1);

          padding: 30px;

          width: 200px;

          height: 210px;

          margin: 10px;

        }

        .control {

          display: block;

          position: relative;

          padding-left: 30px;

          margin-bottom: 15px;

          cursor: pointer;

          font-size: 18px;

        }

        .control input {

          position: absolute;

          z-index: -1;

          opacity: 0;

        }

        .control__indicator {

          position: absolute;

          top: 2px;

          left: 0;

          height: 20px;

          width: 20px;

          background: #e6e6e6;

        }

        .control--radio .control__indicator {

          border-radius: 50%;

        }

        .control:hover input ~ .control__indicator,

        .control input:focus ~ .control__indicator {

          background: #ccc;

        }

        .control input:checked ~ .control__indicator {

          background: #2aa1c0;

        }

        .control:hover input:not([disabled]):checked ~ .control__indicator,

        .control input:checked:focus ~ .control__indicator {

          background: #0e647d;

        }

        .control input:disabled ~ .control__indicator {

          background: #e6e6e6;

          opacity: 0.6;

          pointer-events: none;

        }

        .control__indicator:after {

          content: '';

          position: absolute;

          display: none;

        }

        .control input:checked ~ .control__indicator:after {

          display: block;

        }

        .control--checkbox .control__indicator:after {
          left: 8px;
          top: 4px;
          width: 3px;
          height: 8px;
          border: solid #fff;
          border-width: 0 2px 2px 0;
          transform: rotate(45deg);
        }

        .control--checkbox input:disabled ~ .control__indicator:after {

          border-color: #7b7b7b;

        }

        .control--radio .control__indicator:after {
          left: 7px;
          top: 7px;
          height: 6px;
          width: 6px;
          border-radius: 50%;
          background: #fff;
        }

        .control--radio input:disabled ~ .control__indicator:after {

          background: #7b7b7b;

        }
		.form-group{
			padding:5px;
		}
		#listhistory {

			max-height: 400px;
			overflow: auto;

		}

		#listmainlist {
			width:100%;
			max-height: 100%;
			overflow: auto;

		}

		</style>

		<script>
		$(document).ready(function(e) {

			$(".edit").click(function(){
				var ID = $(this).attr('alt');
				var MENU_ID = <?=$menuid;?>;
				 $.ajax({
					url: "<?php echo base_url().'admin/transaction/changestatus_permintaan/'.$menuid?>",
					data: "ID=" + ID + "&MENU_ID=" + MENU_ID,
					success: function(data)
					{
						$(".content-popup").html(data);
					}
				});

				/*alert ('yrdy');
				return false;*/
			});

				});
		</script>

        <div class="content-wrapper">

            <section class="content-header">

                <h1>

                    Permintaan

                </h1>

                <ol class="breadcrumb">

                    <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>

                    <li class="active">Permintaan</li>

                </ol>

            </section>



	<section class="content">

      <div class="row">
								<!-- <div class="col-md-12 text-center">
										<div class="card" style="padding:20px 0">
											<div class="box">

						            <div class="box-header">
												<h4>SEARCH</h4>
												<hr/>
												<form action="<?php echo base_url();?>admin/transaction/permintaan/<?=$menuid;?>" class="form-inline" method="post">

													<div class="form-group">
														<label for="exampleInputName2">Supplier</label><br/>
														<input type="text" name="supplier" class="form-control" id="supplier" placeholder="Nama Supplier">
													</div>
													<div class="form-group">
														<label for="exampleInputName2">Barang</label><br/>
														<input type="text" name="barang" class="form-control" id="barang" placeholder="Nama Barang">
													</div>
													<div class="form-group">
															<label for="exampleInputEmail2">Start</label><br/>
															<input type="text" class="form-control docs-date" id="datepicker" name="start" data-date-format="yyyy-mm-dd" value="<?=$startdate;?>">

															<script>
															$(function () {

															$("#datepicker").datepicker({
															autoclose: true,
													todayHighlight: true
															}).datepicker('update');;
															});

															</script>
													</div>
													<div class="form-group">
															<label for="exampleInputEmail2">End</label><br/>
															<input type="text" class="form-control" id="datepickers" name="end" data-date-format="yyyy-mm-dd" value="<?=date('Y-m-d');?>">

															<script>
															$(function () {

															$("#datepickers").datepicker({
															autoclose: true,
															todayHighlight: true
															}).datepicker('update', new Date());;
															});

															</script>
													</div>
													<div class="form-group">
														<label for="exampleInputName2">Status</label><br/>
															<select name="status" class="form-control" id="status">
															<?php
																echo '
																<option value="">All</option>
																<option value="0">Belum Terima</option>
																<option value="1">Sudah Terima</option>';

																?>

															</select>
													</div>

													<div class="form-group">
													&nbsp; <br/>
													<button type="submit" class="btn btn-warning btn-fill">Search</button>
													<div  name="export" id="exports" class="export btn btn-default btn-fill"> Exports</div>
													</div>
												</form>
											</div>
										</div>
										</div>
									</div> -->


        <div class="col-xs-12">



          <div class="box">

            <div class="box-header">

              <h3 class="box-title">Data Permintaan</h3>

               	<a href="<?php echo base_url();?>admin/transaction/addpermintaan/<?php echo $menuid;?>" class="btn btn-info btn-fill pull-right">Add New Permintaan</a>




            </div>



            <div class="box-body">

              <table id="example1" class="table table-bordered table-striped">

                    <thead>

                        <th>ID</th>
                        <th>Supplier</th>
												<th>Barang</th>
												<th>Qty</th>
												<th>Tanggal Permintaan</th>
												<th>Tanggal Terima</th>
												<th>Status</th>
                        <th>Petugas</th>
												<th>Edit</th>
												<th>Delete</th>

                    </thead>

                    <tbody>

                    <?php

                        for($a=0 ; $a<count($data_permintaan) ; $a++)

                        {

                            $ID  = $data_permintaan[$a]->ID;
														$status = $data_permintaan[$a]->status;


														if($status == 0){
															$terima = '-';
															$status = '<a alt="'.$ID.'" class="edit" data-toggle="modal" data-target="#modal_edit" style="cursor:pointer">Belum Terima</a>';
														}else{

															$terima = $data_permintaan[$a]->tanggal_terima;
															$status = 'Sudah Terima';

														}
                            $b=$a+1;

                    ?>

                    <tr>

                        <td><?php echo $b;?></td>

                        <td>
                                <?php echo $data_permintaan[$a]->nama_perusahaan;?>

                        </td>

												<td>
														  <?php echo $data_permintaan[$a]->nama_barang;?>

												</td>

												<td>
																<?php echo $data_permintaan[$a]->qty;?>

												</td>

												<td>
                                <?php echo $data_permintaan[$a]->tanggal_permintaan;?>

                        </td>

												<td>
                                <?php echo $terima;?>

                        </td>

												<td>
                                <?=$status;?>

                        </td>

												<td>
                                <?php echo $data_permintaan[$a]->admin;?>

                        </td>



                        <td>

                            <a href="<?php echo base_url();?>admin/transaction/edit_permintaan/<?php echo $menuid.'/'.$ID;?>" class="edit text-green" style="cursor:pointer">

                                <i class="fa fa-edit"></i>

                            </a>

                        </td>

                        <td>

                            <a href="<?php echo base_url();?>admin/transaction/delete_permintaan/<?php echo $menuid.'/'.$ID;?>" onClick="return confirm('Delete this record?')" class="text-red">

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

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>



			<?php

				$this->load->view('admin/master/footer');

			?>
