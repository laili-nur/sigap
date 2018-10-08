<?php $i = 0 ?>
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
        <a href="<?=base_url('draft')?>">Draft</a>
      </li>
      <li class="breadcrumb-item active">
        <a class="text-muted">Kategori</a>
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
              <span class="mr-auto">Tabel Kategori</span>
              <!-- .card-header-control -->
              <div class="card-header-control">
                <!-- .tombol add -->
                <a href="<?=base_url('category/add') ?>" class="btn btn-primary btn-sm">Tambah Kategori</a>
                <!-- /.tombol add -->
              </div>
              <!-- /.card-header-control -->
            </div>
            <!-- /.d-flex -->
          </header>
            <!-- /.card-header -->
           <!-- .card-body -->
          <div class="card-body">
            <!-- .table-responsive -->
                <?php if ($categories):?>
                <div class="table-responsive">
                  <!-- .table -->
                  <table class="table nowrap">
                    <!-- thead -->
                    <thead>
                      <tr>
                        <th scope="col" class="pl-4">No</th>
                        <th scope="col">Jenis Kategori</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Tanggal Buka</th>
                        <th scope="col">Tanggal Tutup</th>
                        <th scope="col">Status</th>
                        <th style="width:100px; min-width:100px;"> &nbsp; </th>
                      </tr>
                    </thead>
                    <!-- /thead -->
                    <!-- tbody -->
                    <tbody>
                      <?php foreach($categories as $category): ?>
                      <!-- tr -->
                      <tr>
                        <td class="align-middle pl-4"><?= ++$i ?></td>
                        <td class="align-middle"><?= $category->category_name ?></td>
                        <td class="align-middle"><?= $category->category_year ?></td>
                        <td class="align-middle"><?= $category->date_open ?></td>
                        <td class="align-middle"><?= $category->date_close ?></td>
                        <td class="align-middle"><?= $category->category_status == 'y' ? 'Active' : 'Not Active' ?></td>
                        <td class="align-middle text-right">
                          <a href="<?= base_url('category/edit/'.$category->category_id.'') ?>" class="btn btn-sm btn-secondary">
                            <i class="fa fa-pencil-alt"></i>
                            <span class="sr-only">Edit</span>
                          </a>
                          <button type="button" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#modalhapus-<?= $category->category_id ?>" ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                        </td>
                      </tr>
                      <!-- /tr -->
                      <!-- Alert Danger Modal -->
                      <div class="modal modal-alert fade" id="modalhapus-<?= $category->category_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
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
                              <p>Apakah anda yakin akan menghapus kategori <span class="font-weight-bold"><?= $category->category_name ?></span>?</p>
                            </div>
                            <!-- /.modal-body -->
                            <!-- .modal-footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('category/delete/'.$category->category_id.'') ?>'" data-dismiss="modal">Hapus</button>
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