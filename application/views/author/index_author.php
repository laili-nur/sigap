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
        <a class="text-muted">Penulis</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Penulis </h1> 
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
        <header class="card-header ">
          <!-- .d-flex -->
          <div class="d-flex align-items-center">
            <span class="mr-auto">Tabel Penulis <span class="badge badge-info"><?=$total ?></span></span>
            <!-- .card-header-control -->
            <div class="card-header-control">
              <!-- .tombol add -->
              <a href="<?=base_url('author/add') ?>" class="btn btn-primary btn-sm">Tambah Penulis</a>
              <!-- /.tombol add -->
            </div>
            <!-- /.card-header-control -->
          </div>
          <!-- /.d-flex -->
        </header>
        <!-- /.card-header -->
        <!-- .card-body -->
        <div class="card-body p-0">
          <div class="tab-pane fade active show" id="card-tabel1">
            <div class="p-3">
              <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h5>Info</h5> 
                <p class="m-0">Klik tombol <button class="btn btn-sm btn-primary"><i class="fa fa-user-plus"></i></button> untuk menyalin data penulis yang terpilih untuk dijadikan reviewer. <strong>Pastikan author memiliki akun agar dapat disalin.</strong></p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- .input-group -->
              <?= form_open('author/search', ['method' => 'GET']) ?>
              <div class="input-group input-group-alt">
                <?= form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Enter Work Unit, Institute, NIP, Username, or Name', 'class' => 'form-control']) ?>
                <div class="input-group-append">
                 <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
               </div>
               <?= form_close() ?>
             </div>
             <!-- /.input-group -->
           </div>
           <!-- .table-responsive -->
           <?php if ($authors):?>
            <div class="table-responsive">
              <!-- .table -->
              <table class="table nowrap">
                <!-- thead -->
                <thead>
                  <tr>
                    <th scope="col" class="pl-4">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">NIP</th>
                    <th scope="col">Unit Kerja</th>
                    <th scope="col">Institusi</th>
                    <th style="width:100px; min-width:100px;"> &nbsp; </th>
                  </tr>
                </thead>
                <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($authors as $author): ?>
                    <!-- tr -->
                    <tr>
                      <td class="align-middle pl-4"><?= ++$i ?></td>
                      <td class="align-middle"><a href="<?= base_url('author/profil/'.$author->author_id) ?>"><?= $author->author_degree_front ?> <?= ucwords($author->author_name) ?> <?= $author->author_degree_back ?></a></td>
                      <td class="align-middle"><?= $author->username ?></td>
                      <td class="align-middle"><?= $author->author_nip ?></td>
                      <td class="align-middle"><?= $author->work_unit_name ?></td>
                      <td class="align-middle"><?= $author->institute_name ?></td>
                      <td class="align-middle text-right">    

                        <button title="Jadikan Reviewer" onclick="location.href='<?= base_url('author/copyToReviewer/' . $author->user_id . '/' . $author->author_nip . '/' . $author->author_name) ?>'"  class="btn btn-sm btn-primary" <?=(!$author->user_id)? 'disabled' : '' ?>>
                          <i class="fa fa-user-plus"></i>
                          <span class="sr-only">Jadikan reviewer</span>
                        </button>
                        <a title="Edit" href="<?= base_url('author/edit/'.$author->author_id.'') ?>" class="btn btn-sm btn-secondary">
                          <i class="fa fa-pencil-alt"></i>
                          <span class="sr-only">Edit</span>
                        </a>
                        <button title="Delete" type="button" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#modalhapus-<?= $author->author_id ?>"><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                      </td>
                    </tr>
                    <!-- /tr -->
                    <!-- Alert Danger Modal -->
                    <div class="modal modal-alert fade" id="modalhapus-<?= $author->author_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
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
                            <p>Apakah anda yakin akan menghapus penulis <span class="font-weight-bold"><?= $author->author_name ?></span>?</p>
                          </div>
                          <!-- /.modal-body -->
                          <!-- .modal-footer -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('author/delete/'.$author->author_id.'') ?>'" data-dismiss="modal">Hapus</button>
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
          </div>
          <!-- .card-footer -->
          <footer class="card-footer ">
            <div class="card-footer-content">
              <a href="<?=base_url('workunit') ?>" class="btn btn-secondary mr-2">Unit Kerja</a>
              <a href="<?=base_url('institute') ?>" class="btn btn-secondary mr-2">Institusi</a>
            </div>
          </footer>
          <!-- /.card-footer -->
          <!-- /.card-body -->
        </section>
        <!-- /.card -->
      </div>
      <!-- /grid column -->
    </div>
    <!-- /grid row -->
  </div>
  <!-- /.page-section -->
