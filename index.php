<?php
session_start();
include 'koneksi.php';
if (empty($_SESSION['id_user'])){
  header("location:login.php");
}
error_reporting(E_ALL & ~E_NOTICE);
ob_start();
$p=htmlentities($_GET['p']);
$iduser=$_SESSION['id_user'];

$coba = mysqli_query($koneksi, "SELECT * FROM usr_ambar u,level l WHERE u.id_level = l.id_level AND id_user = $iduser");
$level=mysqli_query($koneksi, "SELECT l.level FROM usr_ambar u,level l where u.id_level=l.id_level AND id_user = $iduser");

$lev=mysqli_fetch_array($level);

$row = mysqli_fetch_array($coba);

$namauser=$row['nama_user'];
$iduse=$row['id_user'];
$kategori=$row['kategori'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AMBAR - Project</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="plugins/datatables/extensions/Responsive/css/dataTables.responsive.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- SweetAlert  style -->
  <link rel="stylesheet" href="plugins/sweetalert/sweetalert.css">

  <!-- responsive datatables -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>ABR</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>AMBAR</b>-Project</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li>
              <a href="logout.php"><i class="fa fa-sign-out" onclick="return confirm('Apakah anda yakin akan Logout?')"> Logout</i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="dist/img/worker.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $namauser;?></p>
            <?php echo $lev['level']; ?>
          </div>
        </div>

        <?php
        if($lev['level']=='admin'){
          include "menu-admin.php";
        }

        if($lev['level']=='petugas'){
          include "menu-pekerja-lap.php";
        }

        ?>

      </section>
      <!-- /.sidebar -->
    </aside>


    <div class="content-wrapper">
      <?php
      $file="$p.php";
      $cek=strlen($p);
      if ($cek>30||!file_exists($file)||empty($p)) {
        if($lev['level']=='admin'){
          include "dashboard2.php";
        }

        if($lev['level']=='petugas'){
          include "dashboard-admin.php";
        }
      } else {
        include ($file);
      }
      ?>
    </div><!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2017 <a href="#">Ambar - Project</a>.</strong>
    </footer>

    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div><!-- ./wrapper -->

  <!-- jQuery 2.1.4 -->
  <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
  <!-- ChartJS 1.0.1 -->
  <script src="plugins/chartjs/Chart.min.js"></script>
  <!-- SlimScroll -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="plugins/fastclick/fastclick.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- SweetAlert -->
  <script src="plugins/sweetalert/sweetalert.min.js"></script>
  <!-- Bootstrap-notify -->
  <script src="plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="supplier/customer.js"></script>
  <script type="text/javascript">
    $(function () {
      $('#customers2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
      $('#tabelPengeluaran').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
    $('#detailTrip').on('show.bs.modal', function (e) {
      var rowid = $(e.relatedTarget).data('id');
      var dat = $(e.relatedTarget).data('tang');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type : 'post',
        url : 'detail_trip.php',
        data :  'rowid='+ rowid +'&dat='+ dat,
        success : function(data){
          $('.fetched-data').html(data);//menampilkan data ke dalam modal
        }
      });
    });
  });
  </script>
  <script type="text/javascript">
  $(function(){
    $.ajaxSetup({
      type:"POST",
      url: "data_trip.php",
      cache: false,
    });

    $("#supliyer").change(function(){
      var tglnya = $('#pilihtanggal').val();
      var value = $(this).val();
      if(value>0){
        $.ajax({
          data:{
            modul : tglnya,
            id : value
          },
          success: function(data){
            $("#tampilDataTrip").html(data);
          }
        });
      }else{
        $.ajax({
          data:{
            modul : tglnya,
            id : '0'
          },
          success: function(data){
            $("#tampilDataTrip").html(data);
          }
        });
      }
    });
    $("#pilihtanggal").change(function(){
      var  value = $('#supliyer').val();
      var tglnya = $(this).val();
      if(value>0){
        $.ajax({
          data:{
            modul : tglnya,
            id : value
          },
          success: function(data){
            $("#tampilDataTrip").html(data);
          }
        });
      }else{
        $.ajax({
          data:{
            modul : tglnya,
            id : '0'
          },
          success: function(data){
            $("#tampilDataTrip").html(data);
          }
        });
      }
    });
  });
  </script>
  <script type="text/javascript">
  $(function(){
    $("#supliyer_Bayar").change(function(){
      $.ajaxSetup({
        type:"POST",
        url: "data-pengeluaran.php",
        cache: false,
      });
      var tglnya = $('#tanggalPengeluaran').val();
      var value = $(this).val();
      if(value>0){
        $.ajax({
          data:{
            modul : tglnya,
            id : value
          },
          success: function(data){
            $("#tampilDataPengeluaran").html(data);
          }
        });
      }else{
        $.ajax({
          data:{
            modul : tglnya,
            id : '0'
          },
          success: function(data){
            $("#tampilDataPengeluaran").html(data);
          }
        });
      }
    });
    $("#tanggalPengeluaran").change(function(){
      $.ajaxSetup({
        type:"POST",
        url: "data-pengeluaran.php",
        cache: false,
      });
      var  value = $('#supliyer_Bayar').val();
      var tglnya = $(this).val();
      if(value>0){
        $.ajax({
          data:{
            modul : tglnya,
            id : value
          },
          success: function(data){
            $("#tampilDataPengeluaran").html(data);
          }
        });
      }else{
        $.ajax({
          data:{
            modul : tglnya,
            id : '0'
          },
          success: function(data){
            $("#tampilDataPengeluaran").html(data);
          }
        });
      }
    });
  });
  </script>
  <script type="text/javascript">
  $(function () {
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
  </script>
  <script type="text/javascript">
  $(function () {
    $('#tanggalPengeluaran').datepicker({
      autoclose: true
    });
  });
  </script>
  <script type="text/javascript">
  $(function () {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = {
      labels: [<?php while ($row = mysqli_fetch_array($query)) { echo '"' . $row['nopol_armada'] . '",';}?>],
      datasets: [
        {
          label: "Volume",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php while ($row2 = mysqli_fetch_array($query2)) { echo '"' . $row2['volume'] . '",';}?>],
        }
      ]
    };
    barChartData.datasets[0].fillColor = "#00a65a";
    barChartData.datasets[0].strokeColor = "#00a65a";
    barChartData.datasets[0].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };
    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });
  </script>

</body>
</html>
