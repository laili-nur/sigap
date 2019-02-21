<!-- .page-title-bar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url('reporting')?>">Laporan</a>
        </li>
        <li class="breadcrumb-item active">
          <a class="text-muted">Laporan Hibah</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Laporan </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index') ?>">Summary</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Laporan Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Laporan Buku</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Laporan Penulis</a></li>
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index_hibah') ?>">Laporan Hibah</a></li>
  </ul>

  <!-- /.page-title-bar -->

  <br />

  <div class="form-group row">
      <div class="col-8 col-md-10 mb-1">
          <div align="right">
            <label for="" class="col-sm-4 col-form-label"><h6>Filter:</h6></label>
          </div>
      </div>
      <div class="col-4 col-md-2  mb-4">
      <?= form_open('', ['method' => 'GET']) ?>
      <?= form_dropdown('droptahunhibah', getYearsHibah(), $this->input->get('droptahunhibah'), 'onchange="this.form.submit()" id="droptahunhibah" class="form-control custom-select d-block" title="Filter tahun"') ?>
      <?= form_close() ?>
      </div>
  </div>

  <div align="center">
    <h4>UGM Press</h4>
    <h4>Laporan Grafik Jumlah Kategori Buku</h4>
  </div>

  <canvas id="myPieChart" width="380" height="100"></canvas>
  <script>
  var tahun = $('#droptahunhibah').val();
  $.post("<?php echo base_url();?>Reporting/getPieHibah?droptahunhibah="+tahun,
      function(data){
        var obj = JSON.parse(data);

        var hibah = obj.count_hibah;
        var reguler = obj.count_reguler;
        var ulang = obj.count_cetak_ulang;

        var ctx = $("#myPieChart");
        var myPieChart = new Chart(ctx,{
          type: 'pie',
          data : {
            labels: ['Hibah Buku Karya', 'Reguler', 'Cetak Ulang'],
            datasets: [{
              label : 'Hibah',
              data: [hibah, reguler, ulang],
              backgroundColor : [
                'rgba(54, 162, 235, 1)',
                'rgba(198, 198, 198, 1)',
                'rgba(208, 222, 98, 1)'
              ],
              borderWidth : 1
            }]
          },
          options: {
            legend :{
              position: 'bottom',
              labels: {
                fontColor: 'black',
                fontSize: 13,
                fontStyle: ''
              }
            },
            ticks : {
              beginAtZero:true
            },
            layout:{
              padding: {
                left:80,
                right:80,
                top:5,
                bottom:25,
              }
            },
          }
      });
    });
  </script>
