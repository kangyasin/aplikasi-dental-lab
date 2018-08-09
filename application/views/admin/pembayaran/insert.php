	<?php
        $this->load->view('admin/master/header');
        $menuid = $this->uri->segment(4);
				//print_array($this->session->userdata());
    ?>

		<script>
		$(document).ready(function(e) {

			$("#id_penjualan").change(function(){
				var ID = $(this).val();
				var MENU_ID = <?=$menuid;?>;
				 $.ajax({
					url: "<?php echo base_url().'admin/transaction/getdatapenjualan/'.$menuid?>",
					data: "ID=" + ID + "&MENU_ID=" + MENU_ID,
					success: function(data)
					{
						$(".datainfo").html(data);
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
                     Insert Pembayaran Barang
                  </h1>
                  <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url();?>admin/transaction/pembayaran/<?php echo $menuid;?>">Pembayaran Barang</a></li>
                        <li class="active">Insert Pembayaran Barang</li>
                  </ol>
            </section>

			<section class="content">
            	<div class="row">
         	<div class="col-md-12">
          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Insert Pembayaran Barang</h3>



              <div class="box-tools pull-right">



              </div>

            </div>



            <form action="<?php echo  base_url();?>admin/transaction/insert_pembayaran/<?php echo $menuid;?>" method="post" enctype="multipart/form-data">
                <div class="box-body no-padding">
                  <div class="mailbox-read-message">


										<!-- <?php print_array($data_penjualan);?> -->

                    <div class="col-md-12">

                        <div class="tab-content" style="padding-top:20px;">

                        		<label>
                            	Pilih Item Penjualan
                            </label>

                          <select name="id_penjualan" id="id_penjualan" class="form-control" required>
															<option value="">Pilih Item Penjualan</option>
															<?php

																for($s=0; $s<count($data_penjualan); $s++)
																{

																	echo'
																		<option value="'.$data_penjualan[$s]->ID.'">'.$data_penjualan[$s]->nama_konsumen.' ( '.$data_penjualan[$s]->nama_barang.' - '.$data_penjualan[$s]->qty.' barang )</option>';
																}
															 ?>
													</select>
													<br/>
														<div class="datainfo">
														</div>
													<br/>
													<label>
															Total Bayar
														</label>

														<input type="text" name="bayar" class="form-control" required/>

													<br/>
															<label>
																	Tanggal Pembayaran
																</label>

																<input type="text" class="form-control docs-date" id="datepicker" name="tanggal_pembayaran" data-date-format="yyyy-mm-dd" value="<?=date('Y-m-d');?>">

																<script>
																$(function () {

																$("#datepicker").datepicker({
																autoclose: true,
																todayHighlight: true
																}).datepicker('update');;
																});

																</script>
                        </div>





                    </div>





                  </div>

                </div>

                <div class="box-footer" style="margin-top:20px;">

                  <div class="mailbox-read-message">

                    <button type="submit" class="btn btn-primary pull-right m-top-10" style="margin-top:10px;">Save</button>

                    <div style="clear:both"></div>

                  </div>

                </div>

            </form>



          </div>

          <!-- /. box -->

        </div>

        <!-- /.col -->







            </div>

        </section>

    </div>



















<?php

	$this->load->view('admin/master/footer');

?>
