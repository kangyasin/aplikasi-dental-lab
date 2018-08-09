	<?php



        $this->load->view('admin/master/header_2');



        //$this->load->view('admin/master/menu');



        $menuid = $this->uri->segment(5);



    ?>





<div style="margin:0 auto; border:5px solid #eeeeee; text-align:center; width:400px; height:200px; line-height:200px; margin-top:150px; font-family:Arial, Helvetica, sans-serif">

	You don't have to access this page

    <a href="<?php echo base_url();?>admin/master_admin/master/home/1" class="text-blue">Go Back</a>

</div>





	<?php



        $this->load->view('admin/master/footer_2');



    ?>

