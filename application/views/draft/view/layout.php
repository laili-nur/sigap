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
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#layout_deadline">Atur Deadline</button>
          <!-- /.tombol add -->
          <?php endif ?>
        </div>
        <!-- /.card-header-control -->
      </div>
      <!-- /.d-flex -->
    </header>
    <div class="list-group list-group-flush list-group-bordered" id="list-group-layout">
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal masuk</span>
        <strong><?= konversiTanggal($input->layout_start_date) ?></strong>
      </div>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Tanggal jadi</span>
        <strong><?= konversiTanggal($input->layout_end_date) ?></strong>
      </div>
      <div class="list-group-item justify-content-between">
        <span class="text-muted">Deadline</span>
        <strong><?= konversiTanggal($input->layout_deadline) ?></strong>
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
        <strong><?=($input->is_layout == 'y')?'Layout Selesai': '-' ?></strong>
      </div>
      <hr class="m-0">
    </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example">
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
        <button class="btn btn-secondary" style="width:50px" data-toggle="modal" data-target="#layout_aksi"><i class="fa fa-thumbs-up"></i></button>
        <?php endif ?>
        <button type="button" class="btn <?=($input->layout_notes!='' || $input->layout_notes_author!='')? 'btn-success' : 'btn-outline-success' ?>" data-toggle="modal" data-target="#layout">Tanggapan Layout <?=($input->layout_notes!='' || $input->layout_notes_author!='')? '<i class="fa fa-check"></i>' : '' ?></button>
        <button type="button" class="btn <?=($input->cover_notes!='' || $input->cover_notes_author!='')? 'btn-success' : 'btn-outline-success' ?>" data-toggle="modal" data-target="#cover">Tanggapan Cover <?=($input->cover_notes!='' || $input->cover_notes_author!='')? '<i class="fa fa-check"></i>' : '' ?></button>
      </div>
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
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/layout_file', 'novalidate'); ?>
                  <p class="font-weight-bold">UPLOAD</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="layout_file">File Review</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('layout_file','','class="custom-file-input"') ?> 
                          <label class="custom-file-label" for="layout_file">Choose file</label>
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
                <p>Last Upload: <?=konversiTanggal($input->layout_upload_date) ?></p>
                <?=(!empty($input->layout_file))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->layout_file.'" href="'.base_url('draftfile/'.$input->layout_file).'" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '' ?>
                <hr class="my-3">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id,'id="formlayout"') ?>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cl" class="font-weight-bold">Catatan Layout</label>
                      <?php 
                      $optionscl = array(
                          'name' => 'layout_notes',
                          'class'=> 'form-control summernote-basic',
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
                      <label for="clp" class="font-weight-bold">Catatan Editor</label>
                      <?php 
                      $optionsclp = array(
                          'name' => 'layout_notes_author',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'clp',
                          'rows' => '6',
                          'value'=> $input->layout_notes_author
                      );
                      if($ceklevel!='editor'){
                        echo '<div class="font-italic">'.nl2br($input->layout_notes_author).'</div>';
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
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-layout">Submit</button>
                <?=form_close(); ?>
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
        <div class="modal fade" id="cover" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Desain Cover</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/cover_file', 'novalidate'); ?>
                  <p class="font-weight-bold">UPLOAD</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="cover_file">File Review</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('cover_file','','class="custom-file-input"') ?> 
                          <label class="custom-file-label" for="cover_file">Choose file</label>
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
                <p>Last Upload: <?=konversiTanggal($input->cover_upload_date) ?></p>
                <?=(!empty($input->cover_file))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->cover_file.'" href="'.base_url('draftfile/'.$input->cover_file).'" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '' ?>
                <hr class="my-3">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id,'id="formcover"') ?>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cc" class="font-weight-bold">Catatan Cover</label>
                      <?php 
                      $optionscc = array(
                          'name' => 'cover_notes',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'cc',
                          'rows' => '6',
                          'value'=> $input->cover_notes
                      );
                      if($ceklevel!='layouter'){
                        echo '<div class="font-italic">'.nl2br($input->cover_notes).'</div>';
                      }else{
                        echo form_textarea($optionscc);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="ccp" class="font-weight-bold">Catatan Editor</label>
                      <?php 
                      $optionsccp = array(
                          'name' => 'cover_notes_author',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'ccp',
                          'rows' => '6',
                          'value'=> $input->cover_notes_author
                      );
                      if($ceklevel!='editor'){
                        echo '<div class="font-italic">'.nl2br($input->cover_notes_author).'</div>';
                      }else{
                        echo form_textarea($optionsccp);
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
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-cover">Submit</button>
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
                <?=form_open('', ''); ?>
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
                  <p class="font-weight-bold">Layouter Terpilih</p>
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
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
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
        <div class="modal fade" id="layout_deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title">Deadline Layout</h5>
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
                    <!-- <label for="layout_deadline">Deadline Layout</label> -->
                    <div>
                      <?= form_input('layout_deadline', $input->layout_deadline, 'class="form-control mydate_modal d-none" id="layout_deadline" required=""') ?>
                    </div>
                      <div class="invalid-feedback">Harap diisi</div>
                      <?= form_error('layout_deadline') ?>
                  </div>
                  <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="btn-layout-deadline">Pilih</button>
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
        <div class="modal fade" id="layout_aksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <label for="layout_status" class="font-weight-bold">Catatan Admin</label>
                      <?php 
                      $hidden_date = array(
                          'type'  => 'hidden',
                          'id'    => 'layout_end_date',
                          'value' => date('Y-m-d H:i:s')
                      );
                      echo form_input($hidden_date);
                      $layout_status = array(
                          'name' => 'layout_status',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'crp2',
                          'rows' => '6',
                          'value'=> $input->layout_status
                      );
                      if($ceklevel!='superadmin'){
                        echo '<div class="font-italic">'.nl2br($input->layout_status).'</div>';
                      }else{
                        echo form_textarea($layout_status);
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
                <button class="btn btn-success" type="submit" id="layout-setuju" value="9">Setuju</button>
                <button class="btn btn-danger" type="submit" id="layout-tolak" value="99">Tolak</button>
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
      $('#btn-submit-layout').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let cl=$('#cl').val();
        let clp=$('#clp').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            layout_notes : cl,
            layout_notes_author : clp
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
          }
        });
        return false;
      });

      $('#btn-submit-cover').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let cc=$('#cc').val();
        let ccp=$('#ccp').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            cover_notes : cc,
            cover_notes_author : ccp
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
          }
        });
        return false;
      });

      $('#layout-setuju').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let layout_status=$('[name=layout_status]').val();
        let action=$('#layout-setuju').val();
        let end_date=$('#layout_end_date').val();
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              layout_status : layout_status,
              draft_status : action,
              layout_end_date : end_date,
              is_layout : 'y'
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
            }
          });

          // $('#layout_aksi').modal('hide');
          // location.reload();
          return false;
      });

      $('#layout-tolak').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let layout_status=$('[name=layout_status]').val();
        let action=$('#layout-tolak').val();
        let end_date=$('#layout_end_date').val();

              console.log(end_date);
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              layout_status : layout_status,
              draft_status : action,
              layout_end_date : end_date,
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
            }
          });

          // $('#layout_aksi').modal('hide');
          // location.reload();
          return false;
      });

    })
  </script>