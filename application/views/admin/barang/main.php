

	<?php

        $this->load->view('admin/master/header');

        $menuid = $this->uri->segment(4);


    ?>

        <div class="content-wrapper">

            <section class="content-header">

                <h1>

                    Barang

                </h1>

                <ol class="breadcrumb">

                    <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>

                    <li class="active">Barang</li>

                </ol>

            </section>



	<section class="content">

      <div class="row">



        <div class="col-xs-12">



          <div class="box">

            <div class="box-header">

              <h3 class="box-title">Data Barang</h3>

               	<a href="<?php echo base_url();?>admin/master/addbarang/<?php echo $menuid;?>" class="btn btn-info btn-fill pull-right">Add New Barang</a>




            </div>



            <div class="box-body">

              <table id="example1" class="table table-bordered table-striped">

                    <thead>

                        <th>ID</th>
                        <th>Nama Barang</th>
												<th>Harga Barang</th>
												<th>Stok</th>
                        <th>Edit</th>
                        <th>Delete</th>

                    </thead>

                    <tbody>

                    <?php

                        for($a=0 ; $a<count($data_barang) ; $a++)

                        {

                            $ID  = $data_barang[$a]->ID;

                            $b=$a+1;

                    ?>

                    <tr>

                        <td><?php echo $b;?></td>

                        <td>
                                <?php echo $data_barang[$a]->nama_barang;?>

                        </td>

												<td>
														  <?php echo number_format($data_barang[$a]->harga_barang);?>

												</td>

												<td>
																<?php echo $data_barang[$a]->stok;?>

												</td>



                        <td>

                            <a href="<?php echo base_url();?>admin/master/edit_barang/<?php echo $menuid.'/'.$ID;?>" class="edit text-green" style="cursor:pointer">

                                <i class="fa fa-edit"></i>

                            </a>

                        </td>

                        <td>

                            <a href="<?php echo base_url();?>admin/master/delete_barang/<?php echo $menuid.'/'.$ID;?>" onClick="return confirm('Delete this record?')" class="text-red">

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
