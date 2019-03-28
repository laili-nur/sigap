<!-- .page-title-bar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
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
        <a class="text-muted">Performa Layouter</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Performa </h1>
</header>
<!-- Reporting buku -->
<ul nav class="nav nav-tabs">
  <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/index') ?>">Performa Editor</a></li>
  <li class="nav-item"><a class="nav-link active" href="<?= base_url('performance/performa_layouter') ?>">Performa Layouter</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/index_edit_revise') ?>">Revisi Naskah</a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/index_desk_screening') ?>">Performa Desk Screening</a></li>
</ul>
<br/>
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Performa Layouter
  </button>
  <ul class="dropdown-menu">
    <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/performa_layouter') ?>">Performa Layouter Process</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/performa_layouter_final') ?>">Performa Layouter Final</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/performa_layouter_ontime') ?>">Performa Layouter On Time</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/performa_layouter_late') ?>">Performa Layouter Late</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/performa_layouter_error') ?>">Performa Layouter Error</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('performance/performa_layouter_null') ?>">Performa Layouter Kosong</a></li>
  </ul>
</div>
<!-- Reporting buku -->
<!-- /.page-title-bar -->
<br />
<div align="center">
  <h4>UGM Press</h4>
  <h5>Laporan Performa Staf Layouter</h5>
</div>
<br/>
<style >
table{
  width : 50%;
}
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
    <table id="layoutertable" class="table table-bordered editortable">
      <thead>
        <tr>
          <th><font color="white">Nama Layouter</font></th>
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
        if($performance_layouter)
        {
          foreach ($performance_layouter as $row)
          {
            ?>
            <tr>
              <td><?php echo $row->username; ?></td>
              <td class="align-middle"><strong><a href="<?= base_url('draft/view/' . $row->draft_id . '') ?>"><?= $row->draft_title ?></a></strong></td>
              <td><?php echo $row->category_name; ?></td>
              <td><?php echo konversiTanggal($row->layout_start_date); ?></td>
              <td><?php echo konversiTanggal($row->layout_deadline); ?></td>
              <td><?php echo konversiTanggal($row->layout_end_date); ?></td>
              <td><?php
              if($row->performance_status == NULL){
                echo "-";
              } elseif ($row->performance_status == 1){
                echo '<p hidden> 1 </p>','<span class="badge badge-primary">ON PROCESS</span>';
              } elseif ($row->performance_status == 2) {
                echo '<p hidden> 2 </p>','<span class="badge badge-warning">FINAL</span>';
              } elseif ($row->performance_status == 3) {
                echo '<p hidden> 3 </p>','<span class="badge badge-success">ON TIME</span>';
              } elseif ($row->performance_status == 4) {
                echo '<p hidden> 4 </p>','<span class="badge badge-danger">LATE</span>';
              } else {
                echo '<p hidden> 5 </p>','<i class="fa fa-exclamation-triangle text-danger"></i>';
              }
              ?></td>
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
    $('#layoutertable').DataTable({
      "order": [[ 6, "asc" ]]
    });
  } );
  </script>
