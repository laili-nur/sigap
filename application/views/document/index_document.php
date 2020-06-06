<?php
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
        <a href="<?=base_url()?>"><span class="fa fa-home"></span></a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-muted">Dokumen</a>
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
            <span class="mr-auto">List Dokumen <span class="badge badge-info">
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
            <div class="row">
              <div class="col-12 col-md-3 mb-3">
                <?= form_open('document/filter', ['method' => 'GET']) ?>
                <?= form_dropdown('filter', getYearsDocument(), $this->input->get('filter'), 'id="filter" class="form-control custom-select d-block" title="Filter tahun" onchange="this.form.submit()"') ?>
                <?= form_close() ?>
              </div>
              <div class="col">
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
            </div>
          </div>
          <div class="tab-pane fade active show" id="card-tabel1">
            <!-- .table-responsive -->
            <?php if ($documents):?>
            <div>
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
                        <a href="<?=base_url('document/download/documentfile/'.$document->document_file) ?>">
                        <div class="tile tile-circle tile-lg">
                          <?php if(lihatEkstensi($document->document_file) === 'pdf'): ?>
                          <span class="far fa-file-pdf"></span>
                          <?php elseif(lihatEkstensi($document->document_file) === 'jpg' or lihatEkstensi($document->document_file) === 'jpeg' or lihatEkstensi($document->document_file) === 'png'): ?>
                          <span class="far fa-file-image"></span>
                          <?php elseif(lihatEkstensi($document->document_file) === 'doc' or lihatEkstensi($document->document_file) === 'docx'): ?>
                          <span class="far fa-file-word"></span>
                          <?php elseif(lihatEkstensi($document->document_file) === 'xls' or lihatEkstensi($document->document_file) === 'xlsx'): ?>
                          <span class="far fa-file-excel"></span>
                          <?php elseif(lihatEkstensi($document->document_file) === 'zip' or lihatEkstensi($document->document_file) === 'rar'): ?>
                          <span class="far fa-file-archive"></span>
                          <?php else: ?>
                          <span class="far fa-file"></span>
                          <?php endif ?>
                        </div>
                        </a>
                      </div><!-- /grid column -->
                      <!-- grid column -->
                      <div class="col">
                        <h3 class="card-title">
                          <?= $document->document_name ?> <small class="text-muted"> -
                            <?=$document->document_year ?></small>
                        </h3>
                        <h6 class="card-subtitle text-muted">
                          <?= $document->document_notes ?>
                        </h6>
                      </div><!-- /grid column -->
                      <!-- /grid column -->
                      <div class="col-auto">
                        <?php if(!empty($document->document_file)): ?>
                        <a title="Download File" class="btn btn-sm btn-primary" href="<?=base_url('document/download/documentfile/'.$document->document_file) ?>"><i class="fa fa-download"></i><span class="sr-only">Download</span></a>
                        <?php endif ?>
                        <?php if(!empty($document->document_file_link)): ?>
                        <a title="Kunjungi Link" target="_blank" class="btn btn-sm btn-primary" href="<?=$document->document_file_link ?>"><i class="fa fa-external-link-alt"></i><span class="sr-only">Download</span></a>
                        <?php endif ?>
                        <a title="Edit" href="<?= base_url('document/edit/'.$document->document_id.'') ?>" class="btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i><span class="sr-only">Edit</span>
                        </a>
                        <button title="Hapus" type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalhapus-<?= $document->document_id ?>"><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
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
<script type="text/javascript">
  $(document).ready(function () {
    $("#filter").select2({
      placeholder: '-- Filter tahun --',
      allowClear: true
    });
  });
</script>