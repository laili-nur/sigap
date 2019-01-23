<?php $ceklevel = $this->session->userdata('level'); ?>
<?php
$perPage = $this->input->get('per_page');
if (empty($perPage)) {
  $perPage = 10;
}
$keywords = $this->input->get('keywords');
$filter = $this->input->get('filter');
if (isset($keywords) or isset($filter)) {
  $page = $this->uri->segment(3);
} else {
  $page = $this->uri->segment(2);
}
  // data table series number
$i = isset($page) ? $page * $perPage - $perPage : 0;
?>
<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?= base_url() ?>"><span class="fa fa-home"></span></a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= base_url() ?>">Penerbitan</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-muted">Draft</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Draft Usulan</h1>
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
            <span class="mr-auto">Tabel Draft <span class="badge badge-info">
                <?= $total ?></span></span>
            <!-- .card-header-control -->
            <div class="card-header-control">
              <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan') : ?>
              <!-- .tombol add -->
              <a href="<?= base_url('draft/add') ?>" class="btn btn-primary btn-sm">Tambah Draft</a>
              <!-- /.tombol add -->
              <?php endif ?>
            </div>
            <!-- /.card-header-control -->
          </div>
          <!-- /.d-flex -->
        </header>
        <!-- /.card-header -->
        <?php
        /*==================================================
        =            Pilihan dropdown per level            =
        ==================================================*/
        if ($ceklevel == 'reviewer') {
          $filter_status = [
            '' => '- Filter Review -',
            'belum' => ' Belum Direview',
            'sudah' => ' Sudah direview',
          ];
        } elseif ($ceklevel == 'editor') {
          $filter_status = [
            '' => '- Filter Edit -',
            'belum' => ' Belum Diedit',
            'sudah' => ' Sudah Diedit',
            'approve' => ' Edit Diterima',
            'reject' => ' Edit Dtolak',
          ];
        } elseif ($ceklevel == 'layouter') {
          $filter_status = [
            '' => '- Filter Layout -',
            'belum' => ' Belum Dilayout',
            'sudah' => ' Sudah Dilayout',
            'approve' => ' Layout Diterima',
            'reject' => ' Layout Dtolak',
          ];
        } else {
          $filter_status = [
            '' => '- Filter Status -',
            'desk-screening' => ' Tahap Desk Screening',
            'review' => ' Tahap Review',
            'edit' => 'Tahap Editorial',
            'layout' => 'Tahap Layout',
            'proofread' => 'Tahap Proofread',
            'reject' => 'Draft Ditolak',
            'final' => 'Draft Final',
          ];
        }

        $per_page = [
          '10' => '10',
          '25' => '25',
          '50' => '50',
          '100' => '100',
        ];
        ?>
        <!-- .card-body -->
        <div class="card-body p-0">
          <div class="p-3">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <p class="m-0">Tabel berikut dapat digeser secara horizontal.</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 col-lg-2 mb-3">
                <?= form_open('draft/filter', ['method' => 'GET']) ?>
                <?= form_dropdown('per_page', $per_page, $this->input->get('per_page'), 'id="per_page" class="form-control custom-select d-block" title="List per page"') ?>
              </div>
              <div class="col-12 col-md-4 col-lg-4 mb-3">
                <?= form_dropdown('filter', $filter_status, $this->input->get('filter'), ' id="filter" class="form-control custom-select d-block" title="Filter status"') ?>
              </div>
              <div class="col-12 col-md-4 col-lg-4 mb-3">
                <?= form_dropdown('category', getDropdownListCategory('category', ['category_id', 'category_name'],true), $this->input->get('category'), '" id="category" class="form-control custom-select d-block "') ?>
              </div>
              <div class="col-12 col-md-12 col-lg-2 mb-3">
                <button class="btn btn-primary btn-block ml-auto" type="submit" value="Submit" id="btn-submit"><i class="fa fa-filter"></i> Filter data</button>
                <?= form_close() ?>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <?= form_open('draft/search', ['method' => 'GET']) ?>
                <?php $placeholder = ($ceklevel == 'superadmin') ? 'placeholder="Cari berdasarkan Judul, Kategori, atau Tema" class="form-control"' : 'placeholder="Enter Title" class="form-control"' ?>
                <div class="input-group input-group-alt">
                  <?= form_input('keywords', $this->input->get('keywords'), $placeholder) ?>
                  <div class="input-group-append">
                    <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
                  </div>
                  <?= form_close() ?>
                </div>
              </div>
            </div>
          </div>
          <!-- .table-responsive -->
          <?php if ($drafts) : ?>
          <div class="double-scroll">
            <!-- .table -->
            <table class="table table-striped">
              <!-- thead -->
              <thead>
                <tr>
                  <th scope="col" class="pl-3">No</th>
                  <th scope="col" style="min-width:220px;">Kategori</th>
                  <th scope="col" style="min-width:50px;">Tahun</th>
                  <th scope="col" style="min-width:350px;">Judul</th>
                  <?php if ($ceklevel != 'reviewer') : ?>
                  <th scope="col" style="min-width:150px;">Penulis</th>
                  <?php endif ?>
                  <th scope="col" style="max-width:100px;">Tanggal Masuk</th>
                  <th scope="col" style="min-width:130px;">Status</th>
                  <?php if ($ceklevel == 'reviewer' or $ceklevel == 'editor' or $ceklevel == 'layouter') : ?>
                  <th scope="col">Sisa Waktu</th>
                  <?php endif ?>
                  <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan') : ?>
                  <th style="min-width:170px;"> &nbsp; </th>
                  <?php else : ?>
                  <th scope="col"> Aksi </th>
                  <?php endif ?>
                </tr>
              </thead>
              <!-- /thead -->
              <!-- tbody -->
              <tbody>
                <?php foreach ($drafts as $draft) :
                  $authors = '';
                foreach ($draft->author as $key => $value) {
                  $authors .= $value->author_name;
                  $authors .= '<br>';
                }
                $authors = substr($authors, 0, -2);
                ?>
                <!-- tr -->
                <tr>
                  <td class="align-middle pl-3">
                    <?= ++$i ?>
                  </td>
                  <td class="align-middle">
                    <?= $draft->category_name ?>
                  </td>
                  <td class="align-middle">
                    <?= $draft->category_year ?>
                  </td>
                  <td class="align-middle"><strong><a href="<?= base_url('draft/view/' . $draft->draft_id . '') ?>">
                        <?= $draft->draft_title ?></a></strong></td>
                  <?php if ($ceklevel != 'reviewer') : ?>
                  <td class="align-middle">
                    <?= isset($draft->author[0]->author_name) ? $draft->author[0]->author_name : '-' ?>
                  </td>
                  <?php endif ?>
                  <td class="align-middle">
                    <?= konversiTanggal($draft->entry_date) ?>
                  </td>
                  <td class="align-middle">
                    <?php 
                    if ($ceklevel == 'reviewer') {
                      if ($draft->review_flag != '') {
                        echo '<span class="badge badge-success">Sudah direview</span>';
                      } else {
                        echo '<span class="badge badge-danger">Belum direview</span>';
                      }
                    } else {
                      echo $draft->draft_status;
                    }
                    ?>
                  </td>
                  <?php if ($ceklevel == 'reviewer') : ?>
                  <td class="align-middle">
                    <?php
                    $sisa_waktu = ceil((strtotime($draft->deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
                    if ($sisa_waktu <= 0 and $draft->review_flag == '') {
                      echo '<span class="font-weight-bold text-danger" ><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>';
                    } elseif ($sisa_waktu <= 0 and $draft->review_flag != '') {
                      echo '-';
                    } else {
                      echo $sisa_waktu . ' hari';
                    }
                    ?>
                  </td>
                  <?php elseif ($ceklevel == 'editor') : ?>
                  <td class="align-middle">
                    <?php
                    $sisa_waktu = ceil((strtotime($draft->edit_deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
                    if ($sisa_waktu <= 0 and $draft->edit_notes == '') {
                      echo '<span class="font-weight-bold text-danger" ><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>';
                    } elseif ($sisa_waktu <= 0 and $draft->edit_notes != '') {
                      echo '-';
                    } else {
                      echo $sisa_waktu . ' hari';
                    }
                    ?>
                  </td>
                  <?php elseif ($ceklevel == 'layouter') : ?>
                  <td class="align-middle">
                    <?php
                    $sisa_waktu = ceil((strtotime($draft->layout_deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
                    if ($sisa_waktu <= 0 and $draft->layout_notes == '') {
                      echo '<span class="font-weight-bold text-danger" ><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>';
                    } elseif ($sisa_waktu <= 0 and $draft->layout_notes != '') {
                      echo '-';
                    } else {
                      echo $sisa_waktu . ' hari';
                    }
                    ?>
                  </td>
                  <?php else : ?>
                  <!-- selain reviewer, di set default -->
                  <?php $sisa_waktu = 1;
                  $draft->review_flag = true; ?>
                  <?php endif ?>
                  <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan') : ?>
                  <td class="align-middle text-right">
                    <a title="View" href="<?= base_url('draft/view/' . $draft->draft_id . '') ?>" class="btn btn-sm btn-secondary">
                      <i class="fa fa-eye"></i> View
                      <span class="sr-only">View</span>
                    </a>
                    <a title="Edit" href="<?= base_url('draft/edit/' . $draft->draft_id . '') ?>" class="btn btn-sm btn-secondary">
                      <i class="fa fa-pencil-alt"></i>
                      <span class="sr-only">Edit</span>
                    </a>
                    <button title="Delete" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalhapus-<?= $draft->draft_id ?>"><i
                        class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                    <div class="text-left">
                      <!-- Alert Danger Modal -->
                      <div class="modal modal-alert fade" id="modalhapus-<?= $draft->draft_id ?>" tabindex="-1" role="dialog"
                        aria-labelledby="modalhapus" aria-hidden="true">
                        <!-- .modal-dialog -->
                        <div class="modal-dialog" role="document">
                          <!-- .modal-content -->
                          <div class="modal-content">
                            <!-- .modal-header -->
                            <div class="modal-header">
                              <h5 class="modal-title">
                                <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi Hapus</h5>
                            </div>
                            <!-- /.modal-header -->
                            <!-- .modal-body -->
                            <div class="modal-body">
                              <p>Apakah anda yakin akan menghapus buku <span class="font-weight-bold">
                                  <?= $draft->draft_title ?></span>?</p>
                            </div>
                            <!-- /.modal-body -->
                            <!-- .modal-footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('draft/delete/' . $draft->draft_id . '') ?>'"
                                data-dismiss="modal">Hapus</button>
                              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            </div>
                            <!-- /.modal-footer -->
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      <!-- /.modal -->
                    </div>
                  </td>
                  <?php else : ?>
                  <td class="align-middle">
                    <!-- <button onclick="location.href='<?= base_url('draft/view/' . $draft->draft_id . '') ?>'" class="btn btn-sm btn-secondary <?= ($sisa_waktu <= 0 and $draft->review_flag == '') ? 'btn-disabled' : '' ?>" <?= ($sisa_waktu <= 0 and $draft->review_flag == '') ? 'disabled' : '' ?>><i class="fa fa-eye" ></i> View
                      <span class="sr-only">View</span>
                    </button> -->
                    <a title="View" href="<?= base_url('draft/view/' . $draft->draft_id . '') ?>" class="btn btn-sm btn-secondary">
                      <i class="fa fa-eye"></i> View
                      <span class="sr-only">View</span>
                    </a>

                  </td>
                  <?php endif ?>
                </tr>

                <!-- /tr -->

                <?php endforeach ?>
              </tbody>
              <!-- /tbody -->
            </table>
            <!-- /.table -->
          </div>

          <?php else : ?>
          <p class="text-center">Data tidak tersedia</p>
          <?php endif ?>
          <!-- /.table-responsive -->
          <!-- Pagination -->
          <?php if ($pagination) : ?>
          <?= $pagination ?>
          <?php else : ?>
          &nbsp;
          <?php endif ?>
          <!-- .pagination -->
        </div>
        <!-- /.card-body -->
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan') : ?>
        <!-- .card-footer -->
        <footer class="card-footer">
          <div class="card-footer-content">
            <a href="<?= base_url('category') ?>" class="btn btn-secondary mr-2">Kategori</a>
            <a href="<?= base_url('theme') ?>" class="btn btn-secondary mr-2">Tema</a>
          </div>
        </footer>
        <!-- /.card-footer -->
        <?php endif ?>
      </section>
      <!-- /.card -->
    </div>
    <!-- /grid column -->
  </div>
  <!-- /grid row -->
</div>
<!-- /.page-section -->


<script type="text/javascript">
  $(document).ready(function () {
    doublescroll();
    $("#category").select2({
      placeholder: '-- Semua --',
      allowClear: true
    });
    $("#filter").select2({
      placeholder: '-- Filter tahapan --',
      allowClear: true
    });
  });
</script>