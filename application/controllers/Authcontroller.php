<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Authcontroller extends CI_Controller {

    function __construct()

	{

        parent::__construct();

    }



    

    function index()

	{

		$this->load->model('authmodel');

		$UserName = $this->input->post('username');

		$UserPwd  = $this->input->post('userpwd');

        $userdata = $this->authmodel->getValidUserData($UserName, $UserPwd);

        

        if (!empty($userdata))

		{

            $this->session->set_userdata($userdata[0]);



			redirect('admin/admin_profile/index/9');



        }else{

            redirect('admin/admin_login');

        }



	}



	



	function redirectNoAuthRead($UserID, $MenuID)

	{

		$this->load->model('authmodel');

        $isauthread = $this->authmodel->get_auth_read($UserID, $MenuID);



		if($UserID == '')

		{

			redirect(base_url().'admin');

		}





        if (!$isauthread){

         	redirect('admin/admin_login/redirectNoAuthUser');

        }



    }



	





}   



?>