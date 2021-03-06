

	<?php

        $this->load->view('admin/master/header');

        $menuid = $this->uri->segment(4);

				//print_array($this->session->userdata());

    ?>







        <div class="content-wrapper">

        	<section class="content-header">

                  <h1>

                     Insert Penjualan Barang

                  </h1>

                  <ol class="breadcrumb">

                        <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>

                        <li><a href="<?php echo base_url();?>admin/transaction/penjualan/<?php echo $menuid;?>">Penjualan Barang</a></li>

                        <li class="active">Insert Penjualan Barang</li>

                  </ol>

            </section>



			<section class="content">

            	<div class="row">



         	<div class="col-md-12">





          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Insert Penjualan Barang</h3>



              <div class="box-tools pull-right">



              </div>

            </div>



            <form action="<?php echo  base_url();?>admin/transaction/insert_penjualan/<?php echo $menuid;?>" method="post" enctype="multipart/form-data">

                <div class="box-body no-padding">

                  <div class="mailbox-read-message">









                    <div class="col-md-12">

                        <div class="tab-content" style="padding-top:20px;">

                        	<label>
                            	Konsumen
                            </label>

                          <select name="konsumen" class="form-control" required>
															<option value="">Pilih Konsumen</option>
															<?php

																for($s=0; $s<count($data_konsumen); $s++)
																{

																	echo'
																		<option value="'.$data_konsumen[$s]->ID.'">'.$data_konsumen[$s]->nama_konsumen.'</option>';
																}
															 ?>
													</select>
														<br/>
														<label>
																Barang
															</label>

															<select name="barang" class="form-control" required>
																	<option value="">Pilih Barang</option>
																	<?php

																		for($b=0; $b<count($data_barang); $b++)
																		{

																			echo'
																				<option value="'.$data_barang[$b]->ID.'/'.$data_barang[$b]->harga_barang.'">'.$data_barang[$b]->nama_barang.' - '.number_format($data_barang[$b]->harga_barang).'</option>';
																		}


																	 ?>
															</select>


															
															<br/>
															<label>
																	Jumlah Barang
																</label>

																<input type="text" name="qty" class="form-control" required/>

															<br/>
															<label>
																	Tanggal Penjualan
																</label>

																<input type="text" class="form-control docs-date" id="datepicker" name="tanggal" data-date-format="yyyy-mm-dd" value="<?=date('Y-m-d');?>">

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
