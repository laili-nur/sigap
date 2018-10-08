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
        <a class="text-muted">Fakultas</a>
      </li>
    </ol>
  </nav> 
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <div class="row">
    <div class="col-md-6">
    <!-- .card -->
      <section class="card card-fluid">
          <!-- .card-header -->
        <header class="card-header">
          <!-- .d-flex -->
          <div class="d-flex align-items-center">
            <span class="mr-auto">Tabel Fakultas</span>
            <!-- .card-header-control -->
            <div class="card-header-control">
              <!-- .tombol add -->
              <a href="<?=base_url('faculty/add') ?>" class="btn btn-primary btn-sm">Tambah Faklultas</a>
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
          <?php if ($faculties):?>
          <div class="table-responsive">
            <!-- .table -->
            <table class="table">
              <!-- thead -->
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Fakultas</th>
                  <th style="width:100px; min-width:100px;"> &nbsp; </th>
                </tr>
              </thead>
              <!-- /thead -->
              <!-- tbody -->
              <tbody>
                <?php foreach($faculties as $faculty): ?>
                <!-- tr -->
                <tr>
                  <td class="align-middle"><?= ++$i ?></td>
                  <td class="align-middle"><?= $faculty->faculty_name ?></td>
                  <td class="align-middle text-right">
                    <a href="<?= base_url('faculty/edit/'.$faculty->faculty_id.'') ?>" class="btn btn-sm btn-secondary">
                      <i class="fa fa-pencil-alt"></i>
                      <span class="sr-only">Edit</span>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#modalhapus-<?= $faculty->faculty_id ?>"><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                  </td>
                </tr>
                <!-- /tr -->
                <!-- Alert Danger Modal -->
                <div class="modal modal-alert fade" id="modalhapus-<?= $faculty->faculty_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
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
                        <p>Apakah anda yakin akan menghapus fakultas <span class="font-weight-bold"><?= $faculty->faculty_name ?></span>?</p>
                      </div>
                      <!-- /.modal-body -->
                      <!-- .modal-footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('faculty/delete/'.$faculty->faculty_id.'') ?>'" data-dismiss="modal">Hapus</button>
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
  </div>
  
</div>
<!-- /.page-section -->