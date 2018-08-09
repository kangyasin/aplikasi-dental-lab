    <?php 
        $this->load->view('admin/master/header');
        $menuid = $this->uri->segment(4);
		$id_parent = $this->uri->segment(5);
		
		$id_consultation=$data_consultation[0]->ID;
														
		$qa=$data_consultation[0]->QA;
		
		$qa=strip_tags($qa);
		
		$date=strtotime($data_consultation[0]->dt_submit);
									
		$id_status=$data_consultation[0]->id_status;
		$id_type=$data_consultation[0]->id_type;
		$id_priority=$data_consultation[0]->id_priority;
		
		if($id_type==1)
		{
			$type='TAX';
		}elseif($id_type==2)
		{
			$type='ACCOUNTING';
		}elseif($id_type==3)
		{
			$type='MERGER';
		}elseif($id_type==4)
		{
			$type='FINANCE';
		}elseif($id_type==5)
		{
			$type='BUSINESS';
		}
		
		if($id_priority==1)
		{
			$priority='<span class="text-green">Normal</span>';
		}elseif($id_priority==2)
		{
			$priority='<span class="text-danger">Urgent</span>';
		}
		
		if($id_status==0)
		{
			$status='<span class="text-orange">Unasign</span>';
		}elseif($id_status==1)
		{
			$status='<span class="text-green">Open</span>';
		}elseif($id_status==2)
		{
			$status='<span class="text-gray">Pending</span>';
		}elseif($id_status==3)
		{
			$status='<span class="text-blue">Close</span>';
		}
		
		$id_customer=$data_consultation[0]->id_customer;
		$data_customer=$this->master_model->select_in('ms_customer','name',"WHERE ID=$id_customer");
    ?>


		<div class="content-wrapper">
        	<section class="content-header">
                  <h1>
                        Open Consultation
                  </h1>
                  <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Open Consultation</li>
                  </ol>
            </section>

			<section class="content">
            	<div class="row">
                
                	
                    <div class="col-md-3">
                    
                          <div class="box box-solid">
                            <div class="box-header with-border">
                              <h3 class="box-title">Assigne*</h3>
                
                              <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            <div class="box-body">
                            	<select class="form-control">
                                	<option selected="selected">
                                    	Tax
                                    </option>
                                    <option>
                                    	Business
                                    </option>
                               		<option>
                                    	Support
                                    </option>
                                </select>
                                <br />
                                <span class="box-title">CCs</span>
                                <input type="text" class="form-control" />
                            </div>
                            <!-- /.box-body -->
                          </div>
                          
                        
                          
                          <!-- /. box -->
                          <div class="box box-solid">
                            <div class="box-header with-border">
                              <h3 class="box-title">Action</h3>
                
                              <div class="box-tools">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                              </div>
                            </div>
                            <div class="box-body ">
                              	<div class="col-md-6 no-padding">
                                	<span class="box-title">Type</span>
                                	<select class="form-control">
                                    	<option selected="selected">
                                            Tax
                                        </option>
                                        <option>
                                            Incident
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 no-padding">
                                	<span class="box-title">Priority</span>
                                	<select class="form-control">
                                        <option>
                                            Normal
                                        </option>
                                    </select>
                                </div>
                                <div style="clear:both"></div>
                                <br />
                                <span class="box-title" style="margin-top:10px;">Linked Problem</span>
                                <input type="text" class="form-control" />
                                
                                <br />
                                <span class="box-title" style="margin-top:10px;">Tags</span>
                                <input type="text" class="form-control" />
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                        </div>
                        <!-- /.col -->
                
                
                    <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>

              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><strong><?php echo $type;?> :</strong> <?php echo $qa;?></h3>
                <h5>From: <strong><?php echo $data_customer[0]->name;?></strong>
                  <span class="mailbox-read-time pull-right"><?php echo date('d M Y H:i', $date);?></span></h5>
              </div>
              <!-- /.mailbox-read-info -->
              
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
              	<div class="col-md-1">
                	<img src="<?php echo base_url();?>assets/images/user.png" width="40" style="border-radius:50%" />
                </div>
              	<div class="col-md-11">
                	<ul id="myTabs" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#claim" aria-controls="claim" role="tab" data-toggle="tab">
                                Public Reply
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                                Internal Note
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" style="padding-top:20px;">
                        <div role="tabpanel" class="tab-pane active" id="claim">
                            <textarea id="editor1"></textarea>
                            
                            <button type="submit" class="btn btn-primary pull-right m-top-10" style="margin-top:10px;">Send</button>
                        </div>
                        
                        <div role="tabpanel" class="tab-pane" id="profile">
                            <textarea id="editor2"></textarea>
                        </div>
                        
                        
                    </div>
                    
                	
                </div>
                <div style="clear:both"></div>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            
            <div class="box-footer" style="border-top:none">
              <div class="mailbox-read-message">
              	<div class="col-md-1">
                </div>
                <?php
					$data_consultation_2=$this->master_model->select_in('ts_consultation','*',"WHERE id_parent=$id_parent ORDER BY dt_submit DESC");
				?>
                <div class="col-md-11">
                	<h4>Conversation (<?php echo count($data_consultation_2);?>)</h4>
                </div>
              </div>
           	</div>
            
            
            <?php
				
				
				for($a=0; $a < count($data_consultation_2); $a++)
				{
					$qa2=$data_consultation_2[$a]->QA;
					$id_admin=$data_consultation_2[$a]->id_admin;
					$id_customer=$data_consultation_2[$a]->id_customer;
					
					$date_2=strtotime($data_consultation_2[$a]->dt_submit);
					
					if($id_admin==0)
					{
						$data_customer=$this->master_model->select_in('ms_customer','name, image',"WHERE ID=$id_customer");
						$name=$data_customer[0]->name;
						$image='uploads/customer/'.$data_customer[0]->image;
					}else
					{
						$data_admin=$this->master_model->select_in('user','name',"WHERE ID=$id_admin");
						$name=$data_admin[0]->name;
						
						$image='assets/images/user.png';
					}
					echo'
						<div class="box-footer">
						  <div class="mailbox-read-message">
							<div class="col-md-1">
								<img src="'.base_url().''.$image.'" width="40" style="border-radius:50%" />
							</div>
							<div class="col-md-11">
								<strong>'.$name.' </strong>
								<font class="pull-right">
									'.date('d M Y H:i', $date_2).'
								</font>
								<br />
								'.$qa2.'
							</div>
							<div style="clear:both"></div>
						  </div>
						</div>
			
					';
				}
			?>
            
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
        
        
        
           		</div>
			</section>
    </div>

















<?php $this->load->view('admin/master/footer'); ?>