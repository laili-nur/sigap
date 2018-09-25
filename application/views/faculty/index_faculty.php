<?php $i = 0 ?>
<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
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
                    <a href="<?= base_url('faculty/delete/'.$faculty->faculty_id.'') ?>" class="btn btn-sm btn-danger">
                      <i class="fa fa-trash-alt"></i>
                      <span class="sr-only">Delete</span>
                    </a>
                  </td>
                </tr>
                <!-- /tr -->
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