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
        <a class="text-muted">Summary</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Laporan </h1>
</header>
<!-- Reporting buku -->
<ul nav class="nav nav-tabs">
  <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index') ?>">Summary</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_baru') ?>">Naskah Baru</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_ulang') ?>">Cetak Ulang</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Laporan Draft</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Laporan Buku</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Laporan Penulis</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_hibah') ?>">Laporan Hibah</a></li>
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
    <?= form_dropdown('droptahunsummary', getYearsSummary(), $this->input->get('droptahunsummary'), 'onchange="this.form.submit()" id="droptahunsummary" class="form-control custom-select d-block" title="Filter tahun"') ?>
    <?= form_close() ?>
  </div>
</div>

<div align="center">
  <h4>UGM Press</h4>
  <h5>Laporan Grafik Ringkasan Pencetakan Buku</h5>
</div>

<div class="bg-modal">
  <div class="modal-content">

<div class="close">+</div>
<form action="">
  <a href="<?=base_url('draft/filter?filter=review') ?>" target="_blank" class="badge badge-primary">Review</a>
  <a href="<?=base_url('draft/filter?filter=edit') ?>" target="_blank" class="badge badge-primary">Editorial</a>
  <a href="<?=base_url('draft/filter?filter=layout') ?>" target="_blank" class="badge badge-primary">Layout</a>
  <a href="<?=base_url('draft/filter?filter=proofread') ?>" target="_blank" class="badge badge-primary">Proofread</a>
  <a href="<?=base_url('draft/filter?filter=cetak') ?>" target="_blank" class="badge badge-primary">Cetak</a>
  <a href="<?=base_url('draft/filter?filter=final') ?>" target="_blank" class="badge badge-primary">Final</a>
</form>

  </div>
</div>

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
    width: 600px;
    height: 125px;
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
<!-- graph for summary -->

<canvas id="myChart" width="500" height="170"></canvas>
<script>
var tahun = $('#droptahunsummary').val();
$.post("<?php echo base_url();?>Reporting/getSummary?droptahunsummary="+tahun,
function(data){
  var obj = JSON.parse(data);
  var review = obj.count_review;
  var disetujui = obj.count_disetujui;
  var antri_editor = obj.count_antri_editor;
  var editor = obj.count_editor;
  var layout = obj.count_layout;
  var proofread = obj.count_proofread;
  var print = obj.count_print;
  var final = obj.count_final;

  var ctx = $("#myChart");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Review", "Disetujui", "Antri Editor", "Editor", "Layouter", "Proofread", "Cetak", "Final"],
      datasets: [{
        label: ['summary'],
        data: [review, disetujui, antri_editor, editor, layout, proofread, print, final],
        backgroundColor: [
          'rgba(54, 162, 235, 1)',
          'rgba(198, 198, 198, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(208, 222, 98, 1)',
          'rgba(98, 222, 206, 1)',
          'rgba(171, 98, 222, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)'
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
          'rgba(198, 198, 198, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(208, 222, 98, 1)',
          'rgba(98, 222, 206, 1)',
          'rgba(171, 98, 222, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)'
        ],
        borderWidth: [
          1,
        ],
      }]
    },
    options: {
      onClick: alertBox,
      legend: {
        display : false,
      },
      title:{
        display: true,
        text : 'Jumlah Data',
        fontSize : 15,
        fontFamily :'Helvetica',
        fontColor : 'black',
        fontStyle : 'bold',
        position : 'left',
        padding : 15,
      },
      scales: {
        yAxes: [{
          gridLines :{
            display : true
          },
          ticks: {
            fontFamily :'Helvetica Neue',
            fontSize : 14,
            fontStyle :'',
            fontColor : 'black',
            beginAtZero:true
          }
        }],
        xAxes : [{
          gridLines : {
            display : false
          },
          ticks: {
            fontFamily :'Helvetica Neue',
            fontSize : 13,
            fontStyle : '',
            fontColor : 'black',
            beginAtZero:true
          }
        }],
      },
      layout:{
        padding: {
          left:50,
          right:85,
          top:10,
          bottom:50,
        }
      },
      tooltips: {

      }
    }
  });
});

function alertBox(){
  document.querySelector('.bg-modal').style.display = 'flex';
};
document.querySelector('.close').addEventListener('click',
function(){
  document.querySelector('.bg-modal').style.display = 'none';
});
</script>
