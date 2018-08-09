<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <?php
  $uri3 = $this->uri->segment(3);

  if($uri3 == 'penjualan'){
    $title = 'Data Penjualan';
  }elseif($uri3 == 'pembayaran'){
    $title = 'Data Pembayaran';
  }elseif($uri3 == 'permintaan'){
    $title = 'Data Permintaan';
  }else{
    $title = 'KisImplant | Admin';
  }
  ?>

  <title><?=$title;?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" type="image/png" href="<?php echo base_url();?>favicon.png">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>appinclude/admin/plugins/select2/select2.min.css">


  	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>


    <style>
		.pagination
		{
			float:right;
			margin-right:-17px;
			margin-top:-36px;
			z-index:9999;
			position:relative;
		}
		.pagination a
		{
			float: left;
			padding: 6px 12px;
			margin-left: -1px;
			line-height: 1.42857143;
			color: #777777;
			text-decoration: none;
			background-color: #fff;
			border: 1px solid #ddd;
		}
		.pagination a.number{
			text-decoration:none
		}
		.pagination a.current
		{
			background:#337AB7;
			color:#FFF !important;
		}
		.pagination a:hover, div.pagination a:active
		{
			color: #23527c;
			text-decoration:none;
			background:#eee;
		}
	</style>

    <?php
		//print_array($this->session->userdata);
		$id_admin=$this->session->userdata('id_admin');
		$username=$this->session->userdata('name_admin');

		$data_admin=$this->master_model->select_in('user','name, since',"WHERE ID=$id_admin");
		$since=$data_admin[0]->since;
	?>
