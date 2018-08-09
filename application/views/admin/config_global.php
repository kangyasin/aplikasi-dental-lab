	<?php 
        $this->load->view('admin/master/header_2');
		$modul	   = $this->uri->segment(3);
		$menuid	 = $this->uri->segment(4);
		$info 		=	$this->uri->segment(5);

		
    ?>


	<div class="content-wrapper">
        <section class="content-header">
            <h1>
                Config Global
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">
                	Config Global
                </li>
            </ol>
        </section>
        
        <section class="content">
        
               
               <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Config Global</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
            	<form action="<?php echo base_url();?>admin/master/update_config_global/<?php echo $menuid;?>" method="post" enctype="multipart/form-data">
              		<div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input type="text" name="name" id="nama_promo" class="form-control" placeholder="Company Name" value="<?php echo $dataConfig[0]->name;?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="text" name="phone" id="nama_promo" class="form-control" placeholder="Phone Number" value="<?php echo $dataConfig[0]->phone;?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control" placeholder="Here Your Description"><?php echo $dataConfig[0]->address;?></textarea>
                    </div>
                                          
                
            </div>
            
            <div class="col-md-6">
                        
                <div class="form-group">
                        
                        <div class="form-group">
                            <label>Berita</label>
                            <textarea name="news" class="form-control" placeholder="Here Your Description"><?php echo $dataConfig[0]->news;?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Tampilkan Berita</label>
                            <br />
                            <?php
								$flag = $dataConfig[0]->flag;
								
								if($flag==0)
								{
									echo'
										<input type="radio" name="publish" value="1"> Tampilkan
										<input type="radio" name="publish" value="0" checked> Tidak
									';
								}else
								{
									echo'
										<input type="radio" name="publish" value="1" checked> Tampilkan
										<input type="radio" name="publish" value="0"> Tidak
									';
								}
							?>
                        </div>
              
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <input type="submit" class="btn btn-info btn-fill pull-right" value="Save" id="save">
        </div>
      </div>
               </form>
               
    	</section>
        
  </div>

                                
                                      



    <?php 

        $this->load->view('admin/master/footer_2');

    ?>