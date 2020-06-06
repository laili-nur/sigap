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
        <a class="text-muted">Laporan Author</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Laporan </h1>
</header>
<!-- Reporting buku -->
<ul nav class="nav nav-tabs">
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index') ?>">Summary</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_baru') ?>">Naskah Baru</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_ulang') ?>">Cetak Ulang</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Laporan Draft</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Laporan Buku</a></li>
  <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index_author') ?>">Laporan Penulis</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_hibah') ?>">Laporan Hibah</a></li>
</ul>

<!-- /.page-title-bar -->

<!-- Graph for Author -->
<br />
<div class="form-group row">
  <div class="col-8 col-md-12 mb-2">
    <div align="right">
      <div class="col-4 col-md-2 mb-4">
        <button id="button" type="button" class="btn btn-primary">View  <i class="fa fa-eye"></i></a>
      </div>
    </div>
  </div>
</div>

<div align="center">
  <h4>UGM Press</h4>
  <h5>Laporan Grafik Instansi Penulis</h5>
</div>
<div class="bg-modal">
  <div class="modal-content">

<div class="close">+</div>
<div style="overflow: hidden; margin: 15px auto;">
<iframe id="embed" src="<?=base_url('book/') ?>" style="border: 0px none; margin-left: -250px; height: 812px; margin-top: -200px; width: 1200px;">
</iframe>
</div>

  </div>
</div>
<script type="text/javascript">
  function embed(url){
    $('#embed').attr("src", url);
  }
</script>
<style>
  .bg-modal{
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
    position: absolute;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    display: none;
  }

  .modal-content{
    width: 90%;
    height: 90%;
    background-color: white;
    border-radius: 4px;
    text-align: center;
    padding: 20px;
  }

  .badge-primary{
    width:15%;
    height: 20%;
    font-size: 12px;
    display: inline-grid;
    margin: 40px auto ;
  }

  .close{
    position: absolute;
    top:0;
    right: 10px;
    font-size: 32px;
    transform: rotate(45deg);
    cursor: pointer;
  }
</style>
<canvas id="myPieChart" width="380" height="100"></canvas>
<script>

$.post("<?php echo base_url();?>Reporting/getPie",
function(data){
  var obj = JSON.parse(data);

  var ugm = obj.count_ugm;
  var lain = obj.count_lain;

  var ctx = $("#myPieChart");
  var myPieChart = new Chart(ctx,{
    type: 'pie',
    data : {
      labels: ['UGM', 'Selain UGM'],
      datasets: [{
        label : 'Penulis',
        data: [ugm, lain],
        backgroundColor : [
          'rgba(54, 162, 235, 1)',
          'rgba(198, 198, 198, 1)'
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
      }
    }
  });
});
</script>

<br />
<div align="center">
  <h5>Laporan Grafik Penulis Berdasarkan Gelar</h5>
</div>

<canvas id="myPieChartGelar" width="380" height="100"></canvas>
<script>

$.post("<?php echo base_url();?>Reporting/getPieAuthorGelar",
function(data){
  var obj = JSON.parse(data);

  var prof = obj.count_prof;
  var doctor = obj.count_doctor;
  var lainnya = obj.count_lainnya;

  var ctx = $("#myPieChartGelar");
  var myPieChart = new Chart(ctx,{
    type: 'pie',
    data : {
      labels: ['Author Professor', 'Author Doktor', 'Author Magister, Sarjana, dll'],
      datasets: [{
        label : 'Gelar Penulis',
        data: [prof, doctor, lainnya],
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
      }
    }
  });
});
document.getElementById('button').addEventListener('click',
function (){
  document.querySelector('.bg-modal').style.display = 'flex';
});
document.querySelector('.close').addEventListener('click',
function(){
  document.querySelector('.bg-modal').style.display = 'none';
});
</script>
