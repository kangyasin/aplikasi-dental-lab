    <?php 
        $this->load->view('admin/master/header');
        $menuid = $this->uri->segment(4);
		
		//$data_contact=$this->master_model->select_in('ms_contact', '*', "WHERE ID=1");
		
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
              <h3 class="box-title">Welcome</h3>
              
            </div>
            
            
            
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