

	<?php

        $this->load->view('admin/master/header');

        $menuid = $this->uri->segment(4);
		$ID=$this->uri->segment(5);


    ?>


        <div class="content-wrapper">

        	<section class="content-header">

                  <h1>

                     Edit Pembayaran

                  </h1>

                  <ol class="breadcrumb">

                        <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url();?>admin/master/pembayaran/<?php echo $menuid;?>">Pembayaran</a></li>
                        <li class="active">Edit Pembayaran</li>

                  </ol>

            </section>



			<section class="content">

            	<div class="row">



         	<div class="col-md-12">





          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Edit Pembayaran</h3>



              <div class="box-tools pull-right">



              </div>

            </div>



            <form action="<?php echo  base_url();?>admin/transaction/edit_process_pembayaran/<?php echo $menuid.'/'.$ID;?>" method="post" enctype="multipart/form-data">

                <div class="box-body no-padding">

                  <div class="mailbox-read-message">





                    <div class="col-md-12">

                        <div class="tab-content" style="padding-top:20px;">

													<label>
                            	Supplier
                            </label>

                          <select name="supplier" class="form-control" required>
															<option value="">Pilih Supplier</option>
															<?php

																for($s=0; $s<count($data_supplier); $s++)
																{

																	$IDc = $data_edit[0]->id_supplier;

																	if($data_supplier[$s]->ID == $IDc){
																		$selected = 'selected="selected"';
																	}else{
																		$selected = '';
																	}

																	echo'
																		<option value="'.$data_supplier[$s]->ID.'" '.$selected.'>'.$data_supplier[$s]->nama_perusahaan.'</option>';

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

																			$IDb = $data_edit[0]->id_barang;

																			if($data_barang[$b]->ID == $IDb){
																				$selecteb = 'selected="selected"';
																			}else{
																				$selecteb = '';
																			}

																			echo'
																				<option value="'.$data_barang[$b]->ID.'" '.$selecteb.'>'.$data_barang[$b]->nama_barang.'</option>';

																		}


																	 ?>
															</select>

															<br/>
															<label>
																	Tanggal Pembayaran
																</label>

																<input type="text" class="form-control docs-date" id="datepicker" name="tanggal_pembayaran" data-date-format="yyyy-mm-dd" value="<?=$data_edit[0]->tanggal_pembayaran;?>">

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
