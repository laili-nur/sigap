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
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Laporan Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Laporan Buku</a></li>
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index_author') ?>">Laporan Author</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_editor') ?>">Performa Editor</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_layouter') ?>">Performa Layouter</a></li>
  </ul>

  <!-- /.page-title-bar -->

  <!-- Graph for Author -->

  <br />
  <div align="center">
    <h5>UGM Press</h5>
    <h6>Grafik Instansi Author</h6>
  </div>

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
            ticks : {
              beginAtZero:true
            }
          }
      });
    });
  </script>

  <!-- table for author -->

  <br />
  <h5>Tabel Author</h5>
  <br />

  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>Author ID</th>
          <th>Author Name</th>
          <th>Author Email</th>
        </tr>
      <?php
      if($author)
      {
        foreach ($author as $row)
        {
      ?>
        <tr>
          <td><?php echo $row->author_id; ?></td>
          <td><?php echo $row->author_name; ?></td>
          <td><?php echo $row->author_email; ?></td>
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
