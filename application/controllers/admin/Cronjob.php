<?php

Class Authcontroller extends CI_Controller {
    function __construct()
	{
        parent::__construct();
    }

    
    public function update_promo($menuid)
	{
		$today=date('Y-m-d');
		$get_promo=$this->master_model->select_in('ms_promo','*',"WHERE expired < '$today' AND flag=1");
		
		for($a=0; $a < count($get_promo); $a++)
		{
			$ID=$get_promo[$a]->ID;
			
			$data_update=array
			(
				'flag'=>0,
				'flag_expired' => 0,
			);
			
			$this->db->where('ID', $ID);
			$this->db->update('ms_promo', $data_update);
		}
	}

	


}   

?>