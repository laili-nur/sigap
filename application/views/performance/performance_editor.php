<!-- .page-title-bar -->
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url('performance')?>">Performa</a>
        </li>
        <li class="breadcrumb-item active">
          <a class="text-muted">Performa Editor</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Performa </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('performance/index') ?>">Performa Editor</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/performa_layouter') ?>">Performa Layouter</a></li>
  </ul>
  <!-- Reporting buku -->
  <!-- /.page-title-bar -->
  <br />
  <div align="center">
    <h4>UGM Press</h4>
    <h5>Laporan Performa Staf Editor</h5>
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
      <table id="editortable" class="table table-bordered editortable">
        <thead>
          <tr>
            <th><font color="white">Nama Editor</font></th>
            <th><font color="white">Judul Draft</font></th>
            <th><font color="white">Kategori Hibah</font></th>
            <th><font color="white">Tanggal Masuk</font></th>
            <th><font color="white">Deadline</font></th>
            <th><font color="white">Tanggal Jadi</font></th>
            <th><font color="white">Status</font></th>
          </tr>
      </thead>
      <tbody>
      <?php
      if($performance_editor)
      {
        foreach ($performance_editor as $row)
        {
      ?>
        <tr>
          <td><?php echo $row->username; ?></td>
          <td><?php echo $row->draft_title; ?></td>
          <td><?php echo $row->category_name; ?></td>
          <td><?php echo konversiTanggal($row->edit_start_date); ?></td>
          <td><?php echo konversiTanggal($row->edit_deadline); ?></td>
          <td><?php echo konversiTanggal($row->edit_end_date); ?></td>
          <td><?php if($row->performance_status == 1){
            ?> <span class="badge badge-primary">ON PROCESS</span> <?php
          }
          elseif ($row->performance_status == 2) {
            ?> <span class="badge badge-warning">FINAL</button> <?php
          }
          elseif ($row->performance_status == 3) {
            ?> <span class="badge badge-success">ON TIME</button> <?php
          }
          else {
            ?> <span class="badge badge-danger">LATE</button> <?php
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
      </tbody>
      </table>
    </div>

<script>
$(document).ready(function() {
  $('#editortable').DataTable();
} );
</script>
