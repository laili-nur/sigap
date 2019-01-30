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
          <a class="text-muted">Performa Editor</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Laporan </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index') ?>">Summary</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Laporan Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Laporan Book</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_author') ?>">Laporan Penulis</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_hibah') ?>">Laporan Hibah</a></li>
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/performa_editor') ?>">Performa Editor</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_layouter') ?>">Performa Layouter</a></li>
  </ul>
  <!-- Reporting buku -->
  <!-- /.page-title-bar -->
  <br />
  <div align="center">
    <h4>UGM Press</h4>
    <h5>Performa Staff Editor</h5>
  </div>
  <br />
  <style >
    th{
      background-color: #346CB0;
      font color:
    }
    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th><font color="white">Nama Editor</font></th>
          <th><font color="white">Judul Draft</font></th>
          <th><font color="white">Tanggal Masuk</font></th>
          <th><font color="white">Deadline</font></th>
          <th><font color="white">Tanggal Jadi</font></th>
          <th><font color="white">Status</font></th>
        </tr>
      <?php
      if($performance_editor)
      {
        foreach ($performance_editor as $row)
        {
      ?>
        <tr>
          <td><?php echo $row->username; ?></td>
          <td><?php echo $row->draft_title; ?></td>
          <td><?php echo konversiTanggal($row->edit_start_date); ?></td>
          <td><?php echo konversiTanggal($row->edit_deadline); ?></td>
          <td><?php echo konversiTanggal($row->edit_end_date); ?></td>
          <td><?php if($row->edit_end_date == '0000-00-00 00:00:00'){
            ?> <button type="button" class="btn btn-primary btn-xs">ON PROCESS</button> <?php
          }
          elseif ($row->edit_end_date < $row->edit_deadline) {
            ?> <button type="button" class="btn btn-success btn-xs">ON TIME</button> <?php
          }
          else {
            ?> <button type="button" class="btn btn-danger btn-xs">LATE</button> <?php
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
