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
        <li class="breadcrumb-item active">
          <a class="text-muted">Lembar Kerja</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Lembar Kerja </h1> 
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
              <span class="mr-auto">Tabel Lembar Kerja <span class="text-muted">(<?=$total ?>)</span></span>
              <!-- .card-header-control -->
              <div class="card-header-control">
                <!-- .tombol add -->
                <a href="<?=base_url('worksheet/add') ?>" class="btn btn-primary btn-sm">Tambah Lembar Kerja</a>
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
              <?= form_open('worksheet/search', ['method' => 'GET']) ?>
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
            <?php if ($worksheets):?>
            <div class="table-responsive">
              <!-- .table -->
              <table class="table nowrap">
                <!-- thead -->
                <thead>
                  <tr>
                    <th scope="col" class="pl-4">No</th>
                    <th scope="col">Judul Draft</th>
                    <th scope="col">Nomor Lembar Kerja</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">Status</th>
                    <th scope="col">PIC</th>
                    <th style="width:100px; min-width:100px;"> &nbsp; </th>
                  </tr>
                </thead>
                <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($worksheets as $worksheet): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle pl-4"><?= ++$i ?></td>
                    <td class="align-middle"><a href="<?= base_url('draft/view/'.$worksheet->draft_id) ?>"><?= $worksheet->draft_title ?></a></td>
                    <td class="align-middle"><?= $worksheet->worksheet_num ?></td>
                    <td class="align-middle"><?= $worksheet->is_reprint == 'y' ? 'Cetak Ulang' : 'Baru' ?></td>
                    <td class="align-middle"><?=
                            $status = "";
                            if ($worksheet->worksheet_status > 0) {
                                if ($worksheet->worksheet_status == 1) {
                                    $status = "Approved";
                                } else {
                                    $status = "Rejected";
                                }
                            } else {
                                $status = "Waiting";
                            }
                            echo $status;
                            ?>        
                    </td>
                    <td class="align-middle"><?= $worksheet->worksheet_pic ?></td>
                    <td class="align-middle text-right">

                      <a href="<?= base_url('worksheet/action/'.$worksheet->worksheet_id.'/1') ?>" class="btn btn-sm btn-success">
                        <i class="fa fa-check"></i>
                        <span class="sr-only">Setuju</span>
                      </a>
                       <a href="<?= base_url('worksheet/action/'.$worksheet->worksheet_id.'/2') ?>" class="btn btn-sm btn-danger">
                        <i class="fa fa-ban"></i>
                        <span class="sr-only">Tolak</span>
                      </a>
                      <span>-</span>
                      <a href="<?= base_url('worksheet/edit/'.$worksheet->worksheet_id.'') ?>" class="btn btn-sm btn-secondary">
                        <i class="fa fa-pencil-alt"></i>
                        <span class="sr-only">Edit</span>
                      </a>
                      <button type="button" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#modalhapus-<?= $worksheet->worksheet_id ?>"><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                    </td>
                  </tr>
                  <!-- /tr -->
                  <!-- Alert Danger Modal -->
                  <div class="modal modal-alert fade" id="modalhapus-<?= $worksheet->worksheet_id ?>" tabindex="-1" role="dialog" aria-labelledby="modalhapus" aria-hidden="true">
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
                          <p>Apakah anda yakin akan menghapus lembar kerja <span class="font-weight-bold"><?= $worksheet->worksheet_num ?></span>?</p>
                        </div>
                        <!-- /.modal-body -->
                        <!-- .modal-footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" onclick="location.href='<?= base_url('worksheet/delete/'.$worksheet->worksheet_id.'') ?>'" data-dismiss="modal">Hapus</button>
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
        </section>
        <!-- /.card -->
      </div>
      <!-- /grid column -->
    </div>
    <!-- /grid row -->
  </div>
  <!-- /.page-section -->

