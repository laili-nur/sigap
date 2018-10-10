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
          <a class="text-muted">Layouter Performance</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Report </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index') ?>">Summary</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Reporting Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Reporting Book</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Reporting Author</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_editor') ?>">Editor Performance</a></li>
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/performa_layouter') ?>">Layouter Performance</a></li>
  </ul>
  <!-- Reporting buku -->
  <!-- /.page-title-bar -->
  <br />
  <h5>Layouter Performance</h5>
  <br />
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>Nama Layouter</th>
          <th>Judul Draft</th>
          <th>Tanggal masuk</th>
          <th>Deadline</th>
          <th>Tanggal jadi</th>
          <th>Status</th>
        </tr>
      <?php
      if($performance_layouter)
      {
        foreach ($performance_layouter as $row)
        {
      ?>
        <tr>
          <td><?php echo $row->username; ?></td>
          <td><?php echo $row->draft_title; ?></td>
          <td><?php echo konversiTanggal($row->layout_start_date); ?></td>
          <td><?php echo konversiTanggal($row->layout_deadline); ?></td>
          <td><?php echo konversiTanggal($row->layout_end_date); ?></td>
          <td><?php if($row->layout_end_date == '0000-00-00 00:00:00'){
            echo "ON PROCESS";
          }
          elseif ($row->layout_end_date < $row->layout_deadline) {
            echo "ON TIME";
          }
          else {
            echo "LATE";
          }?></td>
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
