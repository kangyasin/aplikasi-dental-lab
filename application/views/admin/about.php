    <?php 
        $this->load->view('admin/master/header');
        $menuid = $this->uri->segment(4);
		
		$data_about=$this->master_model->mst_data('about');
		
    ?>


		<div class="content-wrapper">
        	<section class="content-header">
                  <h1>
                     About
                  </h1>
                  <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">About</li>
                  </ol>
            </section>

			<section class="content">
            	<div class="row">
                
         	<div class="col-md-12">
            
            
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $data_about[0]->name;?></h3>
              
            </div>
            
            <form action="<?php echo  base_url();?>admin/master/update_about/<?php echo $menuid;?>" method="post">
                <div class="box-body no-padding">
                  <div class="mailbox-read-message">
                  
                    <div class="col-md-6">
                        <div class="tab-content" style="padding-top:20px;">
                        	<label>
                            	Indonesia Title
                            </label>
                            <input type="text" name="name" value="<?php echo $data_about[0]->name;?>" class="form-control" />
                            <br />
                            <label>
                            	Indonesia Description
                            </label>
                            <textarea name="desc" id="editor1"><?php echo $data_about[0]->note;?></textarea>
                            
                        </div>
                    </div>
                    
                    
                    <div class="col-md-6">
                        <div class="tab-content" style="padding-top:20px;">
                        	<label>
                            	English Title
                            </label>
                            <input type="text" name="name_e" value="<?php echo $data_about[0]->name_e;?>" class="form-control" />
                            <br />
                            <label>
                            	English Description
                            </label>
                            <textarea name="desc_e" id="editor2"><?php echo $data_about[0]->note_e;?></textarea>
                            
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                    	<div class="tab-content" style="padding-top:20px">
                        	<label>
                            	Link Video From Youtube
                            </label>
                            <input type="text" name="video" class="form-control" placeholder="Url Youtube" value="<?php echo $data_about[0]->video;?>" />
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


<?php $this->load->view('admin/master/footer'); ?>