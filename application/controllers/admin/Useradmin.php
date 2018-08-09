<?php ob_start(); if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class useradmin extends CI_Controller {

	



	public function __construct(){

		parent::__construct();
		$this->load->model('admin/master_model');

		$this->load->library('upload');
	}



	



	



	function index($err='', $username ='')

	{		

		$data['err']=$err;

		$data['username']=$username;



		$this->load->view('admin/login', $data);

	}



	







	function doLogin()

	{

		$username = $this->input->post('username'); 

		$pass     = $this->input->post('pass');

		$password = md5(sha1($pass));

		$chechLogin = $this->master_model->getValidUserData($username, $password);



		if($chechLogin == false)

		{

			redirect('admin/useradmin/index/error/'.$username);

		}else{



			$usergroup = $chechLogin[0]->UserGroupID;

			$id_admin = $chechLogin[0]->UserID;

			$UserName = $chechLogin[0]->UserName;

			



			$newdata = array(

				   'username'   => $UserName,

				   'password'   => $password,

				   'usergroup'  => $usergroup,

				   'id_admin'  => $id_admin,

				   'UserID'  => $id_admin,

				   'logged_in'  => TRUE

			);



			$this->session->set_userdata($newdata);

			redirect('admin/home/index/8');



		}



	}





	function logout()

	{

		$this->session->sess_destroy();

    	redirect(base_url().'');



	}



	







	public function createUser($menuid)

	{

		$data['user']		    = $this->master_model->masterQuery('a.*, b.*', 'usermst a LEFT JOIN usergroupmst b ON a.`UserGroupID`=b.`UserGroupID`', 'Where a.UserGroupID <> 1', 'order by a.UserID ASC');



		$data['DataUserGroup']   = $this->admin_group_model->DataUserGroup();

		$idAdmin = $this->session->userdata('id_admin');

		$checkMenuAccess   = $this->master_model->checkMenuAccess($menuid, $idAdmin);

		if($checkMenuAccess == false)

		{

			$this->load->view('admin/notAccessiblePage');

		}else{

		  $this->load->view('admin/user/create-user',$data);

		}

	}



	



	public function menusetting($menuid)



	{



		//$idUser = $this->session->userdata('id_admin');



		//if($idUser == '')



		//{



			//redirect(base_url());



		//}



		



		//$data['err'] 		     = '';



		$data['DataView'] = $this->admin_menu_model->DataView();



		



		$idAdmin = $this->session->userdata('id_admin');



		$checkMenuAccess   = $this->master_model->checkMenuAccess($menuid, $idAdmin);



		if($checkMenuAccess == false)



		{

			$this->load->view('admin/notAccessiblePage');

		}else

		{

		  $this->load->view('admin/user/menusetting', $data);

		}

		//$data['sukses'] 		= $errvalid;

		//$this->load->view('admin/user/menusetting',$data);

	}



	



	public function submenusetting($menuID, $parentID)



	{



		#code for registration



		$idAdmin = $this->session->userdata('id_admin');



		$checkMenuAccess   = $this->master_model->checkMenuAccess($menuID, $idAdmin);



		



		if($checkMenuAccess == false)



		{



			$this->load->view('admin/notAccessiblePage');



		}else{



			$idUser = $this->session->userdata('id_admin');



			if($idUser == '')



			{



				redirect(base_url());



			}



			



			$data['err'] 		     = '';



			$data['DataView'] = $this->admin_menu_model->DataSub($parentID);



			//$data['sukses'] 		= $errvalid;



			



			$this->load->view('admin/user/submenusetting',$data);



		}



	}



	



	public function subsubmenusetting($menuID, $MenuSubID, $id_menu)



	{



		#code for registration



		$idAdmin = $this->session->userdata('id_admin');



		$checkMenuAccess   = $this->master_model->checkMenuAccess($menuID, $idAdmin);



		



		if($checkMenuAccess == false)



		{



			$this->load->view('admin/notAccessiblePage');



		}else{



			$idUser = $this->session->userdata('id_admin');



			if($idUser == '')



			{



				redirect(base_url());



			}



			



			$data['err'] 		     = '';



			$data['DataView'] = $this->admin_menu_model->DataSubSub($id_menu,$MenuSubID);



			//$data['sukses'] 		= $errvalid;



			



			$this->load->view('admin/user/subsubmenusetting',$data);



		}



	}



	



	public function subsubsubmenusetting($menuID, $ParentNumber, $id_menu, $id_sub_menu)



	{



		#code for registration



		$idAdmin = $this->session->userdata('id_admin');



		$checkMenuAccess   = $this->master_model->checkMenuAccess($menuID, $idAdmin);



		



		if($checkMenuAccess == false)



		{



			$this->load->view('admin/notAccessiblePage');



		}else{



			$idUser = $this->session->userdata('id_admin');



			if($idUser == '')



			{



				redirect(base_url());



			}



			



			$data['err'] 		     = '';



			$data['DataView'] = $this->admin_menu_model->DataSubSubsub($id_sub_menu);



			//$data['sukses'] 		= $errvalid;



			



			$this->load->view('admin/user/subsubsubmenusetting',$data);



		}



	}



	public function createNewUser($MENU_ID)

	{

			$UserPwd        = $this->input->post('UserPwd');

			$UserPwdConfirm = $this->input->post('UserPwdConfirm');

			if($UserPwd != $UserPwdConfirm)

			{

				$confirmText = "wrong confirmation password";



			}else{

				$data = array(

						'UserName'     => $this->input->post('name'),

						'UserPwd'      => md5(sha1($this->input->post('password'))),

						'UserGroupID'  => $this->input->post('usergroup')

					);



				$this->db->insert('usermst', $data);

				$confirmText = "new user added";



			}

			redirect('admin/useradmin/createUser/'.$MENU_ID.'/'.$confirmText);

	}







	public function editUser($menuid, $err='')

	{

		$UserID   = $this->input->get('UserID');

		$dataEdit = $this->admin_menu_model->DataEditUser($UserID);

		$ugiD     = $dataEdit[0]['UserGroupID'];

		echo '

		<div class="modal-header">

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<h4 class="modal-title">Edit User</h4>

		</div>

		<div class="modal-body">

			

			<form action="'.base_url().'admin/useradmin/prosses_editUser/'.$menuid.'" method="post" name="createUser" class="contact">



				<input type="hidden" name="UserID" value="'.$dataEdit[0]['UserID'].'"/>

				

				<div class="form-group">

					<label>Nama User</label>

					<input type="text" name="name" id="name" class="form-control" value="'.$dataEdit[0]['UserName'].'">

				</div>

				

				<div class="form-group">

					<label>Password</label>

					<input type="password" name="password" id="password" class="form-control" required="required">

				</div>



				<div class="form-group">

					<label> Type </label>

					<select name="UserGroupID" id="UserGroupID" required class="form-control">

						'; 

							$DataUserGroup = $this->admin_group_model->DataUserGroup();

		

							for($a=0; $a < count($DataUserGroup); $a++)

							{

								$UserGroupID   = $DataUserGroup[$a]['UserGroupID'];

								$UserGroupName = $DataUserGroup[$a]['UserGroupName'];

		

								if($ugiD == $UserGroupID)

								{

									$selected='selected="selected"';

								}else{

									$selected='';

								}

								echo ' <option value="'.$UserGroupID.'" '.$selected.'>'.$UserGroupName.'</option>';

		

							}

		

						echo'

					</select>

				</div>

        	</form>

			

		</div>

		<div class="modal-footer">

			<input type="submit" class="btn btn-info btn-fill pull-right" value="Simpan" id="save">

			<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right:5px;">Tutup</button>

		</div>

		';

	}



	



	public function prosses_editUser($menuid)

	{

		$UserName	= trim($this->input->post('UserName'));

		$UserPwd	= trim($this->input->post('password'));

		$UserGroupID	= $this->input->post('UserGroupID');

		$UserID     = $this->input->post('UserID');



		$CurPass   = $this->uri->segment(5);



		if ($UserPwd=='')

		{

			$ins = array

			(

				'UserName'   => $UserName,

				'UserGroupID'=>$UserGroupID

			);

		}else

		{

			$ins = array

			(

				'UserName'   => $UserName,

				'UserPwd'   => md5(sha1($UserPwd)),

				'UserGroupID'=>$UserGroupID

			);

		}



		$this->db->where('UserID', $UserID);

		$this->db->update('usermst', $ins);

		redirect('admin/useradmin/createUser/'.$menuid.'/sukses');

	}



	



	



	public function editNameUser($id_user)



	{



			$nama= $this->input->post('namauser');



			



			



			    $getId      = $this->master_model->masterQuery('id', 'user',"where password = '$CurPass'", '');



				$id = $getId [0]->id;



				



				$ins = array(



							'username'   => $nama,



							);



			



				$this->db->where('id', $id_user);



				$this->db->update('user', $ins);



				



				redirect('admin/useradmin/user_akses_menu/'.$id_user);



			



		



	}



	



	public function deleteUser($MenuID, $UserID)



	{



		



		$this->db->where('UserID', $UserID);



		$this->db->delete('usermst');



		



	  	redirect('admin/useradmin/createUser/'.$MenuID, $UserID);	



	}



	



	public function deleteUserGroup($MenuID, $UserGroupID)



	{



		



		$this->db->where('UserGroupID', $UserGroupID);



		$this->db->delete('usergroupmst');



		



		$this->db->where('UserGroupID', $UserGroupID);



		$this->db->delete('usergroupdtlmst');



		



		$this->db->where('UserGroupID', $UserGroupID);



		$this->db->delete('usermst');



		



	  	redirect('admin/useradmin/usergroup/'.$MenuID, $UserGroupID);	



	}



	



	/*



	public function usergroup($manuID)



	{



		#code for registration



		$idUser = $this->session->userdata('id_admin');



		$checkMenuAccess   = $this->mst_mod->checkMenuAccess($manuID, $idUser);



		



		if($checkMenuAccess == false)



		{



			$this->load->view('admin/notAccessiblePage');



		}else{



			if($idUser == '')



			{



				redirect(base_url());



			}



			



			$data['err'] 		= '';



			$data['user']	   = $this->mst_mod->masterQuery('*', 'user', '', 'order by id ASC');



			$this->load->view('admin/user/usergroup',$data);



		}



	}



	*/



	



	public function user_akses_menu($id_user)



	{



		#code for registration



		$idAdmin = $this->session->userdata('id_admin');



		if($idAdmin == '')



		{



			redirect(base_url());



		}



		



		//print_array($this->session->userdata);



		



		$data['dataMenu']   = $this->master_model->getUserMenu($id_user);



		$data['user']	   = $this->master_model->masterQuery('*', 'user', '', 'order by id ASC');



		//$data['sukses'] 		= $errvalid;



		



		$this->load->view('admin/user/editUserMenu',$data);



	}



	



	public function changeAkses($id, $active, $id_user)



	{



		$active = $active == 0 ? 1 : 0;



		



		$this->db->where('id',$id);



		$this->db->set('akses',$active);



		$this->db->update('usermenu');



		



		redirect('admin/useradmin/user_akses_menu/'.$id_user);



	



	}



	



	//=====================================================================Main Menu Function ============================================



	function insert()



	{		



		



	 	$MenuID = $this->admin_menu_model->GetLastMenuID(); // untuk dapetin menu ID yang terakhir



		



		$MENU_ID = $this->input->post('MENU_ID');  // untuk redirect dari input type hidden



		



		$Parent = $this->input->post('MenuType');



		



		if ($Parent == 'F')



		{



			$ParentNumber = 'f';



		}else{



			$ParentNumber = $this->input->post('ParentNumber');		



		}



		



		$data = array



		(



			'MenuID'    	  => $MenuID,



			'MenuName'  		=> $this->input->post('MenuName'),



			'ParentNumber' 	=> $ParentNumber,



			'menu_level' 	  => $this->input->post('menu_level'),



			'cMenuName' 	   => $this->input->post('cMenuName'),



			'MenuType'  	    => $this->input->post('MenuType'),



			'sort'			=> $MenuID



		);



		



		$this->db->insert('menumst', $data);



		



		$dataUserGroupMaster=$this->admin_menu_model->SelectIn('usergroupmst','*',"");



		



		for($a=0; $a < count($dataUserGroupMaster); $a++)



		{



			$userGroupID=$dataUserGroupMaster[$a]['UserGroupID'];



			$data2 = array



			(



				'MenuID'    	  => $MenuID,



				'UserGroupID'  	 => $userGroupID,



				'ReadFlg' 		 => 0,



				'ModifyFlg' 	   => 0



			);



			



			$this->db->insert('usergroupdtlmst', $data2);



		}



		



		



		//$this->admin_menu_model->InsertUserGroupDetail($MenuID); // insert table  usergroupdtlmst where MenuID=$MenuID



		



		



		$this->admin_menu_model->SetCheckedAdmin($MenuID);



		



		//$this->admin_menu_model->InsertConfigModul($MenuID); // insert table  usergroupdtlmst where MenuID=$MenuID



		



		redirect('admin/useradmin/menusetting/'.$MENU_ID);



		/**/



		



	}



	



	function delete($MENU_ID,$MenuID)



	{	



		//delete table  menumst where MenuID=$MenuID



		$this->db->where('MenuID', $MenuID);



		$this->db->delete('menumst');



		



		// delete table  usergroupdtlmst where MenuID=$MenuID



		$this->db->where('MenuID', $MenuID);



		$this->db->delete('usergroupdtlmst');



		



		// delete table  usergroupdtlmst where MenuID=$MenuID



		//$this->db->where('MenuID', $MenuID);



		//$this->db->delete('config_module');



		



		redirect('admin/useradmin/menusetting/'.$MENU_ID);



	}



	



	



	function delete_sub($MENU_ID,$parentID, $menuID_db)



	{	



		//delete table  menumst where MenuID=$MenuID



		$this->db->where('MenuID', $menuID_db);



		$this->db->delete('menumst');



		



		// delete table  usergroupdtlmst where MenuID=$MenuID



		$this->db->where('MenuID', $menuID_db);



		$this->db->delete('usergroupdtlmst');



		



		// delete table  usergroupdtlmst where MenuID=$MenuID



		//$this->db->where('MenuID', $MenuID);



		//$this->db->delete('config_module');



		



		redirect('admin/useradmin/submenusetting/'.$MENU_ID.'/'.$parentID);



	}



	



	function edit_menu($MenuID)



	{



		/*



		$data['DataEdit']         = $this->admin_product_model->dataeditcategory($ID);



		



		$data['DataCategory']	 = $this->admin_product_model->DataCategory();		



		$this->load->view('admin/admin_category', $data);



		*/



		$MenuID = $this->input->get('MenuID');



		$dataEdit= $this->admin_menu_model->DataEditMenu($MenuID);



		echo '



		



		 <script>



				$(function() {



					$(".submit-green").click(function(){



					   $("#editkategori").slideUp(1000);						  



					});



				});



		 </script>



		<form action="'.base_url().'admin/useradmin/edit_process/'.$MenuID.'" method="post" class="contact" enctype="multipart/form-data" >



                     <input type="hidden" name="MenuID" value="'.$dataEdit[0]['MenuID'].'"/>



						<div class="action-top">



                            <div class="left">



                               Edit Menu



                            </div>



                            <div class="right">



                                <a class="submit-green">



                                    <i class="fa fa-times"></i> Cancel



                                </a>



                                <button type="submit" class="submit-pink">



                                    <i class="fa fa-save"></i> Save



                                </button>



                            </div>



                        </div>



                    	



                        	<ul style="list-style:none; margin:0 auto; padding:0;">



								<li>



									<label>



										Menu Name



									</label>



									<input type="text" name="MenuName" id="MenuName" value="'.$dataEdit[0]['MenuName'].'" />



								</li>



								<li>



									<label>



										cMenu Name



									</label>



									<input type="text" name="cMenuName" id="cMenuName" value="'.$dataEdit[0]['cMenuName'].'" />



								</li>



								<li>



									<label>



										Type



									</label>



									<input name="MenuID" type=hidden class=button value="'.$MenuID.'">



									<input name="ParentNumber" type=hidden class=button value="0">



									<input name="menu_level" type=hidden class=button value="1">



									<select name="MenuType" value="'.$dataEdit[0]['MenuType'].'>



										<option></option>



										<option value="F">Frontend</option>



										<option value="B">Backend</option>



										<option value="SA">Super Admin</option>



									</select>



								</li>



                            </ul>



                    </form> ';



	}



	



	function edit_submenu($MenuID, $ParentNumber)



	{



		/*



		$data['DataEdit']         = $this->admin_product_model->dataeditcategory($ID);



		



		$data['DataCategory']	 = $this->admin_product_model->DataCategory();		



		$this->load->view('admin/admin_category', $data);



		*/



		$MenuID2 = $this->input->get('MenuID');



		



		$dataEdit= $this->admin_menu_model->DataEditMenu($MenuID2);



		echo '



		



		 <script>



				$(function() {



					$(".submit-green").click(function(){



					   $("#editkategori").slideUp(1000);						  



					});



				});



		 </script>



		<form action="'.base_url().'admin/useradmin/edit_process_sub/'.$MenuID.'/'.$ParentNumber.'" method="post" class="contact" enctype="multipart/form-data" >



		 <input type="hidden" name="MenuID" value="'.$dataEdit[0]['MenuID'].'"/>



			<div class="action-top">



				<div class="left">



				   Edit Sub Menu



				</div>



				<div class="right">



					<a class="submit-green">



						<i class="fa fa-times"></i> Cancel



					</a>



					<button type="submit" class="submit-pink">



						<i class="fa fa-save"></i> Save



					</button>



				</div>



			</div>



			



				<ul style="list-style:none; margin:0 auto; padding:0;">



					<li>



						<label>



							Menu Name



						</label>



						<input type="text" name="MenuName" id="MenuName" value="'.$dataEdit[0]['MenuName'].'" />



					</li>



					<li>



						<label>



							cMenu Name



						</label>



						<input type="text" name="cMenuName" id="cMenuName" value="'.$dataEdit[0]['cMenuName'].'" />



					</li>



					<li>



						<label>



							Type



						</label>



						<input name="MenuID" type=hidden class=button value="'.$MenuID.'">



						<input name="ParentNumber" type=hidden class=button value="0">



						<input name="menu_level" type=hidden class=button value="1">



						<select name="MenuType" value="'.$dataEdit[0]['MenuType'].'>



							<option></option>



							<option value="F">Frontend</option>



							<option value="B">Backend</option>



							<option value="SA">Super Admin</option>



						</select>



					</li>



				</ul>



		</form> ';



	}



	



	function edit_subsubmenu()



	{



		/*



		$data['DataEdit']         = $this->admin_product_model->dataeditcategory($ID);



		



		$data['DataCategory']	 = $this->admin_product_model->DataCategory();		



		$this->load->view('admin/admin_category', $data);



		*/



		$MenuID = $this->input->get('MenuID');



		$dataEdit= $this->admin_menu_model->DataEditMenu($MenuID);



		echo '



		



		 <script>



				$(function() {



					$(".submit-green").click(function(){



					   $("#editkategori").slideUp(1000);						  



					});



				});



		 </script>



		<form action="'.base_url().'admin/useradmin/edit_process_subsub/'.$MenuID.'" method="post" class="contact" enctype="multipart/form-data" >



                     <input type="hidden" name="MenuID" value="'.$dataEdit[0]['MenuID'].'"/>



						<div class="action-top">



                            <div class="left">



                               Edit Sub Menu



                            </div>



                            <div class="right">



                                <a class="submit-green">



                                    <i class="fa fa-times"></i> Cancel



                                </a>



                                <button type="submit" class="submit-pink">



                                    <i class="fa fa-save"></i> Save



                                </button>



                            </div>



                        </div>



                    	



                        	<ul style="list-style:none; margin:0 auto; padding:0;">



								<li>



									<label>



										Menu Name



									</label>



									<input type="text" name="MenuName" id="MenuName" value="'.$dataEdit[0]['MenuName'].'" />



								</li>



								<li>



									<label>



										cMenu Name



									</label>



									<input type="text" name="cMenuName" id="cMenuName" value="'.$dataEdit[0]['cMenuName'].'" />



								</li>



								<li>



									<label>



										Type



									</label>



									<input name="MenuID" type=hidden class=button value="'.$MenuID.'">



									<input name="ParentNumber" type=hidden class=button value="0">



									<input name="menu_level" type=hidden class=button value="1">



									<select name="MenuType" value="'.$dataEdit[0]['MenuType'].'>



										<option></option>



										<option value="F">Frontend</option>



										<option value="B">Backend</option>



										<option value="SA">Super Admin</option>



									</select>



								</li>



                            </ul>



                    </form> ';



	}



	



	function edit_process($menuid)



	{	



		//tangkep data dari view input form	



		$MenuName = $this->input->post('MenuName');



		$MenuID = $this->input->post('MenuID');



		$cMenuName = $this->input->post('cMenuName');



		$MenuType = $this->input->post('MenuType');



		$MENU_ID = $this->input->post('MENU_ID');  // untuk redirect dari input type hidden



		



		$dataMenu=array(



			'MenuName'=>$MenuName,



			'MenuID'=>$MenuID,



			'cMenuName'=>$cMenuName,



			'MenuType'=>$MenuType,



		);



		



		$this->db->where('MenuID', $MenuID);



		$this->db->update('menumst', $dataMenu);



		



		redirect('admin/useradmin/menusetting/'.$menuid);



	}



	



	function edit_process_sub($menuid, $parentNumber)



	{	



		//tangkep data dari view input form	



		$MenuName = $this->input->post('MenuName');



		$MenuID = $this->input->post('MenuID');



		$cMenuName = $this->input->post('cMenuName');



		$MenuType = $this->input->post('MenuType');



		$MENU_ID = $this->input->post('MENU_ID');  // untuk redirect dari input type hidden



		



		$dataMenu=array(



			'MenuName'=>$MenuName,



			'MenuID'=>$MenuID,



			'cMenuName'=>$cMenuName,



			'MenuType'=>$MenuType,



		);



		



		$this->db->where('MenuID', $MenuID);



		$this->db->update('menumst', $dataMenu);



		



		redirect('admin/useradmin/submenusetting/'.$menuid.'/'.$parentNumber.'');



	}



	



	function edit_process_subsub($menuid)



	{	



		//tangkep data dari view input form	



		$MenuName = $this->input->post('MenuName');



		$MenuID = $this->input->post('MenuID');



		$cMenuName = $this->input->post('cMenuName');



		$MenuType = $this->input->post('MenuType');



		$MENU_ID = $this->input->post('MENU_ID');  // untuk redirect dari input type hidden



		



		$dataMenu=array(



			'MenuName'=>$MenuName,



			'MenuID'=>$MenuID,



			'cMenuName'=>$cMenuName,



			'MenuType'=>$MenuType,



		);



		



		$this->db->where('MenuID', $MenuID);



		$this->db->update('menumst', $dataMenu);



		



		redirect('admin/useradmin/subsubmenusetting/'.$menuid.'/46');



	}



	



	function insertsub($MENU_ID, $ParentNumber)



	{



	 	$LastMenuID = $this->admin_menu_model->GetLastMenuID(); // untuk dapetin menu ID yang terakhir



		







		$data = array(



					'MenuID'    	=> $LastMenuID,



					'MenuName'  	=> $this->input->post('MenuName'),



					'ParentNumber' 	=> $ParentNumber,



					//'menu_level' 	=> $this->input->post('menu_level'),



					'menu_level' 	=> 2,



					'cMenuName' 	=> $this->input->post('cMenuName'),



					'MenuType'  	=> $this->input->post('MenuType'),



					'sort'			=> $LastMenuID



				);



		



		//print_array($data);



		//exit;



		



		$Child = $data['ParentNumber'];



		



		$this->db->insert('menumst', $data);



		



		



		$this->admin_menu_model->InsertUserGroupDetail($ParentNumber);



		//$this->admin_menu_model->InsertConfigModul($MenuID); // insert table  usergroupdtlmst where MenuID=$MenuID



		$this->admin_menu_model->SetCheckedAdmin($ParentNumber);



		$this->admin_menu_model->UpdateChild($Child); // tu set this to be parent menu for sub menu



		



		redirect('admin/useradmin/submenusetting/'.$MENU_ID.'/'.$ParentNumber);



		



	}



	



	function insertsubsub($MenuID, $ParentNumber, $id_menu)



	{



	 	$LastMenuID = $this->admin_menu_model->GetLastMenuID(); // untuk dapetin menu ID yang terakhir



		







		$data = array(



					'MenuID'    	=> $LastMenuID,



					'MenuName'  	=> $this->input->post('MenuName'),



					'ParentNumber' 	=> $id_menu,



					//'menu_level' 	=> $this->input->post('menu_level'),



					'menu_level' 	=> 3,



					'cMenuName' 	=> $this->input->post('cMenuName'),



					'MenuType'  	=> $this->input->post('MenuType'),



					'sort'			=> $LastMenuID



				);



		



		//print_array($data);



		//exit;



		



		$Child = $data['ParentNumber'];



		



		$this->db->insert('menumst', $data);



		$this->admin_menu_model->InsertUserGroupDetail($ParentNumber);



		//$this->admin_menu_model->InsertConfigModul($MenuID); // insert table  usergroupdtlmst where MenuID=$MenuID



		$this->admin_menu_model->SetCheckedAdmin($ParentNumber);



		$this->admin_menu_model->UpdateChild($Child); // tu set this to be parent menu for sub menu



		



		redirect('admin/useradmin/subsubmenusetting/'.$MenuID.'/'.$ParentNumber.'/'.$id_menu);



		



	}



	



	function insertsubsubsub($MenuID, $ParentNumber, $id_menu, $id_sub_menu)



	{



	 	$LastMenuID = $this->admin_menu_model->GetLastMenuID(); // untuk dapetin menu ID yang terakhir



		







		$data = array(



					'MenuID'    	=> $LastMenuID,



					'MenuName'  	=> $this->input->post('MenuName'),



					'ParentNumber' 	=> $id_sub_menu,



					//'menu_level' 	=> $this->input->post('menu_level'),



					'menu_level' 	=> 4,



					'cMenuName' 	=> $this->input->post('cMenuName'),



					'MenuType'  	=> $this->input->post('MenuType'),



					'sort'			=> $LastMenuID



				);



		



		//print_array($data);



		//exit;



		



		$Child = $data['ParentNumber'];



		



		$this->db->insert('menumst', $data);



		$this->admin_menu_model->InsertUserGroupDetail($ParentNumber);



		//$this->admin_menu_model->InsertConfigModul($MenuID); // insert table  usergroupdtlmst where MenuID=$MenuID



		$this->admin_menu_model->SetCheckedAdmin($ParentNumber);



		$this->admin_menu_model->UpdateChild($Child); // tu set this to be parent menu for sub menu



		



		redirect('admin/useradmin/subsubsubmenusetting/'.$MenuID.'/'.$ParentNumber.'/'.$id_menu.'/'.$id_sub_menu);



		



	}



	



	function usergroup($menuid)



	{



		//define("MENU_ID", $MENU_ID);



        //$UserID = $this->session->userdata('UserID');      



        //$this->redirectNoAuthRead($UserID, MENU_ID);



		



		$data['menumst']      = $this->admin_group_model->menumst();



	 	$data['usergroupmst'] = $this->admin_group_model->usergroupmst();



		



		



		$idAdmin = $this->session->userdata('id_admin');



		$checkMenuAccess   = $this->master_model->checkMenuAccess($menuid, $idAdmin);



		if($checkMenuAccess == false)



		{



			



			$this->load->view('admin/notAccessiblePage');



		}else{



		  $this->load->view('admin/user/usergroup', $data);



		}



		



	}



	



	



	function insert_group_process($MENU_ID)



	{



		$UserGroupID = $this->admin_group_model->GetLastUserGroupID();



		//$MenuID      = $this->input->post('MenuID');



		$ReadFlg     = $this->input->post('ReadFlg');



		



		//print_array ($MenuID).'<br>';



		//echo $ReadFlg;

		



		$data = array(



					'UserGroupID'   => $UserGroupID,



					'UserGroupName' => $this->input->post('UserGroupName')



				);



		/*print_array($data);

		echo $MENU_ID;*/



		$this->db->insert('usergroupmst', $data);



		



		$this->admin_group_model->InsertUserGroupDetail($UserGroupID);



		



		$this->SetChecked($UserGroupID, $ReadFlg);



		



		redirect('admin/useradmin/usergroup/'.$MENU_ID);



		



	}



	



	function edit_group($menuid)

	{

		$ID=$this->input->post('UserGroupID');

		

		$data['DataEdit'] = $this->admin_group_model->DataEdit($ID);

		$data['menuid'] = $menuid;

		$this->load->view('admin/user/usergroup_edit', $data);

	}

	

	

	function edit_group_process($MENU_ID,$UserGroupID)



	{



		$MenuID      = $this->input->post('MenuID');



		$ReadFlg     = $this->input->post('ReadFlg');



		$UserGroupName = $this->input->post('UserGroupName');



		



		//echo $MENU_ID.'<br>';



		//echo $UserGroupID.'<br>';



		



		$this->admin_group_model->SetNullUserGroupDetail($UserGroupID);



		



		$this->SetChecked($UserGroupID, $ReadFlg);



		



		



		$dataUserGroup=array(



			'UserGroupName'=>$UserGroupName,



		);



		



		



		$this->db->where('UserGroupID', $UserGroupID);



		$this->db->update('usergroupmst', $dataUserGroup);



		



		redirect('admin/useradmin/usergroup/'.$MENU_ID);



		/**/



	}



	



	function SetChecked($UserGroupID, $ReadFlg)



	{



		$strBaca = "";



		for ($i=0; $i<count($ReadFlg); $i++)



		{



			$strBaca = $strBaca . "'" . $ReadFlg[$i] . "',";



		}



		



		$ReadFlg = substr($strBaca, 1, strlen($strBaca)-3);



		



		$this->admin_group_model->UpdateUserGroupDetail($UserGroupID, $ReadFlg);



		



	}



	



	function update_menu()



	{



		$MenuID    		= $this->input->post('MenuID');



		$MENU_ID      = $this->input->post('MENU_ID');



		$sort       	= $this->input->post('sort');



		/*



		print_array ($MenuID);



		echo '<br>';



		print_array ($sort);



		echo '<br>';



		echo $MENU_ID;



		//echo '<br>';



		//echo $cMenuName;



		//echo '<br>';



		*/



		



		for($a=0 ; $a<count($MenuID) ; $a++)



		{



			$this->admin_menu_model->UpdateSort($MenuID[$a], $sort[$a]);



		}



		



		redirect('admin/useradmin/menusetting/'.$MENU_ID);



	



	}



	



	function updateSubmenu($menuid, $parentNumber)



	{



		$MenuID    		= $this->input->post('MenuID');



		$sort       	= $this->input->post('sort');



		



		for($a=0 ; $a < count($MenuID) ; $a++)



		{



			$this->admin_menu_model->UpdateSortSub($MenuID[$a], $sort[$a]);



		}



		



		redirect('admin/useradmin/submenusetting/'.$menuid.'/'.$parentNumber);



	



	}



	



	function admin_log($menuid)



	{



		$this->load->library('pagination');	



		



		$uri_segment  = 5;



		$limit 		= 20;



		$offset 	   = $this->uri->segment($uri_segment);		



		if ($offset == ''){$offset = 0;}else{$offset = $offset;}



		



		$num            = $this->admin_menu_model->DataLogNum();



		$DataLog     = $this->admin_menu_model->DataLog($limit, $offset);



		



		$config['base_url']	 = base_url().'admin/useradmin/admin_log/'.$menuid.'/';



		$config['total_rows']   = $num;



		$config['per_page'] 	 = $limit;



		$config['uri_segment']  = $uri_segment;



		$config['next_link'] 	= 'Next';



		$config['prev_link'] 	= 'Prev';



		$config['first_link']   = 'First';



		$config['last_link'] 	= 'Last';



		



		$this->pagination->initialize($config);



		



		$data['DataLog'] = $DataLog;



		



		$idAdmin = $this->session->userdata('id_admin');



		$checkMenuAccess   = $this->master_model->checkMenuAccess($menuid, $idAdmin);



		if($checkMenuAccess == false)



		{



			



			$this->load->view('admin/notAccessiblePage');



		}else{



		  $this->load->view('admin/admin_log', $data);



		}



	}



	



	function deleteLog($menuid)



	{



		



		$this->db->where('id', $id);



		$this->db->delete('admin_log');



		



	  	redirect('admin/useradmin/admin_log/'.$menuid);	



	}



}



?>