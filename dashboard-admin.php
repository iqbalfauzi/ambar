<section class="content-header">
  <h1>
    <h3>Selamat datang - <?php echo $namauser;?></h3>
    
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Selamat datang di menu Admin</h3>
      <div class="box-tools pull-right">
        
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          
      </div>
    </div>
    <div class="box-body">
      <a class="btn btn-success btn-flat pull-center " href="?p=input-data"><span class="fa fa-plus"></span> Tambah Data Trip</a>
      <?php include "daftar-pengeluaran.php"; ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</section><!-- /.content -->
