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
              <span class="mr-auto">Tabel User <span class="badge badge-info"><?=$total ?></span></span>
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
                        <td class="align-middle"><?= ucwords(str_replace('_', ' ', $user->level)) ?></td>
                        <td class="align-middle"><?= $user->is_blocked == 'n' ? 'Not Blocked' : 'Blocked' ?></td>
                        <td class="align-middle text-right">
                          <a href="<?= base_url('user/edit/'.$user->user_id.'') ?>" class="btn btn-sm btn-secondary">
                            <i class="fa fa-pencil-alt"></i>
                            <span class="sr-only">Edit</span>
                          </a>
                          <?php if($user->username != 'superadmin') : ?>
                          <button type="button" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#modalhapus-<?= $user->user_id ?>" ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                          <?php endif ?>
                        </td>
                      </tr>
                      <!-- /tr -->
                      <!-- Alert Danger Modal -->
                      <div class="modal modal-alert fade" id="modalhapus-<?= $user->user_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
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
                              <p>Apakah anda yakin akan menghapus user <span class="font-weight-bold"><?= $user->username ?></span>?</p>
                            </div>
                            <!-- /.modal-body -->
                            <!-- .modal-footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('user/delete/'.$user->user_id.'') ?>'" data-dismiss="modal">Hapus</button>
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
                    <p>Author data were not available</p>
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