</head>
<body class="hold-transition skin-yellow sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url();?>admin/home/index/8" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">Kis Implant</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Kis Implant</span>
    </a>


    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!--<li>
            <a href="<?php echo base_url();?>admin/master/new_promo/11">
              <i class="fa fa-tags"></i>
              <div style="font-size:10px; position:absolute; margin:-17px 0 0 8px; text-shadow: -1px 0 #3C8DBC, 0 1px #3C8DBC, 1px 0 #3C8DBC, 0 -1px #3C8DBC;">
              	<i class="fa fa-plus"></i>
              </div>
            </a>
          </li>-->




          <!--
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>

          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>-->





          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            	<?php
					$config_global=$this->master_model->select_in('config_global','*',"WHERE ID=1");
				?>
              <!--<img src="<?php echo base_url();?>favicon.png" class="user-image" alt="User Image">-->
              <span class="hidden-xs">Kis Implant</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="<?php echo base_url();?>favicon.png" class="img-circle" alt="User Image">
                <p>
                  Hi, <?php echo $username;?>
				  <?php
				  	$since=strtotime($since);
				  ?>
                  <small>Since <?php echo $since=date('M. Y', $since);?></small>
                </p>
              </li>
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li>-->

              <li class="user-footer">
              	<!--
                <div class="pull-left">
                  <a href="<?php echo base_url();?>admin/group/change_password/5" class="btn btn-default btn-flat">Change Password</a>
                </div>
                -->
                <div class="pull-right">
                  <a href="<?php echo base_url();?>admin/login/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>


        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>favicon.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Kis Implant</p>

          <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $username;?> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>

      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <?php
			$menu = $this->uri->segment(4);
			$menu_member = $this->uri->segment(2);

			/*$sql ="SELECT * FROM menumst where ParentNumber = 0 order by sort ASC";
			$qry = $this->db->query($sql);
			$row = $qry->result();
			$parentMenu = $row;*/

			$data_menu=$this->master_model->select_in('ms_menu','*',"WHERE parent_number=0 AND publish=1 ORDER BY sort ASC");

			$idAdmin = $this->session->userdata('id_admin');
			for($a = 0; $a < count($data_menu); $a++)
			 {
				 $menuID_DB = $data_menu[$a]->ID;
				 $Name_parent_menu = $data_menu[$a]->name_e;
				 $C_Name = $data_menu[$a]->controller;
				 $icon = $data_menu[$a]->icon;

				 $menuChild=$this->master_model->select_in('ms_menu','*',"WHERE parent_number=$menuID_DB AND publish=1 ORDER BY sort ASC");
				 //$menuChild = $this->master_model->getMenuChild($menuID_DB);

				 $numMenu = count($menuChild) ;
				 if($numMenu <> 0)
				 {
					 $class = 'class="treeview"';
					 $link ='';
					 $pull='
					 	<span class="pull-right-container">
						  <i class="fa fa-angle-left pull-right"></i>
						</span>
					 ';
				 }else
				 {
					  $class ='';
					  $link ='href="'.base_url().''.$C_Name.'/'.$menuID_DB.'"';
					  $pull='';
				 }
				 echo '
				  <li '.$class.'>
						<a '.$link.'>
							<i class="'.$icon.'"></i>
							<span>'.$Name_parent_menu.'</span>

							'.$pull.'
						</a>

						';

						if($numMenu == '')
						{
							echo '</li>';
						}else{
							echo'<ul class="treeview-menu">';
								for($b= 0; $b < count($menuChild); $b++)
								{
									 $ChildmenuID_DB = $menuChild[$b]->ID;
									 $NameChildMenu  = $menuChild[$b]->name_e;
									 $C_Name_Child   = $menuChild[$b]->controller;
									 $menuSubChild=$this->master_model->select_in('ms_menu','*',"WHERE parent_number=$ChildmenuID_DB ORDER BY sort ASC");
									 //$menuSubChild = $this->master_model->getSubMenuChild($ChildmenuID_DB);
									 $numSubMenu = count($menuSubChild) ;
									 if($numSubMenu <> 0){
										 $subClass = 'class="has-sub"';
										 $subLink ='';
									 }else{
										  $subClass ='';
										  $subLink ='href="'.base_url().''.$C_Name_Child.'/'.$ChildmenuID_DB.'"';
									 }
									$checkMenuAccess   = $this->master_model->checkMenuAccess($ChildmenuID_DB, $idAdmin);
									if($checkMenuAccess == true)
									{

									 echo '
									 <li '.$subClass.'>
										 <a '.$subLink.'>
										 	<i class="fa fa-circle-o"></i> '.$NameChildMenu.'
											';
											if($menuID_DB==28)
											 {
												 echo'
													<span class="pull-right-container">
														';
															$data_settlement=$this->master_model->select_in('ts_nota','*',"WHERE id_settlement=0");

															$count_nota=count($data_settlement);
														echo'
													  <small class="label pull-right bg-red">'.$count_nota.'</small>
													</span>
												 ';
											 }
											 echo'

										 </a>';
										 if($numSubMenu == '')
										 {
											 echo '</li>';
										 }else{
											echo'
											<ul>';
											for($c= 0; $c < count($menuSubChild); $c++)
											{
												 $subMenuID_DB = $menuSubChild[$c]->ID;
												 $NameSubMenu  = $menuSubChild[$c]->name;
												 $C_Name_Sub   = $menuSubChild[$c]->controller;
												 $menuSubSubChild=$this->master_model->select_in('ms_menu','*',"WHERE parent_number=$subMenuID_DB AND menu_level=4 ORDER BY sort ASC");
												 //$menuSubSubChild = $this->master_model->getSubSubMenuChild($subMenuID_DB);
												 $numSubSubMenu = count($menuSubSubChild) ;
												 if($numSubSubMenu <> 0){
													 $subSubClass = 'class="has-sub"';
													 $subSubLink ='';
												 }else
												 {
													  $subSubClass ='';
													  $subSubLink ='href="'.base_url().''.$C_Name_Sub.'/'.$subMenuID_DB.'"';
												 }
												 echo'
													<li '.$subSubClass.'>
														<a '.$subSubLink.'>'.$NameSubMenu.'</a>';
														 if($numSubSubMenu == '')
														 {
															 echo '</li>';
														 }else{
															echo'<ul>';
														for($d= 0; $d < count($menuSubSubChild); $d++)
														{
															 $subSubMenuID_DB = $menuSubSubChild[$d]->ID;
															 $NameSubSubMenu  = $menuSubSubChild[$d]->name;
															 $C_Name_Sub_sub   = $menuSubSubChild[$d]->controller;
															 echo'
																<li>
																	<a href="'.base_url().''.$C_Name_Sub_sub.'/'.$subSubMenuID_DB.'">
																		 '.$NameSubSubMenu.'
																	</a>
																 </li> ';
														}
														echo'</ul>
													 </li>';
												}
											}
										echo'</ul>
									 </li>';
										 }
								 }
							}
						echo'</ul>
					</li>';
					}
				}
            ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
