<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>KisImplant | Admin</title>
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
</head>
<body>
  <div class="container">
  	    <div class="row color-invoice">
        <div class="col-md-12">
          <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7">
              <h1>FAKTUR</h1>
              <strong>PT.Kis Implant</strong><br/>
              Jl.Wijaya II Ruko Grand Wijaya Center blok G14, Lt.2, Kebayoran Baru - Jakarta<br/>
              Indonesia - 12160.
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">

              <h3>KEPADA</h3>
              <strong><?=$data_faktur[0]->nama_konsumen;?></strong><br/>
              <?=$data_faktur[0]->alamat;?>
              <br /><?=$data_faktur[0]->telp;?>

            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="table-responsive">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Barang</th>
                      <th>Jumlah.</th>
                      <th>@harga</th>
                      <th>Sub Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><?=$data_faktur[0]->nama_barang;?></td>
                      <td><?=$data_faktur[0]->qty;?></td>
                      <td align="right"><?=number_format($data_faktur[0]->harga_barang);?></td>
                      <td align="right"><?=number_format($data_faktur[0]->harga);?></td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4" align="right"><strong>Total</strong></td>
                      <td align="right"><?=number_format($data_faktur[0]->harga);?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <hr />
              <div class="row">
                <div class="col-md-4" style="text-align:center;">
                  Diterima Oleh
                  <br/><br/><br/><br/><br/>
                  -----------------

                </div>
                <div class="col-md-4" style="text-align:center;">
                  Kurir
                  <br/><br/><br/><br/><br/>
                  <?=$data_faktur[0]->kurir;?>
                </div>
                <div class="col-md-4" style="text-align:center;">
                  Disetujui Oleh
                  <br/><br/><br/><br/><br/>
                  <?=$data_faktur[0]->admin;?>
                </div>
              </div>
            </div>
          </div>

          <hr />
          <div class="row">
            <div class="col-md-12" style="text-align:center;">
              <a href="#" class="btn btn-success btn-sm" onclick="myFunction()">Cetak Faktur</a>
              <a href="<?php echo base_url();?>admin/transaction/penjualan/<?=$this->uri->segment(4);?>" class="btn btn-info btn-sm">Kembali</a>    
            </div>
          </div>
          <div class="row">


  </div>
        </div>
      </div>
  </div>
</body>

<script>
function myFunction() {
    window.print();
}
</script>

</html>
