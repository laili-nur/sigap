  <?php $ceklevel = $this->session->userdata('level'); ?>
<!-- .card -->
  <section id="progress-edit" class="card">
    <!-- .card-header -->
    <header class="card-header">
      <!-- .d-flex -->
      <div class="d-flex align-items-center">
        <span class="mr-auto">Edit</span>
        <!-- .card-header-control -->
        <div class="card-header-control">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <!-- .tombol add -->
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#piliheditor">Pilih Editor</button>
          <!-- /.tombol add -->
          <?php endif ?>
        </div>
        <!-- /.card-header-control -->
      </div>
      <!-- /.d-flex -->
    </header>
    <div class="list-group list-group-flush list-group-bordered" id="label-editor">
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal masuk</span>
        <strong><?= konversiTanggal($input->edit_start_deadline) ?></strong>
      </div>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal jadi</span>
        <strong><?= konversiTanggal($input->edit_end_deadline) ?></strong>
      </div>
      <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer' ): ?>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Editor</span>
        <div>
          <?php if ($editors) {
            foreach ($editors as $editor){
              echo '<span class="badge badge-info p-1">'.$editor->username.'</span> ';
            }
          }
          ?>
        </div>
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
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#edit">Lihat Detail</button>
        <!-- modal -->
        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Edit</h5>
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
                      <label for="ce" class="font-weight-bold">Catatan Editor</label>
                      <?php 
                      $optionsce = array(
                          'name' => 'review_notes',
                          'class'=> 'form-control',
                          'id'  => 'ce',
                          'rows' => '6',
                          'value'=> $input->edit_notes
                      );
                      if($ceklevel!='editor'){
                        echo '<div class="font-italic">'.nl2br($input->edit_notes).'</div>';
                      }else{
                        echo form_textarea($optionsce);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cep" class="font-weight-bold">Catatan Penulis</label>
                      <?php 
                      $optionscep = array(
                          'name' => 'author_review_notes',
                          'class'=> 'form-control',
                          'id'  => 'cep',
                          'rows' => '6',
                          'value'=> $input->author_edit_notes
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->author_edit_notes).'</div>';
                      }else{
                        echo form_textarea($optionscep);
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
        <div class="modal fade" id="piliheditor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Pilih Editor </h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                     <!-- .form-group -->
                      <div class="form-group" id="form-editor">
                        <label for="pilih_editor">Editor</label>
                        <?= form_dropdown('editor', getDropdownListEditor('user', ['user_id', 'username']), '', 'id="pilih_editor" class="form-control custom-select d-block"') ?>
                      </div>
                      <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
                  <div class="d-flex">
                    <button class="btn btn-primary ml-auto" type="submit" id="btn-pilih-editor">Pilih</button>
                  </div>
                  
                  <hr>
                  <div id="reload-editor">
                    <?php if ($editors):?>
                    <!-- .table-responsive -->
                      <div class="table-responsive">
                        <!-- .table -->
                        <table class="table table-bordered mb-0">
                          <!-- tbody -->
                          <tbody>
                            <?php foreach($editors as $editor): ?>
                            <!-- tr -->
                            <tr>
                              <td class="align-middle"><?= $editor->username ?></td>
                              <td class="align-middle text-right" width="20px">
                                <button href="javascript" class="btn btn-sm btn-danger delete-editor" data="<?= $editor->responsibility_id ?>">
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
                      <p>Editor belum dipilih</p>
                  <?php endif ?>
                  </div>
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