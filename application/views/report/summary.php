<!-- .page-title-bar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url('reporting')?>">Report</a>
        </li>
        <li class="breadcrumb-item active">
          <a class="text-muted">Summary</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Report </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index') ?>">Summary</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Reporting Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Reporting Book</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Reporting Author</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_editor') ?>">Performa Editor</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_layouter') ?>">Performa Layouter</a></li>
  </ul>
  <!-- Reporting buku -->
  <!-- /.page-title-bar -->
  <br />
  <h5>Summary</h5>
  <br />
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>Book ID</th>
          <th>Book Title</th>
          <th>Published Date</th>
          <th>Year</th>
        </tr>
      <?php
      if($summaries)
      {
        foreach ($summaries as $row)
        {
      ?>
        <tr>
          <td><?php echo $row->draft_id; ?></td>
          <td><?php echo $row->draft_title; ?></td>
          <td><?php echo konversiTanggal($row->entry_date); ?></td>
          <td><?php echo date("Y",strtotime($row->entry_date)); ?></td>
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

    <!-- graph for book -->

    <canvas id="myChart" width="300" height="90"></canvas>
    <script>

    $.post("<?php echo base_url();?>Reporting/getSummary",
        function(data){
          var obj = JSON.parse(data);

          var review = obj.count_review;
          var disetujui = obj.count_disetujui;
          var editor = obj.count_editor;
          var layout = obj.count_layout;
          var proofread = obj.count_proofread;
          var book = obj.count_book;

          var ctx = $("#myChart");
          var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: ["Review", "Disetujui", "Editor", "Layouter", "Proofread", "Buku"],
                  datasets: [{
                      label: 'SUMMARY',
                      data: [review, disetujui, editor, layout, proofread, book],
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
                        gridLines :{
                          display : false
                        },
                        ticks: {
                          fontFamily :"'Helvetica'",
                          fontSize : 13,
                          beginAtZero:true
                        }
                    }],
                      xAxes : [{
                        gridLines : {
                          display : false
                        },
                        ticks: {
                          fontFamily :"'Helvetica'",
                          fontSize : 13,
                          beginAtZero:true
                        }
                      }],

                  }
              }
          });
      });
    </script>
