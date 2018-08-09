
<?php 
class my404 extends CI_Controller 
{
	
	public function __construct() 
    {
        parent::__construct(); 
    } 

	function index()
	{
		
		$this->load->view('admin/my404');
	}

}
?>