<?php $ceklevel = $this->session->userdata('level'); ?>
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
          <a href="<?=base_url()?>">Penerbitan</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted">Buku</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Buku </h1> 
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
              <span class="mr-auto">Tabel Buku <span class="badge badge-info"><?=$total ?></span></span>
              <!-- .card-header-control -->
              <div class="card-header-control">
                <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                <!-- .tombol add -->
                <a href="<?=base_url('book/add') ?>" class="btn btn-primary btn-sm">Tambah Buku</a>
                <!-- /.tombol add -->
              <?php endif ?>
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
              <?= form_open('book/search', ['method' => 'GET']) ?>
              <div class="input-group input-group-alt">
                <?= form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Enter Category, Theme, or Title', 'class' => 'form-control']) ?>
                <div class="input-group-append">
                   <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
                </div>
              <?= form_close() ?>
              </div>
              <!-- /.input-group -->
            </div>
            <!-- .table-responsive -->
            <?php if ($books):?>
            <div class="table-responsive">
              <!-- .table -->
              <table class="table table-striped">
                <!-- thead -->
                <thead>
                  <tr>
                    <th scope="col" class="pl-4">No</th>
                    <th scope="col">Judul Buku</th>
                    <th scope="col">Edisi</th>
                    <th scope="col">Copy</th>
                    <th scope="col">Status</th>
                    <th scope="col">Hak Cipta</th>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <th style="width:100px; min-width:100px;"> &nbsp; </th>
                    <?php endif ?>
                  </tr>
                </thead>
                <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($books as $book): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle pl-4"><?= ++$i ?></td>
                    <td class="align-middle"><a href="<?= base_url('book/view/'.$book->book_id) ?>"><?= $book->book_title ?></a></td>
                    <td class="align-middle"><?= $book->book_edition ?></td>
                    <td class="align-middle"><?= $book->copies_num ?></td>
                    <td class="align-middle"><?= $book->is_reprint == 'y' ? 'Cetak Ulang' : 'Baru' ?></td>
                    <td class="align-middle">
                      <?= $book->status_hak_cipta == '2' ? 'Sudah jadi' : '' ?>
                      <?= $book->status_hak_cipta == '1' ? 'Dalam Proses' : '' ?>
                    </td>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <td style="min-width: 130px" class="align-middle text-right">
                      <a title="Edit Hak Cipta" href="<?= base_url('book/edit_hakcipta/'.$book->book_id.'') ?>" class="btn btn-sm btn-secondary">
                        <i class="fa fa-file-alt"></i>
                      </a>
                      <a title="Edit Buku" href="<?= base_url('book/edit/'.$book->book_id.'') ?>" class="btn btn-sm btn-secondary">
                        <i class="fa fa-pencil-alt"></i>
                      </a>
                      <button title="Delete" type="button" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#modalhapus-<?= $book->book_id ?>"><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                    </td>
                    <?php endif ?>
                  </tr>
                  <!-- /tr -->
                  <!-- Alert Danger Modal -->
                  <div class="modal modal-alert fade" id="modalhapus-<?= $book->book_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
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
                          <p>Apakah anda yakin akan menghapus buku <span class="font-weight-bold"><?= $book->book_title ?></span>?</p>
                        </div>
                        <!-- /.modal-body -->
                        <!-- .modal-footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('book/delete/'.$book->book_id.'') ?>'" data-dismiss="modal">Hapus</button>
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
                </tbody>
                <!-- /tbody -->
              </table>
              <!-- /.table -->
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
          <!-- /.card-body -->
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <?php endif ?>
        </section>
        <!-- /.card -->
      </div>
      <!-- /grid column -->
    </div>
    <!-- /grid row -->
  </div>
  <!-- /.page-section -->
