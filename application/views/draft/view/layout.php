  <?php $ceklevel = $this->session->userdata('level'); ?>
<!-- .card -->
  <section id="progress-layout" class="card">
    <!-- .card-header -->
    <header class="card-header">
      <!-- .d-flex -->
      <div class="d-flex align-items-center">
        <span class="mr-auto">Layout</span>
        <!-- .card-header-control -->
        <div class="card-header-control">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <!-- .tombol add -->
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#pilihlayouter">Pilih Layouter</button>
          <!-- /.tombol add -->
          <?php endif ?>
        </div>
        <!-- /.card-header-control -->
      </div>
      <!-- /.d-flex -->
    </header>
    <div class="list-group list-group-flush list-group-bordered">
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal masuk</span>
        <strong><?= konversiTanggal($input->layout_start_deadline) ?></strong>
      </div>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal jadi</span>
        <strong><?= konversiTanggal($input->layout_end_deadline) ?></strong>
      </div>
      <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Layouter</span>
        <strong>
          <?php if ($layouters) {
            foreach ($layouters as $layouter){
              echo '<span class="badge badge-info p-1">'.$layouter->username.'</span> ';
            }
          }
          ?>
        </strong>
      </div>
      <?php endif ?>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Status</span>
        <strong></strong>
      </div>
      <hr class="m-0">
    </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example">
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
        <button class="btn btn-success"><i class="fa fa-check"></i></button>   
        <?php endif ?>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#layout">Lihat Detail</button>
        <!-- modal -->
        <div class="modal fade" id="layout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Layout</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <button type="button" class="btn btn-secondary"><i class="fa fa-download"></i> Download File</button>
                <button type="button" class="btn btn-secondary"><i class="fa fa-upload"></i> Upload File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cl" class="font-weight-bold">Catatan Layout</label>
                      <?php 
                      $optionscl = array(
                          'name' => 'review_notes',
                          'class'=> 'form-control',
                          'id'  => 'cl',
                          'rows' => '6',
                          'value'=> $input->layout_notes
                      );
                      if($ceklevel!='layouter'){
                        echo '<div class="font-italic">'.nl2br($input->layout_notes).'</div>';
                      }else{
                        echo form_textarea($optionscl);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="clp" class="font-weight-bold">Catatan Penulis</label>
                      <?php 
                      $optionsclp = array(
                          'name' => 'author_review_notes',
                          'class'=> 'form-control',
                          'id'  => 'clp',
                          'rows' => '6',
                          'value'=> $input->author_layout_notes
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->author_layout_notes).'</div>';
                      }else{
                        echo form_textarea($optionsclp);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
                <form>
                <!-- /.form -->
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      <!-- modal -->
        <div class="modal fade" id="pilihlayouter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Pilih Layouter </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                     <!-- .form-group -->
                      <div class="form-group" id="form-layouter">
                        <label for="sel1">Layouter</label>
                        <?= form_dropdown('layouter', getDropdownListLayouter('user', ['user_id', 'username']), '', 'id="pilih_layouter" class="form-control custom-select d-block"') ?>
                      </div>
                      <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
                  <div class="d-flex">
                    <button class="btn btn-primary ml-auto" type="submit" id="btn-pilih-layouter">Pilih</button>
                  </div>
                  <hr>
                  <div id="reload-layouter">
                    <?php if ($layouters):?>
                    <!-- .table-responsive -->
                      <div class="table-responsive">
                        <!-- .table -->
                        <table class="table table-bordered mb-0">
                          <!-- tbody -->
                          <tbody>
                            <?php foreach($layouters as $layouter): ?>
                            <!-- tr -->
                            <tr>
                              <td class="align-middle"><?= $layouter->username ?></td>
                              <td class="align-middle text-right" width="20px">
                                <button href="javascript" class="btn btn-sm btn-danger delete-layouter" data="<?= $layouter->responsibility_id ?>">
                                  <i class="fa fa-trash-alt"></i>
                                  <span class="sr-only">Delete</span>
                                </button>
                              </td>
                            </tr>
                            <!-- /tr -->
                            <?php endforeach ?>
                          </tbody>
                          <!-- /tbody -->
                        </table>
                        <!-- /.table -->
                      </div>
                      <!-- /.table-responsive -->
                  <?php else: ?>
                      <p>Layouter belum dipilih</p>
                  <?php endif ?>
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              </form>
              <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->