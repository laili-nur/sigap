  <?php $ceklevel = $this->session->userdata('level'); ?>
<!-- .card -->
  <section id="progress-edit" class="card">
    <!-- .card-header -->
    <header class="card-header">
      <!-- .d-flex -->
      <div class="d-flex align-items-center">
        <span class="mr-auto">Editorial</span>
        <!-- .card-header-control -->
        <div class="card-header-control">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <!-- .tombol add -->
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#piliheditor">Pilih Editor</button>
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#edit_deadline">Atur Deadline</button>
          <!-- /.tombol add -->
          <?php endif ?>
        </div>
        <!-- /.card-header-control -->
      </div>
      <!-- /.d-flex -->
    </header>
    <div class="list-group list-group-flush list-group-bordered" id="list-group-edit">
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal masuk</span>
        <strong><?= konversiTanggal($input->edit_start_date) ?></strong>
      </div>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal jadi</span>
        <strong><?= konversiTanggal($input->edit_end_date) ?></strong>
      </div>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Deadline</span>
        <strong><?= konversiTanggal($input->edit_deadline) ?></strong>
      </div>
      <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer' ): ?>
      <div class="list-group-item justify-content-between" id="reloadeditor">
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
        <?php if($input->is_edit == 'y'): ?>
        <strong>Editorial Selesai</strong>
        <?php elseif($input->is_edit == 'n' and $input->draft_status == 'Draft Ditolak'): ?>
        <strong>Draft Ditolak</strong>
        <?php else: ?>
          -
        <?php endif ?>
      </div>
      <hr class="m-0">
    </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example">
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
        <button class="btn btn-secondary" style="width:50px" data-toggle="modal" data-target="#edit_aksi"><i class="fa fa-thumbs-up"></i></button>
        <?php endif ?>   
        <button type="button" class="btn <?=($input->edit_notes!='' || $input->edit_notes_author!='')? 'btn-success' : 'btn-outline-success' ?>" data-toggle="modal" data-target="#edit">Tanggapan Editorial <?=($input->edit_notes!='' || $input->edit_notes_author!='')? '<i class="fa fa-check"></i>' : '' ?></button>
      </div>
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
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/edit_file', 'novalidate'); ?>
                  <p class="font-weight-bold">UPLOAD</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="edit_file">File Review</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('edit_file','','class="custom-file-input"') ?> 
                          <label class="custom-file-label" for="edit_file">Choose file</label>
                          <div class="invalid-feedback">Field is required</div>
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit" value="Submit" id="btn-upload-edit"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                      </div>
                      <!-- /.input-group -->
                    </div>
                    <!-- /.form-group -->
                <?= form_close(); ?>
                <hr class="my-3">
                <p>Last Upload: <?=konversiTanggal($input->edit_upload_date) ?></p>
                <?=(!empty($input->edit_file))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->edit_file.'" href="'.base_url('draftfile/'.$input->edit_file).'" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '' ?>
                <hr class="my-3">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id,'id="formedit"') ?>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="ce" class="font-weight-bold">Catatan Editor</label>
                      <?php 
                      $optionsce = array(
                          'name' => 'edit_notes',
                          'class'=> 'form-control summernote-basic',
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
                          'name' => 'edit_notes_author',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'cep',
                          'rows' => '6',
                          'value'=> $input->edit_notes_author
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->edit_notes_author).'</div>';
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
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-edit">Submit</button>
                <?= form_close(); ?>
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
                <?=form_open('', ''); ?>
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
                  <p class="font-weight-bold">Editor Terpilih</p>
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
              <?= form_close(); ?>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
      <!-- modal deadline -->
          <div class="modal fade" id="edit_deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <!-- .modal-dialog -->
            <div class="modal-dialog" role="document">
              <!-- .modal-content -->
              <div class="modal-content">
                <!-- .modal-header -->
                <div class="modal-header">
                  <h5 class="modal-title">Deadline Editorial</h5>
                </div>
                <!-- /.modal-header -->
                <!-- .modal-body -->
                <div class="modal-body">
                  <!-- .form -->
                  <?= form_open('draft/ubahnotes/'.$input->draft_id) ?>
                    <!-- .fieldset -->
                    <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <!-- <label for="edit_deadline">Deadline Edit</label> -->
                      <div>
                        <?= form_input('edit_deadline', $input->edit_deadline, 'class="form-control mydate_modal d-none" id="edit_deadline" required=""') ?>
                      </div>
                        <div class="invalid-feedback">Harap diisi</div>
                        <?= form_error('edit_deadline') ?>
                    </div>
                    <!-- /.form-group -->
                    </fieldset>
                    <!-- /.fieldset -->
                </div>
                <!-- /.modal-body -->
                <!-- .modal-footer -->
                <div class="modal-footer">
                  <button class="btn btn-primary" type="submit" id="btn-edit-deadline">Pilih</button>
                  <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
                <!-- /.modal-footer -->
                <?=form_close(); ?>
                  <!-- /.form -->
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
        <!-- /.modal -->
        <!-- modal deadline -->
        <div class="modal fade" id="edit_aksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title">Aksi</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id) ?>
                  <!-- .fieldset -->
                  <fieldset>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="edit_status" class="font-weight-bold">Catatan Admin</label>
                      <?php 
                      $hidden_date = array(
                          'type'  => 'hidden',
                          'id'    => 'edit_end_date',
                          'value' => date('Y-m-d H:i:s')
                      );
                      echo form_input($hidden_date);
                      $edit_status = array(
                          'name' => 'edit_status',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'crp2',
                          'rows' => '6',
                          'value'=> $input->edit_status
                      );
                      if($ceklevel!='superadmin'){
                        echo '<div class="font-italic">'.nl2br($input->edit_status).'</div>';
                      }else{
                        echo form_textarea($edit_status);
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
                <button class="btn btn-success" type="submit" id="edit-setuju" value="7">Setuju</button>
                <button class="btn btn-danger" type="submit" id="edit-tolak" value="99">Tolak</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
              </div>
              <!-- /.modal-footer -->
              <?=form_close(); ?>
                <!-- /.form -->
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <!-- /.modal -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->

  <script>
    $(document).ready(function(){
      $('#btn-submit-edit').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let ce=$('#ce').val();
        let cep=$('#cep').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            edit_notes : ce,
            edit_notes_author : cep
          },
          success :function(data){
            let datax = JSON.parse(data);
            console.log(datax)
            $this.removeAttr("disabled").html("Submit");
            if(datax.status == true){
              toastr_view('111');
            }else{
              toastr_view('000');
            }
            $('#list-group-edit').load(' #list-group-edit');
          }
        });
        return false;
      });

      $('#edit-setuju').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let edit_status=$('[name=edit_status]').val();
        let action=$('#edit-setuju').val();
        let end_date=$('#edit_end_date').val();
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              edit_status : edit_status,
              draft_status : action,
              edit_end_date : end_date,
              is_edit : 'y'
            },
            success :function(data){
              let datax = JSON.parse(data);
              console.log(datax);
              $this.removeAttr("disabled").html("Setuju");
              if(datax.status == true){
                toastr_view('111');
              }else{
                toastr_view('000');
              }
              $('#list-group-edit').load(' #list-group-edit');
            }
          });

          // $('#edit_aksi').modal('hide');
          // location.reload();
          return false;
      });

      $('#edit-tolak').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let edit_status=$('[name=edit_status]').val();
        let action=$('#edit-tolak').val();
        let end_date=$('#edit_end_date').val();

              console.log(end_date);
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              edit_status : edit_status,
              draft_status : action,
              edit_end_date : end_date,
              is_edit : 'n'
            },
            success :function(data){
              let datax = JSON.parse(data);
              console.log(datax);
              $this.removeAttr("disabled").html("Tolak");
              if(datax.status == true){
                toastr_view('111');
              }else{
                toastr_view('000');
              }
              $('#list-group-edit').load(' #list-group-edit');
            }
          });

          // $('#edit_aksi').modal('hide');
          // location.reload();
          return false;
      });

      

    })
  </script>