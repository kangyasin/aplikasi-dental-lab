    <?php 
        $this->load->view('admin/master/header');
        $menuid = $this->uri->segment(4);
		
		$data_contact=$this->master_model->select_in('ms_contact', '*', "WHERE ID=1");
		
    ?>


		<div class="content-wrapper">
        	<section class="content-header">
                  <h1>
                     Contact
                  </h1>
                  <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>admin/home/index/1"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Contact</li>
                  </ol>
            </section>

			<section class="content">
            	<div class="row">
                
         	<div class="col-md-12">
            
            
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Contact</h3>
              
            </div>
            
            <form action="<?php echo  base_url();?>admin/contact/update/<?php echo $menuid;?>" method="post" id="edit-form">
                <div class="box-body no-padding">
                  <div class="mailbox-read-message">
                  
                    <div class="col-md-6">
                        <div class="tab-content" style="padding-top:20px;">
                        	<label>
                            	Address
                            </label>
                            <input type="text" name="address" value="<?php echo $data_contact[0]->address;?>" class="form-control" />
                            <br />
                            <label>
                            	Phone
                            </label>
                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" value="<?php echo $data_contact[0]->phone;?>" />
                        </div>
                    </div>
                    
                    
                    <div class="col-md-6">
                        <div class="tab-content" style="padding-top:20px;">
                        	<label>
                            	Fax
                            </label>
                            <input type="text" name="fax" value="<?php echo $data_contact[0]->fax;?>" class="form-control" />
                            <br />
                            <label>
                            	Email
                            </label>
                            <input type="text" name="email" value="<?php echo $data_contact[0]->email;?>" class="form-control" />
                            
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="tab-content" style="padding-top:20px;">
                            <label>
                            	Location
                            </label>
                            <textarea name="location" id="editor1" class="content-box form-control"><?php echo $data_contact[0]->location;?></textarea>
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

<script>
	(function($) {
		window.addEvent('domready',function() {
			$('.content-box').addEvent('keydown',function(event) {
				if((event.control || event.meta) && event.key == 's') {
					event.stop();
					$('#edit-form').submit();
				}
			});
		});
	})(document.id);
</script>