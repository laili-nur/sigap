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
      <h5>Laporan Grafik Ringkasan Naskah Baru</h5>
    </div>

    <canvas id="myChart1" width="500" height="170"></canvas>
    <script>
    var tahun = $('#droptahunsummary').val();
    $.post("<?php echo base_url();?>Reporting/getSummaryBaru?droptahunsummary="+tahun,
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
    </script>
