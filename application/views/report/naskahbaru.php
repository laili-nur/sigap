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
        <a class="text-muted">Cetak Ulang</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Laporan </h1>
</header>
<!-- Reporting buku -->
<ul nav class="nav nav-tabs">
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index') ?>">Summary</a></li>
  <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index_baru') ?>">Naskah Baru</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_ulang') ?>">Cetak Ulang</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Laporan Draft</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Laporan Buku</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Laporan Penulis</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_hibah') ?>">Laporan Hibah</a></li>
</ul>

<!-- /.page-title-bar -->
<br />
<ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#grafik">
              Grafik Naskah Baru
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#laporan">
              Laporan Naskah Baru
            </a>
        </li>
</ul>
<div class="tab-content isi-tab">
    <div class="tab-pane active" id="grafik">
        <?= form_open('', ['method' => 'GET']) ?>
          <div class="form-group row">
            <div class="col-8 col-md-10 mb-1">
              <div align="right">
                <label for="" class="col-sm-4 col-form-label"><h6><i class="fa fa-filter"></i> Filter :</h6></label>
              </div>
            </div>
            <div class="col-4 col-md-2  mb-4">
              <?= form_dropdown('droptahunsummary', getYearsSummary(), $this->input->get('droptahunsummary'), 'onchange="this.form.submit()" id="droptahunsummary" class="form-control custom-select d-block" title="Filter tahun"') ?>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-8 col-md-10 mb-1">
              <div align="right">
                <label for="" class="col-sm-4 col-form-label"><h6><i class="fa fa-filter"></i> Kategori :</h6></label>
              </div>
            </div>
            <div class="col-4 col-md-2  mb-4">
              <?= form_dropdown('category', getDropdownListCategory('category', ['category_id', 'category_name'],true), $this->input->get('category'), 'onchange="this.form.submit()" id="category" class="form-control custom-select d-block" title="Filter Kategori"') ?>
            </div>
          </div>
          <?= form_close() ?>

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
          <h5>Laporan Grafik Ringkasan Naskah Baru</h5>
        </div>


        <div class="bg-modal">
          <div class="modal-content">
        <div class="close">+</div>

        <form action="">
          <a href="javascript:embed('<?=base_url('draft/filter?reprint=n&filter=review') ?>')" class="badge badge-primary">Review</a>
          <a href="javascript:embed('<?=base_url('draft/filter?reprint=n&filter=edit') ?>')" class="badge badge-primary">Editorial</a>
          <a href="javascript:embed('<?=base_url('draft/filter?reprint=n&filter=layout') ?>')" class="badge badge-primary">Layout</a>
          <a href="javascript:embed('<?=base_url('draft/filter?reprint=n&filter=proofread') ?>')" class="badge badge-primary">Proofread</a>
          <a href="javascript:embed('<?=base_url('draft/filter?reprint=n&filter=cetak') ?>')" class="badge badge-primary">Cetak</a>
          <a href="javascript:embed('<?=base_url('draft/filter?reprint=n&filter=final') ?>')" class="badge badge-primary">Final</a>
        </form>
        <div style="overflow: hidden; margin: 15px auto;">
        <iframe id="embed" src="<?=base_url('draft/filter?reprint=n&filter=review') ?>" style="border: 0px none; margin-left: -250px; height: 812px; margin-top: -200px; width: 1200px;">
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

        <canvas id="myChart1" width="500" height="170"></canvas>
        <script>
        var tahun = $('#droptahunsummary').val();
        var category = $('#category').val();
        $.post("<?php echo base_url();?>Reporting/getSummaryBaru?droptahunsummary="+tahun+"&category="+category,
        function(data){
          var obj = JSON.parse(data);
          var review_baru = obj.count_review_baru;
          var disetujui_baru = obj.count_disetujui_baru;
          var antri_editor_baru = obj.count_antri_editor_baru;
          var editor_baru = obj.count_editor_baru;
          var layout_baru = obj.count_layout_baru;
          var proofread_baru = obj.count_proofread_baru;
          var print_baru = obj.count_print_baru;
          var final_baru = obj.count_final_baru;

          var ctx = $("#myChart1");
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ["Review", "Disetujui", "Antri Editor", "Editor", "Layouter", "Proofread", "Cetak", "Final"],
              datasets: [{
                label: ['summary'],
                data: [review_baru, disetujui_baru, antri_editor_baru, editor_baru, layout_baru, proofread_baru, print_baru, final_baru],
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
    </div>
    <div class="tab-pane" id="laporan">
      <form id="ffilter">
        <div class="row form-inline mt-2">
          <div>Dari Tanggal </div>
          <input type="text" class="form-control ml-1 tgl" placeholder="dd/mm/yyyy" id="dari" required value="01/01/<?php echo date('Y'); ?>">
          <div class="ml-1">s/d</div>
          <input type="text" class="form-control ml-1 tgl" placeholder="dd/mm/yyyy" id="sampai" required value="<?php echo date('d/m/Y'); ?>">
          <button class="btn btn-primary ml-1" id="btn_proses">Proses</button>
        </div>
      </form>
        <div class="container mt-2">
          <form id="fexport" method="post" action="<?php echo site_url('reporting/export_naskah_baru'); ?>" target="_blank">
            <div class="mb-2">
              <input type="hidden" id="e_dari" name="dari" value="01/01/<?php echo date('Y'); ?>">
              <input type="hidden" id="e_sampai" name="sampai" value="<?php echo date('d/m/Y'); ?>">
              <button class="btn btn-success">
                <i class="fa fa-file-excel"></i> download
              </button>
            </div>
          </form>
          <table class="mt-3 display responsive table table-bordered table-striped table-hover" style="width:100%" id="tbdata">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis UGM</th>
                <th>Penulis Non UGM</th>
            </thead>
            <tbody id="trow"></tbody>
          </table>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  $(function(){
    $('.tgl').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
      todayHighlight: true
    });

    var table = $('#tbdata').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "pageLength": 50,
            "ajax": {
                  url: "<?php echo site_url(); ?>reporting/ajax_naskah_baru/",
                  "type": "POST",
                  "data" : function(d){
                    d.dari= $("#dari").val(),
                    d.sampai= $('#sampai').val()
                  },
                  error: function (xhr, error, thrown) {
                    alert( xhr.responseText);
                  }
            },
            "columns": [
                  { "data": "no" },
                  { "data": "judul" },
                  { "data": "penulis_ugm" },
                  { "data": "penulis_non_ugm" }
            ]
    });

    $('#ffilter').submit(function(e){
      e.preventDefault();
      table.ajax.reload( null, false );   
      $('#e_dari').val($('#dari').val());
      $('#e_sampai').val($('#sampai').val());
    });
  });
</script>


