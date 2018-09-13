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
        <li class="breadcrumb-item active">
          <a class="text-muted">Unit Kerja</a>
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
      <div class="col-md-6">
        <!-- .card -->
        <section class="card card-fluid">
            <!-- .card-header -->
          <header class="card-header">
            <!-- .d-flex -->
            <div class="d-flex align-items-center">
              <span class="mr-auto">Tabel Unit Kerja</span>
              <!-- .card-header-control -->
              <div class="card-header-control">
                <!-- .tombol add -->
                <a href="<?=base_url('workunit/add') ?>" class="btn btn-primary btn-sm">Tambah Unit Kerja</a>
                <!-- /.tombol add -->
              </div>
              <!-- /.card-header-control -->
            </div>
            <!-- /.d-flex -->
          </header>
            <!-- /.card-header -->
           <!-- .card-body -->
          <div class="card-body p-0">
            <!-- .table-responsive -->
              <?php if ($work_units):?>
              <div class="table-responsive">
                <!-- .table -->
                <table class="table">
                  <!-- thead -->
                  <thead>
                    <tr>
                      <th scope="col" class="pl-4">No</th>
                      <th scope="col">Unit Kerja</th>
                      <th style="width:100px; min-width:100px;"> &nbsp; </th>
                    </tr>
                  </thead>
                  <!-- /thead -->
                  <!-- tbody -->
                  <tbody>
                    <?php foreach($work_units as $work_unit): ?>
                    <!-- tr -->
                    <tr>
                      <td class="align-middle pl-4"><?= ++$i ?></td>
                      <td class="align-middle"><?= $work_unit->work_unit_name ?></td>
                      <td class="align-middle text-right">
                        <a href="<?= base_url('work_unit/edit/'.$work_unit->work_unit_id.'') ?>" class="btn btn-sm btn-secondary">
                          <i class="fa fa-pencil-alt"></i>
                          <span class="sr-only">Edit</span>
                        </a>
                        <a href="<?= base_url('work_unit/delete/'.$work_unit->work_unit_id.'') ?>" class="btn btn-sm btn-danger">
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
                  <p>Author data were not available</p>
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