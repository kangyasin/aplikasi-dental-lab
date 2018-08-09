

	<?php

        $this->load->view('admin/master/header');

        $menuid = $this->uri->segment(4);
    ?>







        <div class="content-wrapper">

        	<section class="content-header">

                  <h1>

                     Insert Konsumen

                  </h1>

                  <ol class="breadcrumb">

                        <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>

                        <li><a href="<?php echo base_url();?>admin/master/konsumen/<?php echo $menuid;?>">Konsumen</a></li>

                        <li class="active">Insert Konsumen</li>

                  </ol>

            </section>



			<section class="content">

            	<div class="row">



         	<div class="col-md-12">





          <div class="box box-primary">

            <div class="box-header with-border">

              <h3 class="box-title">Insert Konsumen</h3>



              <div class="box-tools pull-right">



              </div>

            </div>



            <form action="<?php echo  base_url();?>admin/master/insert_konsumen/<?php echo $menuid;?>" method="post" enctype="multipart/form-data">

                <div class="box-body no-padding">

                  <div class="mailbox-read-message">









                    <div class="col-md-12">

                        <div class="tab-content" style="padding-top:20px;">

                        	<label>
                            	Nama Konsumen
                            </label>

                            <input type="text" name="nama_konsumen" required class="form-control" placeholder="Nama Konsumen"/>
														<br/>
														<label>
																Email Konsumen
															</label>

															<input type="email" name="email" required value="" class="form-control" placeholder="Email Konsumen"/>

															<br/>
															<label>
																	Telp Konsumen
																</label>

																<input type="text" name="telp" required value="" class="form-control" placeholder="Telp Konsumen"/>


																<br/>
																<label>
																		Alamat Konsumen
																	</label>
																	<textarea name="alamat" required value="" class="form-control"></textarea>





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
