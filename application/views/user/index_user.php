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
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted">User</a>
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
              <span class="mr-auto">Tabel User</span>
              <!-- .card-header-control -->
              <div class="card-header-control">
                <!-- .tombol add -->
                <a href="<?=base_url('user/add') ?>" class="btn btn-primary btn-sm">Tambah User</a>
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
                <?= form_open('user/search', ['method' => 'GET']) ?>
                <div class="input-group input-group-alt">
                  <?= form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Enter Username', 'class' => 'form-control']) ?>
                  <div class="input-group-append">
                     <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
                  </div>
                <?= form_close() ?>
                </div>
                <!-- /.input-group -->
            </div>
            <div class="tab-pane fade active show" id="card-tabel1">
                <!-- .table-responsive -->
                <?php if ($users):?>
                <div class="table-responsive">
                  <!-- .table -->
                  <table class="table">
                    <!-- thead -->
                    <thead>
                      <tr>
                       <th scope="col" class="pl-4">No</th>
                        <th scope="col">Username</th>
                        <th scope="col">Level</th>
                        <th scope="col">Status</th>
                        <th style="width:100px; min-width:100px;"> &nbsp; </th>
                      </tr>
                    </thead>
                    <!-- /thead -->
                    <!-- tbody -->
                    <tbody>
                      <?php foreach($users as $user): ?>
                      <!-- tr -->
                      <tr>
                        <td class="align-middle pl-4"><?= ++$i ?></td>
                        <td class="align-middle"><?= $user->username ?></td>
                        <td class="align-middle"><?= $user->level ?></td>
                        <td class="align-middle"><?= $user->is_blocked == 'n' ? 'Not Blocked' : 'Blocked' ?></td>
                        <td class="align-middle text-right">
                          <a href="<?= base_url('user/edit/'.$user->user_id.'') ?>" class="btn btn-sm btn-secondary">
                            <i class="fa fa-pencil-alt"></i>
                            <span class="sr-only">Edit</span>
                          </a>
                          <a href="<?= base_url('user/delete/'.$user->user_id.'') ?>" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash-alt"></i>
                            <span class="sr-only">Edit</span>
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