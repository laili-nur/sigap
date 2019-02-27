<?php
$perPage = 10;
$keywords = $this->input->get('keywords');

if (isset($keywords)) {
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
        <a href="<?=base_url()?>"><span class="fa fa-home"></span></a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-muted">Document</a>
      </li>
    </ol>
  </nav>
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
            <span class="mr-auto">Tabel Dokumen <span class="badge badge-info">
                <?=$total ?></span></span>
            <!-- .card-header-control -->
            <div class="card-header-control">
              <!-- .tombol add -->
              <a href="<?=base_url('document/add') ?>" class="btn btn-primary btn-sm">Tambah Dokumen</a>
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
            <!-- .input-group -->
            <?= form_open('document/search', ['method' => 'GET']) ?>
            <div class="input-group input-group-alt">
              <?= form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Cari Dokumen', 'class' => 'form-control']) ?>
              <div class="input-group-append">
                <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
              </div>
              <?= form_close() ?>
            </div>
            <!-- /.input-group -->
          </div>
          <div class="tab-pane fade active show" id="card-tabel1">
            <!-- .table-responsive -->
            <?php if ($documents):?>
            <div >
                
                  <?php foreach($documents as $document): ?>
                  <!-- tr -->
                  <div class="px-3 py-1">
                    <!-- .card -->
                    <div class="card card-fluid mb-2">
                      <!-- .card-body -->
                      <div class="card-body">
                        <!-- grid row -->
                        <div class="row align-items-center">
                          <!-- grid column -->
                          <div class="col-auto">
                            <div class="tile tile-circle tile-lg">
                              <span class="fa fa-file"></span>
                            </div>
                          </div><!-- /grid column -->
                          <!-- grid column -->
                          <div class="col">
                            <h3 class="card-title">
                              <?= $document->document_name ?> <small class="text-muted"><?= konversiTanggal($document->document_upload_date, true) ?></small>
                            </h3>
                            <h6 class="card-subtitle text-muted"> <?= $document->document_notes ?> </h6>
                          </div><!-- /grid column -->
                          <!-- /grid column -->
                          <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-secondary"><i class="fa fa-download"></i><span class="sr-only">Download</span></button>
                            <a href="<?= base_url('document/edit/'.$document->document_id.'') ?>" class="btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i><span class="sr-only">Edit</span>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalhapus-<?= $document->document_id ?>"><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                          </div><!-- /grid column -->
                        </div><!-- /grid row -->
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
                    <!-- .card -->
                  </div>
                  <!-- Alert Danger Modal -->
                  <div class="modal modal-alert fade" id="modalhapus-<?= $document->document_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
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
                          <p>Apakah anda yakin akan menghapus document <span class="font-weight-bold">
                              <?= $document->document_name ?></span>?</p>
                        </div>
                        <!-- /.modal-body -->
                        <!-- .modal-footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('document/delete/'.$document->document_id.'') ?>'" data-dismiss="modal">Hapus</button>
                          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>
                        <!-- /.modal-footer -->
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                  <?php endforeach ?>
            </div>
            <?php else: ?>
            <p class="text-center">Data tidak tersedia</p>
            <?php endif ?>
            <!-- /.table-responsive -->
            <!-- Pagination -->
            <?php if ($pagination): ?>
            <?= $pagination ?>
            <?php else: ?>
            &nbsp;
            <?php endif ?>
            <!-- .pagination -->
          </div>
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