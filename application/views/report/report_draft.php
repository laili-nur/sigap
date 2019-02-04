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
          <a class="text-muted">Laporan Draft</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Laporan </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index') ?>">Summary</a></li>
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index_draft') ?>">Laporan Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Laporan Buku</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Laporan Penulis</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_hibah') ?>">Laporan Hibah</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_editor') ?>">Performa Editor</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_layouter') ?>">Performa Layouter</a></li>
  </ul>
  <!-- Reporting buku -->
  <!-- /.page-title-bar -->

  <br/>

  <div class="form-group row">
      <div class="col-8 col-md-10 mb-1">
          <div align="right">
            <label for="" class="col-sm-4 col-form-label"><h6>Filter:</h6></label>
          </div>
      </div>
      <div class="col-4 col-md-2  mb-4">
      <?= form_open('', ['method' => 'GET']) ?>
      <?= form_dropdown('droptahun', getYears(), $this->input->get('droptahun'), 'onchange="this.form.submit()" id="droptahun" class="form-control custom-select d-block" title="Filter tahun"') ?>
      <?= form_close() ?>
      </div>
  </div>

  <div align="center">
    <h4>UGM Press</h4>
    <h5>Laporan Grafik Jumlah Draft Perbulan</h5>
  </div>

    <!-- graph for draft -->
    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart" width="500" height="170"></canvas>
    <script>
    var tahun = $('#droptahun').val();
    $.post("<?php echo base_url();?>Reporting/getDraft?droptahun="+tahun,
        function(data){
          var obj = JSON.parse(data);
          console.log(obj);
          var tampil = [];
          for(var i=1;i<=12;i++){
            obj.count[i];
            tampil.push(obj.count[i]);
          };

          var ctx = $("#myChart");
          var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
                          "Aug", "Sep", "Oct", "Nov", "Des"] ,
                  datasets: [{
                      label: 'Laporan Draft',
                      data: tampil,
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
                          'rgba(255, 206, 86, 1)',
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
                          'rgba(171, 98, 222, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                onClick: mantul,
                legend: {
                  display : false,
                },
                title:{
                  display: true,
                  text : 'Jumlah Data',
                  fontSize : 15,
                  fontFamily :'Helvetica Neue',
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
                          fontStyle :'italic',
                          fontColor : 'black',
                          beginAtZero:true
                        }
                    }],
                      xAxes : [{
                        gridLines : {
                          display : false,

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
                      left:65,
                      right:95,
                      top:10,
                      bottom:40,
                    }
                  }
              }
          });
      });

      function mantul() {
        alert('hello');
      }
    </script>
  </div>
