<?php
$per_page = 10;
$keywords = $this->input->get('keywords');
$filter   = $this->input->get('filter');
if (isset($keywords) or isset($filter)) {
    $page = $this->uri->segment(3);
} else {
    $page = $this->uri->segment(2);
}
// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;

$filter_worksheet = [
    ''         => '- Filter Status -',
    'waiting'  => ' Menunggu',
    'approved' => ' Diterima',
    'rejected' => ' Ditolak',
];
?>
<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url();?>">Penerbitan</a>
      </li>
      <li class="breadcrumb-item active">
        <a class="text-muted">Lembar Kerja</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Lembar Kerja </h1>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <!-- grid row -->
  <div class="row">
    <!-- grid column -->
    <div class="col-12">
      <!-- .card -->
      <section class="card card-fluid">
        <!-- .card-header -->
        <header class="card-header">
          <!-- .d-flex -->
          <div class="d-flex align-items-center">
            <span class="mr-auto">Tabel Lembar Kerja <span class="badge badge-info"><?=$total;?></span></span>
            <!-- .card-header-control -->
            <div class="card-header-control">
              <!-- .tombol add -->
              <!-- <a href="<?=base_url('worksheet/add');?>" class="btn btn-primary btn-sm">Tambah Lembar Kerja</a> -->
              <!-- /.tombol add -->
            </div>
            <!-- /.card-header-control -->
          </div>
          <!-- /.d-flex -->
        </header>
        <!-- /.card-header -->
        <!-- .card-body -->
        <div class="card-body p-0">
          <div class="p-3">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <h5>Info</h5>
              <p class="m-0">Klik tombol <button class="btn btn-sm btn-secondary"><i class="fa fa-thumbs-up"></i> Aksi</button> untuk menyetujui atau menolak draft sesuai dengan keputusan desk screening</p>
              <p class="m-0">Klik link di kolom <em>Judul draft</em> untuk menuju draft yang terkait</p>
              <p class="m-0">Klik link di kolom <em>Nomer lembar kerja</em> untuk memasukkan keterangan desk screening</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <div class="col-12 col-lg-3 mb-3">
                <?=form_open('worksheet/filter', ['method' => 'GET']);?>
                <?=form_dropdown('filter', $filter_worksheet, $this->input->get('filter'), 'onchange="this.form.submit()" id="filter" class="form-control custom-select d-block" title="Filter"');?>
                <?=form_close();?>
              </div>
              <div class="col-12 col-lg-9 ">
                <?=form_open('worksheet/search', ['method' => 'GET']);?>
                <div class="input-group input-group-alt">
                  <?=form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Cari berdasarkan Nomer Lembar Kerja atau Judul Draft', 'class' => 'form-control']);?>
                  <div class="input-group-append">
                    <?=form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']);?>
                  </div>
                  <?=form_close();?>
                </div>
              </div>
            </div>
          </div>
          <!-- .table-responsive -->
          <?php if ($worksheets): ?>
          <div class="double-scroll">
            <!-- .table -->
            <table class="table table-striped">
              <!-- thead -->
              <thead>
                <tr>
                  <th scope="col" class="pl-4">No</th>
                  <th scope="col" style="min-width:350px;">Judul Draft</th>
                  <th scope="col">Tahun Masuk</th>
                  <th scope="col" style="min-width:120px;">Nomor Lembar Kerja</th>
                  <th scope="col">Jenis</th>
                  <th scope="col">Revisi</th>
                  <th scope="col">Status</th>
                  <th scope="col">PIC</th>
                  <th scope="col">Deadline</th>
                  <th scope="col">Tanggal Selesai</th>
                  <th style="min-width:200px;"> &nbsp; </th>
                </tr>
              </thead>
              <!-- /thead -->
              <!-- tbody -->
              <tbody>
                <?php foreach ($worksheets as $worksheet): ?>
                <!-- tr -->
                <tr>
                  <td class="align-middle pl-4"><?=++$i;?></td>
                  <td class="align-middle"><a title="Lihat detail draft" href="<?=base_url('draft/view/' . $worksheet->draft_id);?>"><?=$worksheet->draft_title;?></a></td>
                  <td class="align-middle"><?=date('Y', strtotime($worksheet->entry_date));?></td>
                  <td class="align-middle"><a title="Lihat Desk Screening" href="<?=base_url('worksheet/edit/' . $worksheet->worksheet_id);?>"><?=$worksheet->worksheet_num;?></a></td>
                  <td class="align-middle"><?=$worksheet->is_reprint == 'y' ? 'Cetak Ulang' : 'Baru';?></td>
                  <td class="align-middle"><?=$worksheet->is_revise == 'y' ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';?></td>
                  <td class="align-middle"><?=
$status = "";
if ($worksheet->worksheet_status > 0) {
    if ($worksheet->worksheet_status == 1) {
        $status = '<span class="badge badge-success">Approved</span>';
    } else {
        $status = '<span class="badge badge-danger">Rejected</span>';
    }
} else {
    $status = '<span class="badge badge-warning">Waiting</span>';
}
echo $status;
?>
                  </td>
                  <td class="align-middle"><?=$worksheet->worksheet_pic;?></td>
                  <td class="align-middle"> <?=format_datetime($worksheet->worksheet_deadline);?></td>
                  <td class="align-middle"> <?=format_datetime($worksheet->worksheet_end_date);?></td>
                  <td class="align-middle text-right">
                    <button type="button" class="btn btn-sm btn-secondary" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-content="
                      <?php echo html_escape('<div class="list-group list-group-bordered" style="margin: -9px -15px;border-radius:0;">
                        <a href="' . base_url('worksheet/action/' . $worksheet->worksheet_id . '/1') . '" class="list-group-item list-group-item-action p-2">
                          <div class="list-group-item-figure">
                          <div class="tile bg-success">
                          <span class="fa fa-check"></span>
                          </div>
                          </div>
                          <div class="list-group-item-body"> Setuju </div>
                        </a>
                        <a href="' . base_url('worksheet/action/' . $worksheet->worksheet_id . '/2') . '" class="list-group-item list-group-item-action p-2">
                          <div class="list-group-item-figure">
                          <div class="tile bg-danger">
                          <span class="fa fa-ban"></span>
                          </div>
                          </div>
                          <div class="list-group-item-body"> Tolak </div>
                        </a>
                        </div>'); ?>" data-trigger="focus">
                    <i class="fa fa-thumbs-up"></i> Aksi
                    </button>
                    <a title="Edit" href="<?=base_url('worksheet/edit/' . $worksheet->worksheet_id . '');?>" class="btn btn-sm btn-secondary">
                    <i class="fa fa-pencil-alt"></i>
                    <span class="sr-only">Edit</span>
                    </a>
                    <?php endforeach;?>
              </tbody>
              <!-- /tbody -->
            </table>
            <!-- /.table -->
          </div>
          <?php else: ?>
          <p class="text-center">Data tidak tersedia</p>
          <?php endif;?>
          <!-- /.table-responsive -->
          <!-- Pagination -->
          <?php if ($pagination): ?>
          <?=$pagination;?>
          <?php else: ?>
          &nbsp;
          <?php endif;?>
          <!-- .pagination -->
        </div>
        <!-- /.card-body -->
      </section>
      <!-- /.card -->
    </div>
    <!-- /grid column -->
  </div>
  <!-- /grid row -->
</div>
<!-- /.page-section -->
<script type="text/javascript">
  $(document).ready(function() {
    doublescroll();
  });
</script>
