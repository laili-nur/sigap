<!-- .page-title-bar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item active">
          <a class="text-muted">Report</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Report </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index') ?>">Reporting Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Reporting Book</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Reporting Author</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_editor') ?>">Performa Editor</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_layouter') ?>">Performa Layouter</a></li>
  </ul>
  <!-- Reporting buku -->
  <!-- /.page-title-bar -->
  <br />
  <h5>Report Draft</h5>
  <br />
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>Draft ID</th>
          <th>Draft Title</th>
          <th>Entry Date</th>
          <th>Month</th>
        </tr>
      <?php
      if($drafts)
      {
        foreach ($drafts as $row)
        {
      ?>
        <tr>
          <td><?php echo $row->draft_id; ?></td>
          <td><?php echo $row->draft_title; ?></td>
          <td><?php echo konversiTanggal($row->entry_date); ?></td>
          <td><?php echo date("m",strtotime($row->entry_date)); ?></td>
        </tr>
        <?php
        }
      }
      else
      {
        ?>
        <tr>
          <td colspan="3">No data found</td>
        </tr>
      <?php
      }
      ?>
      </table>
    </div>

    <!-- graph for draft -->

    <canvas id="myChart" width="300" height="90"></canvas>
    <script>

    $.post("<?php echo base_url();?>Reporting/getDraft",
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
                  labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
                          "Agustus", "September", "Oktober", "November", "Desember"],
                  datasets: [{
                      label: 'Jumlah draft',
                      data: tampil,
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(255, 206, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(208, 222, 98, 0.2)',
                          'rgba(98, 222, 206, 0.2)',
                          'rgba(171, 98, 222, 0.2)'
                      ],
                      borderColor: [
                          'rgba(255,99,132,1)',
                          'rgba(54, 162, 235, 1)',
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
                  scales: {
                      yAxes: [{
                          ticks: {
                              beginAtZero:true
                          }
                      }]
                  }
              }
          });
      });
    </script>
