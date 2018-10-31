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
          <button type="button" class="btn <?=($editors==null)? 'btn-warning' : 'btn-secondary' ?>" data-toggle="modal" data-target="#piliheditor">Pilih Editor</button>
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#edit_deadline">Atur Deadline</button>
          <?php endif ?>
          <?php if($ceklevel == 'editor'): ?>
          <button type="button" class="btn btn-warning" id="btn-kerjakan-editor">Mulai Proses</button>
          <?php endif ?>
          <!-- /.tombol add -->
        </div>
        <!-- /.card-header-control -->
      </div>
      <!-- /.d-flex -->
    </header>
    <?php if($editors == null): ?>
    <div class="alert alert-warning"><strong>PERHATIAN!</strong> Pilih editor terlebih dahulu sebelum lanjut ke tahap selanjutnya.</div>
    <?php endif ?>
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
        <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->edit_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Editorial Selesai</a>
        <?php elseif($input->is_edit == 'n' and $input->stts == 99): ?>
        <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->edit_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Draft ditolak</a>
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
        <button title="Aksi admin" class="btn btn-secondary" style="width:50px" data-toggle="modal" data-target="#edit_aksi"><i class="fa fa-thumbs-up"></i></button>
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
                  <p class="font-weight-bold">NASKAH</p>
                  <!-- if upload ditampilkan di level tertentu -->
                  <?php if($ceklevel=='editor' or ($ceklevel == 'author' and $author_order==1) or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
                  <div class="alert alert-info">Upload file naskah atau sertakan link naskah.</div>
                  <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/edit_file', 'id="editform"'); ?>
                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                    <!-- .form-group -->
                      <div class="form-group">
                        <label for="edit_file">File Naskah</label>
                        <!-- .input-group -->
                          <div class="custom-file">
                            <?= form_upload('edit_file','','class="custom-file-input naskah" id="edit_file"') ?> 
                            <label class="custom-file-label" for="edit_file">Choose file</label>
                          </div>
                        <small class="form-text text-muted">Tipe file upload  bertype : docx, doc, dan pdf.</small>
                        <!-- /.input-group -->
                      </div>
                      <!-- /.form-group -->
                      <!-- .form-group -->
                    <div class="form-group">
                      <label for="editor_file_link">Link Naskah</label>
                      <div>
                        <?= form_input('editor_file_link', $input->editor_file_link, 'class="form-control naskah" id="editor_file_link"') ?>
                      </div>
                        <?= form_error('editor_file_link') ?>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                      <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-edit"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                  <?= form_close(); ?>
                  <?php endif ?>
                  <!-- endif upload ditampilkan di level tertentu -->
                  
                  <!-- keterangan last upload dan tombol download -->
                  <div id="modal-edit">
                  <p>Last Upload : <?=konversiTanggal($input->edit_upload_date) ?>, 
                  <br> by : <?=konversi_username_level($input->edit_last_upload) ?>
                  <?php  if($ceklevel !='author' and $ceklevel !='reviewer'):?>
                    <em>(<?=$input->edit_last_upload ?>)</em>
                  <?php endif ?>
                  </p>
                  <?=(!empty($input->edit_file))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->edit_file.'" href="'.base_url('draftfile/'.$input->edit_file).'" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '' ?>
                  <?=(!empty($input->editor_file_link))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->editor_file_link.'" href="'.$input->editor_file_link.'" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : '' ?>
                  </div>
  
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
                        if($ceklevel!='author' or $author_order!=1){
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
                <?php if($author_order!=0 or $ceklevel!='author'): ?>
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-edit">Submit</button>
                <?php endif ?>
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
                        <table class="table table-bordered mb-0 nowrap">
                          <!-- tbody -->
                          <tbody>
                            <?php foreach($editors as $editor): ?>
                            <!-- tr -->
                            <tr>
                              <td class="align-middle"><?= $editor->username ?></td>
                              <td class="align-middle text-right" width="20px">
                                <button data-toggle="tooltip" data-placement="right" title="Hapus" href="javascript" class="btn btn-sm btn-danger delete-editor" data="<?= $editor->responsibility_id ?>">
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
                <button type="button" class="btn btn-light" id="btn-close-editor" data-dismiss="modal">Close</button>
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

      //panggil setingan validasi di ugmpress js
      setting_validasi();

      //submit dan validasi
      $("#editform").validate({
          rules: {
            edit_file: {
              require_from_group: [1, ".naskah"],
              dokumen: "docx|doc|pdf",
              filesize50: 52428200
            },
            editor_file_link : {
              require_from_group: [1, ".naskah"]
            }
          },
          errorElement: "span",
          errorClass : "none",
          validClass : "none",
          errorPlacement: function (error, element) {
             error.addClass( "invalid-feedback" );
              if (element.parent('.input-group').length) { 
                  error.insertAfter(element.next('span.select2'));      // input group
              } else if (element.hasClass("select2-hidden-accessible")){
                  error.insertAfter(element.next('span.select2'));  // select2
              } else if (element.parent().parent().hasClass('input-group')){
                  error.insertAfter(element.closest('.input-group'));  // fileinput append
              } else if (element.hasClass("custom-file-input")){
                  error.insertAfter(element.next('label.custom-file-label'));  // fileinput custom
              }else if (element.hasClass("custom-control-input")){
                  error.insertAfter($(".custom-radio").last());  // radio
              }else {                                      
                  error.insertAfter(element);               // default
              }
          },
          submitHandler: function (form) { 
                var $this = $('#btn-upload-edit');
                $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
                let id=$('[name=draft_id]').val();
                var formData = new FormData(form);
                $.ajax({
                    url : "<?php echo base_url('draft/upload_progress/') ?>"+id+"/edit_file",
                    type:"post",
                     data:formData,
                     processData:false,
                     contentType:false,
                     cache:false,
                    success :function(data){
                      let datax = JSON.parse(data);
                      console.log(datax);
                      $this.removeAttr("disabled").html("Upload");
                      if(datax.status == true){
                        toastr_view('111');
                      }else{
                        toastr_view('000');
                      }
                      $('#modal-edit').load(' #modal-edit');
                    }
                  });
                $resetform = $('#edit_file');
                $resetform.val('');
                $resetform.next('label.custom-file-label').html('');
              return false;
          }
        },
        select2_validasi()
       );

      //pilih editor
    $('#btn-pilih-editor').on('click',function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var editor = $('#pilih_editor').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('responsibility/add/editor') ?>",
        datatype : "JSON",
        cache:false,
        data : {
          draft_id : draft,
          user_id : editor
        },
        success :function(data){
          var dataeditor = JSON.parse(data);
          console.log(dataeditor);
          if(!dataeditor.validasi){
            $('#form-editor').append('<div class="text-danger help-block">editor sudah dipilih</div>');
            toastr_view('33');
          }else if(dataeditor.validasi == 'max'){
            toastr_view('98');
          }else{
            toastr_view('5');
          }
          $('[name=editor]').val("");
          $('#reload-editor').load(' #reload-editor');
          //$('#list-group-edit').load(' #list-group-edit');
          $this.removeAttr("disabled").html("Pilih");
        }

      });
      return false;
    });

    //tombol kerjakan editor
    $('#btn-kerjakan-editor').on('click',function(){
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('responsibility/mulai_proses') ?>",
        datatype : "JSON",
        cache:false,
        data : {
          draft_id : draft,
          col : 'edit_start_date'
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
          $this.removeAttr("disabled").html("Mulai Proses");
        }

      });
      return false;
    });

    //hapus editor
    $('#reload-editor').on('click','.delete-editor',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('responsibility/delete/') ?>"+id,
          success : function(data){
            console.log(data);
            $('#reload-editor').load(' #reload-editor');
            toastr_view('6');
            //$('#list-group-edit').load(' #list-group-edit');
          }

        })
    });

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
              location.reload();
            }
          });

          // $('#edit_aksi').modal('hide');
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
              location.reload();
            }
          });

          // $('#edit_aksi').modal('hide');
          return false;
      });

      //edit deadline
    $('#btn-edit-deadline').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let ed=$('[name=edit_deadline]').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            edit_deadline : ed
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
             $('#edit_deadline').modal('toggle');
          }
        });
        return false;
      });

    $('#btn-close-editor').on('click',function(){
      location.reload();
    });

    })
  </script>