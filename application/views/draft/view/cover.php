<?php
  $ceklevel = $this->session->userdata('level');
  $sisa_waktu_cover = ceil((strtotime($input->cover_deadline)-strtotime(date('Y-m-d H:i:s')))/86400);
  ?>
<!-- .card -->
<section id="progress-cover" class="card">
  <!-- .card-header -->
  <header class="card-header">
    <!-- .d-flex -->
    <div class="d-flex align-items-center">
      <span class="mr-auto">Cover</span>
      <!-- .card-header-control -->
      <div class="card-header-control">
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
        <!-- .tombol add -->
        <button type="button" class="d-inline btn btn-secondary" data-toggle="modal" data-target="#cover_deadline" title="Ubah Deadline"><i class="fas fa-calendar-alt fa-fw"></i><span class="d-none d-lg-inline"> Ubah Deadline</span></button>
        <?php endif ?>
        <?php if($ceklevel == 'cover' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
        <button title="Mulai proses cover" type="button" class="d-inline btn btn-secondary" id="btn-mulai-cover" <?=(($input->cover_start_date==null or $input->cover_start_date=='0000-00-00 00:00:00') and $layouters)? '' : 'disabled' ?>><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
        <button title="Mulai proses cover" type="button" class="d-inline btn btn-secondary" id="btn-selesai-cover" <?=($input->cover_end_date==null or $input->cover_end_date=='0000-00-00 00:00:00' and ($input->cover_start_date!=null and $input->cover_start_date!='0000-00-00 00:00:00'))? '' : 'disabled' ?>><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
        <?php endif ?>
        <!-- /.tombol add -->
      </div>
      <!-- /.card-header-control -->
    </div>
    <!-- /.d-flex -->
  </header>
  <?php if($layouters == null and ($ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan')): ?>
  <div class="alert alert-warning"><strong>PERHATIAN!</strong> Pilih cover terlebih dahulu sebelum mulai proses cover &amp; cover.</div>
  <?php endif ?>
  <div class="list-group list-group-flush list-group-bordered" id="list-group-cover">
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal mulai</span>
      <strong><?= konversiTanggal($input->cover_start_date) ?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal selesai</span>
      <strong><?= konversiTanggal($input->cover_end_date) ?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Deadline</span>
      <strong><?= ($sisa_waktu_cover <= 0 and $input->cover_notes =='' and ($input->cover_start_date != "0000-00-00 00:00:00" and $input->cover_start_date !=null))? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">'.konversiTanggal($input->cover_deadline).'</span>' : konversiTanggal($input->cover_deadline) ?></strong>
    </div>
    <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">cover</span>
      <strong>
            <?php if ($layouters) {
              $i = 0;
              foreach ($layouters as $idx => $cover){
                if($idx>0){
                  echo '<span class="badge badge-info p-1">'.$cover->username.'</span> ';
                }
              }
            }
            ?>
          </strong>
    </div>
    <?php endif ?>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Status</span>
      <?php if($input->is_cover == 'y'): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->cover_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Cover Selesai</a>
      <?php elseif($input->is_cover == 'n' and $input->stts == 99): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->cover_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Draft Ditolak</a>
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
      <button title="Aksi admin" class="btn btn-secondary" data-toggle="modal" data-target="#cover_aksi"><i class="fa fa-thumbs-up"></i> Aksi</button>
      <?php endif ?>
      <button type="button" class="btn <?=($input->cover_notes!='' || $input->cover_notes_author!='')? 'btn-success' : 'btn-outline-success' ?>" data-toggle="modal" data-target="#cover" <?=($ceklevel=='cover' and $sisa_waktu_cover <=0 and $input->cover_notes =='')? 'disabled' : '' ?>>Tanggapan Cover
        <?=($input->cover_notes!='' || $input->cover_notes_author!='')? '<i class="fa fa-check"></i>' : '' ?></button>
      <?php if ($ceklevel != 'author'): ?>
        <button data-toggle="modal" data-target="#cover-revisi" class="btn btn-outline-info"><i class="fa fa-tasks"></i> Revisi <span class="badge badge-info"><?=$tot_revisi['cover'] ?></span></button>
      <?php endif ?>
      <!-- peringatan disabled -->
      <?=($ceklevel=='cover' and $sisa_waktu_cover <= 0 and $input->cover_notes =='' and ($input->cover_start_date != "0000-00-00 00:00:00" and $input->cover_start_date !=null))? '<span class="font-weight-bold text-danger" data-toggle="tooltip" data-placement="bottom" title="Hubungi admin untuk membuka draft ini"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>' : '' ?>
    </div>
    <!-- modal tanggapan cover -->
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
            <p class="font-weight-bold">COVER</p>
            <!-- if upload ditampilkan di level tertentu -->
            <?php if($ceklevel=='layouter' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
            <div class="alert alert-info">Upload file cover atau sertakan link cover.</div>
            <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/cover_file', 'id="coverform"'); ?>
            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="cover_file">File Cover</label>
              <!-- .input-group -->
              <div class="custom-file">
                <?= form_upload('cover_file','','class="custom-file-input naskah" id="cover_file"') ?>
                <label class="custom-file-label" for="cover_file">Choose file</label>
              </div>
              <small class="form-text text-muted">Tipe file upload  bertype : jpg, jpeg, png, dan pdf.</small>
              <!-- /.input-group -->
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="cover_file_link">Link Cover</label>
              <div>
                <?= form_input('cover_file_link', $input->cover_file_link, 'class="form-control naskah" id="cover_file_link"') ?>
              </div>
              <?= form_error('cover_file_link') ?>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-cover"><i class="fa fa-upload"></i> Upload</button>
            </div>
            <?= form_close(); ?>
            <?php endif ?>
            <!-- endif upload ditampilkan di level tertentu -->
            <!-- if download ditampilkan di level tertentu -->
            <?php if($ceklevel!='author' and $ceklevel != 'reviewer' ): ?>
            <!-- keterangan last upload dan tombol download -->
            <div id="modal-cover">
              <p>Last Upload :
                <?=konversiTanggal($input->cover_upload_date) ?>
                <br> by :
                <?=konversi_username_level($input->cover_last_upload) ?>
                <?php  if($ceklevel !='author' and $ceklevel !='reviewer'):?>
                <em>(<?=$input->cover_last_upload ?>)</em>
                <?php endif ?>
              </p>
              <?php if(!empty($input->cover_file)):?>
              <div class="row">
                <!-- grid column -->
                <div class="col-12 col-sm-4">
                  <!-- .card -->
                  <section class="card card-figure">
                    <!-- .card-figure -->
                    <figure class="figure">
                      <!-- .figure-img -->
                      <div class="figure-img">
                        <img class="img-fluid" src="<?= base_url('coverfile/'.$input->cover_file);?>" alt="Card image cap">
                        <div class="figure-action">
                          <a href="<?=base_url('draft/download/coverfile/'.urlencode($input->cover_file)) ?>" class="btn btn-block btn-sm btn-primary">Download Cover</a>
                        </div>
                      </div>
                      <!-- /.figure-img -->
                      <!-- .figure-caption -->
                      <figcaption class="figure-caption">
                        <h6 class="figure-title">
                                    <a href="<?=base_url('draft/download/coverfile/'.urlencode($input->cover_file)) ?>"><?=$input->cover_file ?></a>
                                  </h6>
                      </figcaption>
                      <!-- /.figure-caption -->
                    </figure>
                    <!-- /.card-figure -->
                  </section>
                  <!-- /.card -->
                </div>
                <!-- /grid column -->
              </div>
              <?php endif ?>
              <?=(!empty($input->cover_file_link))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->cover_file_link.'" href="'.$input->cover_file_link.'" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : '' ?>
            </div>
            <?php endif ?>
            <!-- endif download ditampilkan di level tertentu -->
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
            <?php if($author_order!=0 or $ceklevel!='author'): ?>
            <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-cover">Submit</button>
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
    <!-- /.modal tanggapan cover-->
    <!-- modal cover revisi-->
    <div class="modal fade" id="cover-revisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title"> Revisi cover</h5>
          </div>
          <!-- /.modal-header -->
          <!-- .modal-body -->
          <div class="modal-body">
            <!-- #accordion -->
            <div id="accordion-cover" class="card-expansion">
            </div>
            <!-- /#accordion -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer justify-content-between">
            <button disabled="disabled" class="btn btn-success" id="mulai-revisi-cover" title="Tanggal mulai revisi dan status draft akan tersimpan" data-toggle="tooltip"><i class="fa fa-plus"></i> Mulai Revisi Baru</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
          <!-- /.modal-footer -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal cover revisi-->
    
    <!-- modal deadline -->
    <div class="modal fade" id="cover_deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title">Deadline cover</h5>
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
                <!-- <label for="cover_deadline">Deadline cover</label> -->
                <div>
                  <?= form_input('cover_deadline', $input->cover_deadline, 'class="form-control mydate_modal d-none" id="cover_deadline" required=""') ?>
                </div>
                <div class="invalid-feedback">Harap diisi</div>
                <?= form_error('cover_deadline') ?>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" id="btn-cover-deadline">Pilih</button>
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
    <!-- /.modal deadline-->
    <!-- modal deadline revisi-->
    <div class="modal fade" id="cover-revisi-deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title">Deadline revisi cover</h5>
          </div>
          <!-- /.modal-header -->
          <!-- .modal-body -->
          <div class="modal-body">
            <!-- .form -->
            <?= form_open('','') ?>
            <!-- .fieldset -->
            <fieldset>
              <input type="hidden" name="revision_id" id="revision_id" class="form-control" value="">
              <!-- .form-group -->
              <div class="form-group">
                <!-- <label for="edit_deadline">Deadline Edit</label> -->
                <div>
                  <?= form_input('revision_cover_start_date', '', 'class="form-control mydate_modal d-none" id="revision_cover_start_date" required=""') ?>
                </div>
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <!-- <label for="edit_deadline">Deadline Edit</label> -->
                <div>
                  <?= form_input('revision_cover_end_date', '', 'class="form-control mydate_modal d-none" id="revision_cover_end_date" required=""') ?>
                </div>
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <!-- <label for="edit_deadline">Deadline Edit</label> -->
                <div>
                  <?= form_input('revision_cover_deadline', '', 'class="form-control mydate_modal d-none" id="revision_cover_deadline" required=""') ?>
                </div>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" id="btn-cover-revisi-deadline">Pilih</button>
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
    <!-- /.modal deadline revisi-->
    <!-- modal aksi edit -->
    <div class="modal fade" id="cover_aksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <label for="cover_status" class="font-weight-bold">Catatan Admin</label>
                <div class="alert alert-info">
                  Catatan admin dapat dilihat oleh semua user yang terkait dengan draft ini.
                </div>
                <?php
                      $hidden_date = array(
                        'type'  => 'hidden',
                        'id'    => 'cover_finish_date',
                        'value' => date('Y-m-d H:i:s')
                      );
                      echo form_input($hidden_date);
                      $cover_status = array(
                        'name' => 'cover_status',
                        'class'=> 'form-control summernote-basic',
                        'id'  => 'crp2',
                        'rows' => '6',
                        'value'=> $input->cover_status
                      );
                      if($ceklevel!='superadmin' and $ceklevel!='admin_penerbitan'){
                        echo '<div class="font-italic">'.nl2br($input->cover_status).'</div>';
                      }else{
                        echo form_textarea($cover_status);
                      }
                      ?>
                <div class="alert alert-info">
                  Pilih salah satu tombol dibawah ini: <br>
                  Jika <strong class="text-success">Setuju</strong>, maka tahap cover akan diakhiri dan tanggal selesai cover akan dicatat <br>
                  Jika <strong class="text-danger">Tolak</strong> maka proses draft akan diakhiri sampai tahap ini.
                </div>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
            <button class="btn btn-success" type="submit" id="cover-setuju" value="11">Setuju</button>
            <button class="btn btn-danger" type="submit" id="cover-tolak" value="99">Tolak</button>
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
$(document).ready(function() {
  //panggil setingan validasi di ugmpress js
  setting_validasi();

  //submit dan validasi
  $("#coverform").validate({
      rules: {
        cover_file: {
          require_from_group: [1, ".naskah"],
          dokumen: "idml|indd|indt|pdf|zip|rar",
          filesize50: 52428200
        },
        cover_file_link: {
          curl: true,
          require_from_group: [1, ".naskah"]
        }
      },
      errorElement: "span",
      errorClass: "none",
      validClass: "none",
      errorPlacement: function(error, element) {
        error.addClass("invalid-feedback");
        if (element.parent('.input-group').length) {
          error.insertAfter(element.next('span.select2')); // input group
        } else if (element.hasClass("select2-hidden-accessible")) {
          error.insertAfter(element.next('span.select2')); // select2
        } else if (element.parent().parent().hasClass('input-group')) {
          error.insertAfter(element.closest('.input-group')); // fileinput append
        } else if (element.hasClass("custom-file-input")) {
          error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
        } else if (element.hasClass("custom-control-input")) {
          error.insertAfter($(".custom-radio").last()); // radio
        } else {
          error.insertAfter(element); // default
        }
      },
      submitHandler: function(form) {
        var $this = $('#btn-upload-cover');
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
        let id = $('[name=draft_id]').val();
        var formData = new FormData(form);
        $.ajax({
          url: "<?php echo base_url('draft/upload_progress/') ?>" + id + "/cover_file",
          type: "post",
          data: formData,
          processData: false,
          contentType: false,
          cache: false,
          success: function(data) {
            let datax = JSON.parse(data);
            console.log(datax);
            $this.removeAttr("disabled").html("Upload");
            if (datax.status == true) {
              toastr_view('111');
            } else {
              toastr_view('000');
            }
            $('#modal-cover').load(' #modal-cover');
          }
        });
        $resetform = $('#cover_file');
        $resetform.val('');
        $resetform.next('label.custom-file-label').html('');
        return false;
      }
    },
    select2_validasi()
  );

  //submit dan validasi
  $("#coverform").validate({
      rules: {
        cover_file: {
          require_from_group: [1, ".naskah"],
          dokumen: "jpg|jpeg|png|pdf",
          filesize50: 52428200
        },
        cover_file_link: {
          curl: true,
          require_from_group: [1, ".naskah"]
        }
      },
      errorElement: "span",
      errorClass: "none",
      validClass: "none",
      errorPlacement: function(error, element) {
        error.addClass("invalid-feedback");
        if (element.parent('.input-group').length) {
          error.insertAfter(element.next('span.select2')); // input group
        } else if (element.hasClass("select2-hidden-accessible")) {
          error.insertAfter(element.next('span.select2')); // select2
        } else if (element.parent().parent().hasClass('input-group')) {
          error.insertAfter(element.closest('.input-group')); // fileinput append
        } else if (element.hasClass("custom-file-input")) {
          error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
        } else if (element.hasClass("custom-control-input")) {
          error.insertAfter($(".custom-radio").last()); // radio
        } else {
          error.insertAfter(element); // default
        }
      },
      submitHandler: function(form) {
        var $this = $('#btn-upload-cover');
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
        let id = $('[name=draft_id]').val();
        var formData = new FormData(form);
        $.ajax({
          url: "<?php echo base_url('draft/upload_progress/') ?>" + id + "/cover_file",
          type: "post",
          data: formData,
          processData: false,
          contentType: false,
          cache: false,
          success: function(data) {
            let datax = JSON.parse(data);
            console.log(datax);
            $this.removeAttr("disabled").html("Upload");
            if (datax.status == true) {
              toastr_view('111');
            } else {
              toastr_view('000');
            }
            $('#modal-cover').load(' #modal-cover');
          }
        });
        $resetform = $('#cover_file');
        $resetform.val('');
        $resetform.next('label.custom-file-label').html('');
        return false;
      }
    },
    select2_validasi()
  );

   //tombol hapus file
   $('#modal-cover').on('click','#btn-delete-cover', function(){
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
    var id = $('input[name=draft_id]').val();
    var jenis = 'cover';
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/delete_progress/'); ?>" + id + "/" + jenis,
      datatype: "JSON",
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax);
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#modal-cover').load(' #modal-cover');
        $('#cover_file_link').val('');
      }
    })
  });

  //tombol kerjakan cover
  $('#btn-mulai-cover').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/mulai_proses/cover') ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        col: 'cover_start_date'
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax)
        $this.removeAttr("disabled").html("Submit");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-cover').load(' #list-group-cover');
        $this.removeAttr("disabled").html('<i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span>');
        $this.addClass('disabled');
        $this.attr("disabled", "disabled");
        location.reload();
      }

    });
    return false;
  });

   //tombol selesai proses cover
  $('#btn-selesai-cover').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/selesai_proses/cover') ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        col: 'cover_end_date'
      },
      success: function(data) {
        console.log(data);
        let datax = JSON.parse(data);
        console.log(datax)
        $this.removeAttr("disabled").html("Submit");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-cover').load(' #list-group-cover');
        $this.removeAttr("disabled").html('<i class="fas fa-stop"></i><span class="d-none d-md-inline"> Selesai</span>');
        $this.addClass('disabled');
        $this.attr("disabled", "disabled");
        //location.reload();
      }

    });
    return false;
  });

  $('#btn-submit-cover').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let cc = $('#cc').val();
    let ccp = $('#ccp').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/') ?>" + id,
      datatype: "JSON",
      data: {
        cover_notes: cc,
        cover_notes_author: ccp,
        draft_status: 10,
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax)
        $this.removeAttr("disabled").html("Submit");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-cover').load(' #list-group-cover');
        $('#cover').modal('toggle');
      }
    });
    return false;
  });


  $('#cover-setuju').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let cover_status = $('[name=cover_status]').val();
    let action = $('#cover-setuju').val();
    let end_date = $('#cover_finish_date').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/') ?>" + id,
      datatype: "JSON",
      data: {
        cover_status: cover_status,
        draft_status: action,
        proofread_start_date: end_date,
        is_cover: 'y',
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax);
        $this.removeAttr("disabled").html("Setuju");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-cover').load(' #list-group-cover');
        location.reload();
      }
    });

    // $('#cover_aksi').modal('hide');
    return false;
  });

  $('#cover-tolak').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let cover_status = $('[name=cover_status]').val();
    let action = $('#cover-tolak').val();
    let end_date = $('#cover_finish_date').val();

    console.log(end_date);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/') ?>" + id,
      datatype: "JSON",
      data: {
        cover_status: cover_status,
        draft_status: action,
        is_cover: 'n'
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax);
        $this.removeAttr("disabled").html("Tolak");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-cover').load(' #list-group-cover');
        location.reload();
      }
    });

    // $('#cover_aksi').modal('hide');
    return false;
  });

  //cover deadline
  $('#btn-cover-deadline').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let ld = $('[name=cover_deadline]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/') ?>" + id,
      datatype: "JSON",
      data: {
        cover_deadline: ld
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax)
        $this.removeAttr("disabled").html("Submit");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-cover').load(' #list-group-cover');
        $('#cover_deadline').modal('toggle');
      }
    });
    return false;
  });

  //load data ketika modal dibuka
  $('#cover-revisi').on('shown.bs.modal', function (e) {
    load_revisi_cover();
  })

  //kosongkan modal ketika close
  $('#cover-revisi').on('hidden.bs.modal', function (e) {
    $('#accordion-cover').html('');
  })

  //gantian modal revisi dan deadline revisi
  // $('#cover-revisi-deadline').on('shown.bs.modal', function (e) {
  //   $('#cover-revisi').modal('toggle');
  // })
  $('#cover-revisi-deadline').on('hidden.bs.modal', function (e) {
    load_revisi_cover();
  })

  $('#accordion-cover').on('click', '.trigger-cover-revisi-deadline',function(e){
    var revision_id = $(this).attr('data');
    $('#revision_id').val(revision_id);

  });

  $('#btn-cover-revisi-deadline').on('click', function (e) {
        var revision_id = $('#revision_id').val();
        e.preventDefault();
        let revision_cover_deadline = $('[name=revision_cover_deadline]').val();
        let revision_cover_start_date = $('[name=revision_cover_start_date]').val();
        let revision_cover_end_date = $('[name=revision_cover_end_date]').val();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('draft/deadlineRevision'); ?>",
          datatype: "JSON",
          data: {
            revision_id: revision_id,
            revision_deadline: revision_cover_deadline,
            revision_start_date: revision_cover_start_date,
            revision_end_date: revision_cover_end_date,
          },
          success: function(data){
            let datax = JSON.parse(data);
            console.log(datax);
            if (datax.status == true) {
              toastr_view('111');
            } else {
              toastr_view('000');
            }
            $('#cover-revisi-deadline').modal('toggle');
          }
        })
      })


  function load_revisi_cover(){
    let draft_id = $('[name=draft_id]').val();
    $('#accordion-cover').html('<i class="fa fa-spinner fa-spin"></i> Loading data...');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/getRevision'); ?>",
      datatype: "JSON",
      data:{
        draft_id: draft_id,
        role: 'cover'
      },
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax.flag);
        if(datax.flag != true){
          $('#mulai-revisi-cover').removeAttr('disabled');
        }
        var i;
        if(datax.revisi.length>0){
          for(i=0; i<datax.revisi.length; i++){
            $('#accordion-cover').html(datax.revisi);
            $('.summernote-basic').summernote({
              placeholder: 'Write here...',
              height: 100,
              disableDragAndDrop: true,
              toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['fontsize','height']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['view', ['codeview']],
              ]
            });
          }
        }else{
          $('#accordion-cover').html(datax.revisi);
        }

      }
    });
  }



  $('#accordion-cover').on('click', '.selesai-revisi',function(){
    $(this).attr("disabled", "disabled");
    var revision_id = $(this).attr('data');
    let draft_id = $('[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/endRevision'); ?>",
      datatype: "JSON",
      data:{
        revision_id : revision_id,
        draft_id : draft_id
      },
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax);
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        load_revisi_cover();
      }
    })
  });

  $('#accordion-cover').on('click', '.submit-revisi',function(){
    var revision_id = $(this).attr('data');
    var revision_notes = $('#revisi'+revision_id).val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/submitRevision'); ?>",
      datatype: "JSON",
      data: {
        revision_id: revision_id,
        revision_notes: revision_notes
      },
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax);
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
      }
    })
  });

  $('#accordion-cover').on('click', '.hapus-revisi',function(){
    var id = $(this).attr('data');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/deleteRevision/'); ?>" + id,
      datatype: "JSON",
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax);
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        load_revisi_cover();
      }
    })
  });


  $('#mulai-revisi-cover').on('click', function(){
    $(this).attr("disabled", "disabled");
    $(this).tooltip('dispose');
    let draft_id = $('[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/insertRevision'); ?>",
      datatype: "JSON",
      data:{
        draft_id: draft_id,
        role: 'cover'
      },
      success: function(data){
        console.log(data);
        let datax = JSON.parse(data);
        console.log(datax);
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        load_revisi_cover();
      },
      error: function(a, b, c){
        console.log(a.responseText);
      }
    })
  });

  //tombol close modal cover
  $('#btn-close-cover').on('click', function() {
    location.reload();
  });

})
</script>