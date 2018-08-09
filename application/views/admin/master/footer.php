<div class="modal fade" id="modal_edit" role="dialog">



    <div class="modal-dialog">



      <div class="modal-content">
        <div class="content-popup">
        </div>







      </div>



    </div>



</div>







<footer class="main-footer">



    <div class="pull-right hidden-xs">



      <!--<b>Version</b> 2.3.7-->



    </div>



    <strong>Copyright &copy; 2018 <a href="http://instagram.com/kangyasin">Dental-lab by @kangyasin</a>.</strong> All rights reserved.



  </footer>















  <div class="control-sidebar-bg"></div>



</div>



<!-- ./wrapper -->







<!-- jQuery 2.2.3 -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/jQuery/jquery-2.2.3.min.js"></script>



<!-- Bootstrap 3.3.6 -->



<script src="<?php echo base_url();?>appinclude/admin/bootstrap/js/bootstrap.min.js"></script>



<!-- DataTables -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>



<!-- SlimScroll -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>



<!-- FastClick -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/fastclick/fastclick.js"></script>



<!-- AdminLTE App -->



<script src="<?php echo base_url();?>appinclude/admin/dist/js/app.min.js"></script>



<!-- AdminLTE for demo purposes -->



<script src="<?php echo base_url();?>appinclude/admin/dist/js/demo.js"></script>

<script src="<?php echo base_url();?>appinclude/admin/dist/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/dist/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/dist/js/jszip.min.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/dist/js/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/dist/js/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/dist/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/dist/js/buttons.print.min.js"></script>

<!-- page script -->



<script>

$(document).ready(function() {
  // Replace the <textarea id="editor1"> with a CKEditor
  // instance, using default configuration.


  $('#example1').DataTable( {

      dom: 'lBfrtip',
      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10', '25', '50', 'Show all' ]
      ],
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
  } );
  $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
  });

  CKEDITOR.replace('editor1');
  //bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5();
});






</script>




<script>
	$(document).ready(function(){
	  var table = $('#example1').DataTable();

	  $('#btn-export').on('click', function(){
		  $('<table>').append(table.$('tr').clone()).table2excel({
			  exclude: ".excludeThisClass",
			  name: "Worksheet Name",
			  filename: "SomeFile" //do not include extension
		  });
	  });
	})
</script>






<script src="<?php echo base_url();?>appinclude/admin/plugins/select2/select2.full.min.js"></script>



<!-- InputMask -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/input-mask/jquery.inputmask.js"></script>



<script src="<?php echo base_url();?>appinclude/admin/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>



<script src="<?php echo base_url();?>appinclude/admin/plugins/input-mask/jquery.inputmask.extensions.js"></script>



<!-- date-range-picker -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>



<script src="<?php echo base_url();?>appinclude/admin/plugins/daterangepicker/daterangepicker.js"></script>



<!-- bootstrap datepicker -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/datepicker/bootstrap-datepicker.js"></script>



<!-- bootstrap color picker -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>



<!-- bootstrap time picker -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/timepicker/bootstrap-timepicker.min.js"></script>



<!-- SlimScroll 1.3.0 -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>



<!-- iCheck 1.0.1 -->



<script src="<?php echo base_url();?>appinclude/admin/plugins/iCheck/icheck.min.js"></script>







<script>



  $(function () {



    //Initialize Select2 Elements



    $(".select2").select2();







    //Datemask dd/mm/yyyy



    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});



    //Datemask2 mm/dd/yyyy



    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});



    //Money Euro



    $("[data-mask]").inputmask();







    //Date range picker



    $('#reservation').daterangepicker();



    //Date range picker with time picker



    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});



    //Date range as a button



    $('#daterange-btn').daterangepicker(



        {



          ranges: {



            'Today': [moment(), moment()],



            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],



            'Last 7 Days': [moment().subtract(6, 'days'), moment()],



            'Last 30 Days': [moment().subtract(29, 'days'), moment()],



            'This Month': [moment().startOf('month'), moment().endOf('month')],



            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]



          },



          startDate: moment().subtract(29, 'days'),



          endDate: moment()



        },



        function (start, end) {



          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));



        }



    );







    //Date picker



    $('#datepicker').datepicker({
      autoclose: true
    });







    //iCheck for checkbox and radio inputs



    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({



      checkboxClass: 'icheckbox_minimal-blue',



      radioClass: 'iradio_minimal-blue'



    });



    //Red color scheme for iCheck



    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({



      checkboxClass: 'icheckbox_minimal-red',



      radioClass: 'iradio_minimal-red'



    });



    //Flat red color scheme for iCheck



    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({



      checkboxClass: 'icheckbox_flat-green',



      radioClass: 'iradio_flat-green'



    });







    //Colorpicker



    $(".my-colorpicker1").colorpicker();



    //color picker with addon



    $(".my-colorpicker2").colorpicker();







    //Timepicker



    $(".timepicker").timepicker({



      showInputs: false



    });



  });



</script>


<script src="https://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
<script src="<?php echo base_url();?>appinclude/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
  $(function () {
	CKEDITOR.replace('editor1', { filebrowserBrowseUrl : '<?php echo base_url();?>appinclude/ckfinder/ckfinder.html' });
	$(".textarea").wysihtml5();
  });
</script>

<script>
  $(function () {
	CKEDITOR.replace('editor2', { filebrowserBrowseUrl : '<?php echo base_url();?>appinclude/ckfinder/ckfinder.html' });
	$(".textarea").wysihtml5();
  });
</script>

<script src="<?php echo base_url();?>appinclude/admin/dist/js/app.min.js"></script>
<!-- Page Script -->
<script>
  $(function () {
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

    //Handle starring for glyphicon and font awesome
    $(".mailbox-star").click(function (e) {
      e.preventDefault();
      //detect type
      var $this = $(this).find("a > i");
      var glyph = $this.hasClass("glyphicon");
      var fa = $this.hasClass("fa");

      //Switch states
      if (glyph) {
        $this.toggleClass("glyphicon-star");
        $this.toggleClass("glyphicon-star-empty");
      }

      if (fa) {
        $this.toggleClass("fa-star");
        $this.toggleClass("fa-star-o");
      }
    });
  });
</script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>appinclude/admin/dist/js/demo.js"></script>


</body>

</html>
