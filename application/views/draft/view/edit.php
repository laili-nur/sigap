<?php
$ceklevel        = $this->session->userdata('level');
$sisa_waktu_edit = ceil((strtotime($input->edit_deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
?>
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
        <button type="button" class="d-inline btn <?=($editors == null) ? 'btn-warning' : 'btn-secondary';?>" data-toggle="modal" data-target="#piliheditor" title="Pilih editor"><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih Editor</span></button>
        <button type="button" class="d-inline btn btn-secondary" data-toggle="modal" data-target="#edit_deadline" title="Ubah Deadline"><i class="fas fa-calendar-alt fa-fw"></i><span class="d-none d-lg-inline"> Ubah Deadline</span></button>
        <?php endif;?>
        <?php if ($ceklevel == 'editor' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
        <button title="Mulai proses editorial" type="button" class="d-inline btn btn-secondary" id="btn-mulai-editor" <?=(($input->edit_start_date == null or $input->edit_start_date == '0000-00-00 00:00:00') and $editors) ? '' : 'disabled';?>><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
        <button title="Selesai proses editorial" type="button" class="d-inline btn btn-secondary" id="btn-selesai-editor" <?=($input->edit_end_date == null or $input->edit_end_date == '0000-00-00 00:00:00' and ($input->edit_start_date != null and $input->edit_start_date != '0000-00-00 00:00:00')) ? '' : 'disabled';?>><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
        <?php endif;?>
        <!-- /.tombol add -->
      </div>
      <!-- /.card-header-control -->
    </div>
    <!-- /.d-flex -->
  </header>
  <?php if ($editors == null and ($ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan')): ?>
  <div class="alert alert-warning"><strong>PERHATIAN!</strong> Pilih editor terlebih dahulu sebelum mulai proses editorial</div>
  <?php endif;?>
  <div class="list-group list-group-flush list-group-bordered" id="list-group-edit">
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal mulai</span>
      <strong>
        <?=konversiTanggal($input->edit_start_date);?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal selesai</span>
      <strong>
        <?=konversiTanggal($input->edit_end_date);?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Deadline</span>
      <strong>
        <?=($sisa_waktu_edit <= 0 and $input->edit_notes == '' and ($input->edit_start_date != "0000-00-00 00:00:00" and $input->edit_start_date != null)) ? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">' . konversiTanggal($input->edit_deadline) . '</span>' : konversiTanggal($input->edit_deadline);?></strong>
    </div>
    <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
    <div class="list-group-item justify-content-between" id="reloadeditor">
      <span class="text-muted">Editor</span>
      <div>
        <?php if ($editors) {
    foreach ($editors as $editor) {
        echo '<span class="badge badge-info p-1">' . $editor->username . '</span> ';
    }}?>
      </div>
    </div>
    <?php endif;?>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Status</span>
      <?php if ($input->is_edit == 'y'): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->edit_status;?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Editorial Selesai</a>
      <?php elseif ($input->is_edit == 'n' and $input->stts == 99): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->edit_status;?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Draft ditolak</a>
      <?php else: ?>
      -
      <?php endif;?>
    </div>
    <hr class="m-0">
  </div>
  <!-- .card-body -->
  <div class="card-body">
    <div class="el-example">
      <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
      <button title="Aksi admin" class="btn btn-secondary" data-toggle="modal" data-target="#edit_aksi"><i class="fa fa-thumbs-up"></i> Aksi</button>
      <?php endif;?>
      <button type="button" class="btn <?=($input->edit_notes != '' || $input->edit_notes_author != '') ? 'btn-success' : 'btn-outline-success';?>" data-toggle="modal" data-target="#edit" <?=($ceklevel == 'editor' and $sisa_waktu_edit <= 0 and $input->edit_notes == '') ? 'disabled' : '';?>>Tanggapan Editorial
        <?=($input->edit_notes != '' || $input->edit_notes_author != '') ? '<i class="fa fa-check"></i>' : '';?></button>
      <!-- tombol confidential tidak bisa diliat penulis -->
      <?php if ($ceklevel != 'author' and $ceklevel != 'layouter'): ?>
      <button data-toggle="modal" data-target="#edit-confidential" class="btn btn-outline-dark"><i class="far fa-sticky-note"></i> Catatan</button>
      <?php endif;?>
      <?php if ($ceklevel != 'author'): ?>
      <button data-toggle="modal" data-target="#edit-revisi" class="btn btn-outline-info"><i class="fa fa-tasks"></i> Revisi <span class="badge badge-info"><?=$tot_revisi['editor'];?></span></button>
      <?php endif;?>
      <!-- peringatan disabled -->
      <?=($ceklevel == 'editor' and $sisa_waktu_edit <= 0 and $input->edit_notes == '' and ($input->edit_start_date != "0000-00-00 00:00:00" and $input->edit_start_date != null)) ? '<span class="font-weight-bold text-danger" data-toggle="tooltip" data-placement="bottom" title="Hubungi admin untuk membuka draft ini"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>' : '';?>
    </div>
    <!-- modal tanggapan edit -->
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
            <?php if ($ceklevel == 'editor' or ($ceklevel == 'author' and $author_order == 1) or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
            <div class="alert alert-info">Upload file naskah atau sertakan link naskah.</div>
            <?=form_open_multipart('draft/upload_progress/' . $input->draft_id . '/edit_file', 'id="editform"');?>
            <?=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '';?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="edit_file">File Naskah</label>
              <!-- .input-group -->
              <div class="custom-file">
                <?=form_upload('edit_file', '', 'class="custom-file-input naskah" id="edit_file"');?>
                <label class="custom-file-label" for="edit_file">Choose file</label>
              </div>
              <small class="form-text text-muted">Tipe file upload bertype : docx, doc, pdf, zip, dan rar.</small>
              <!-- /.input-group -->
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="editor_file_link">Link Naskah</label>
              <div>
                <?=form_input('editor_file_link', $input->editor_file_link, 'class="form-control naskah" id="editor_file_link"');?>
              </div>
              <?=form_error('editor_file_link');?>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-edit"><i class="fa fa-upload"></i> Upload</button>
            </div>
            <?=form_close();?>
            <?php endif;?>
            <!-- endif upload ditampilkan di level tertentu -->
            <!-- keterangan last upload dan tombol download -->
            <div id="modal-edit">
              <p>Last Upload :
                <?=konversiTanggal($input->edit_upload_date);?>,
                <br> by :
                <?=konversi_username_level($input->edit_last_upload);?>
                <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
                <em>(
                  <?=$input->edit_last_upload;?>)</em>
                <?php endif;?>
              </p>
              <?=(!empty($input->edit_file)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->edit_file . '" href="' . base_url('draftfile/' . $input->edit_file) . '" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '';?>
              <?=(!empty($input->editor_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->editor_file_link . '" href="' . $input->editor_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : '';?>
              <?=(!empty($input->editor_file_link) or !empty($input->edit_file)) ? '<button data-toggle="tooltip" data-placement="right" title="" data-original-title="hapus file" class="btn btn-danger" id="btn-delete-edit"><i class="fa fa-trash"></i></button>' : '';?>
            </div>
            <hr class="my-3">
            <!-- .form -->
            <?=form_open('', 'id="formedit"');?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <label for="ce" class="font-weight-bold">Catatan Editor</label>
                <small class="text-muted" id="edit_last_notes">
                  <?=konversiTanggal($input->edit_notes_date);?></small>
                <?php
$optionsce = array(
    'name'  => 'edit_notes',
    'class' => 'form-control summernote-basic',
    'id'    => 'ce',
    'rows'  => '6',
    'value' => $input->edit_notes,
);
if ($ceklevel != 'editor') {
    echo '<div class="font-italic">' . nl2br($input->edit_notes) . '</div>';
} else {
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
    'name'  => 'edit_notes_author',
    'class' => 'form-control summernote-basic',
    'id'    => 'cep',
    'rows'  => '6',
    'value' => $input->edit_notes_author,
);
if ($ceklevel != 'author' or $author_order != 1) {
    echo '<div class="font-italic">' . nl2br($input->edit_notes_author) . '</div>';
} else {
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
            <?php if ($author_order == 1 and $ceklevel == 'author' or $ceklevel == 'editor'): ?>
            <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-edit">Submit</button>
            <?php endif;?>
            <?=form_close();?>
            <!-- /.form -->
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
          <!-- /.modal-footer -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal tanggapan edit-->
    <!-- modal catatan confidental -->
    <div class="modal fade" id="edit-confidential" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title"> Catatan Confidential</h5>
          </div>
          <!-- /.modal-header -->
          <!-- .modal-body -->
          <div class="modal-body">
            <div class="alert alert-info">
              Catatan dibawah ini tidak dapat dilihat oleh penulis.
            </div>
            <!-- .form -->
            <?=form_open();?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <label for="cecon" class="font-weight-bold">Catatan Editor</label>
                <?php
$optionscecon = array(
    'name'  => 'edit_notes_confidential',
    'class' => 'form-control summernote-basic',
    'id'    => 'cecon',
    'rows'  => '6',
    'value' => $input->edit_notes_confidential,
);
if ($ceklevel != 'editor') {
    echo '<div class="font-italic">' . nl2br($input->edit_notes_confidential) . '</div>';
} else {
    echo form_textarea($optionscecon);
}
?>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <?php if ($ceklevel == 'editor'): ?>
          <div class="modal-footer">
            <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-edit-confidential">Submit</button>
            <!-- /.form -->
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
          <?php endif;?>
          <?=form_close();?>
          <!-- /.modal-footer -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal catatan confidental -->
    <!-- modal edit revisi-->
    <div class="modal fade" id="edit-revisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title"> Revisi Edit</h5>
          </div>
          <!-- /.modal-header -->
          <!-- .modal-body -->
          <div class="modal-body">
            <!-- #accordion -->
            <div id="accordion-editor" class="card-expansion">
            </div>
            <!-- /#accordion -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer justify-content-between">
            <button disabled="disabled" class="btn btn-success" id="mulai-revisi-editor" title="Tanggal mulai revisi dan status draft akan tersimpan" data-toggle="tooltip"><i class="fa fa-plus"></i> Mulai Revisi Baru</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
          <!-- /.modal-footer -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal edit revisi-->
    <!-- modal editor-->
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
            <?=form_open('', '');?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group" id="form-editor">
                <label for="pilih_editor">Editor</label>
                <?=form_dropdown('editor', getDropdownListEditor('user', ['user_id', 'username']), '', 'id="pilih_editor" class="form-control custom-select d-block"');?>
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
              <?php if ($editors): ?>
              <!-- .table-responsive -->
              <div class="table-responsive">
                <!-- .table -->
                <table class="table table-bordered mb-0 nowrap">
                  <!-- tbody -->
                  <tbody>
                    <?php foreach ($editors as $editor): ?>
                    <!-- tr -->
                    <tr>
                      <td class="align-middle">
                        <?=$editor->username;?>
                      </td>
                      <td class="align-middle text-right" width="20px">
                        <button data-toggle="tooltip" data-placement="right" title="Hapus" href="javascript" class="btn btn-sm btn-danger delete-editor" data="<?=$editor->responsibility_id;?>">
                          <i class="fa fa-trash-alt"></i>
                          <span class="sr-only">Delete</span>
                        </button>
                      </td>
                    </tr>
                    <!-- /tr -->
                    <?php endforeach;?>
                  </tbody>
                  <!-- /tbody -->
                </table>
                <!-- /.table -->
              </div>
              <!-- /.table-responsive -->
              <?php else: ?>
              <p>Editor belum dipilih</p>
              <?php endif;?>
            </div>
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-light" id="btn-close-editor" data-dismiss="modal">Close</button>
          </div>
          <!-- /.modal-footer -->
          <?=form_close();?>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal editor-->
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
            <?=form_open('', '');?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <!-- <label for="edit_deadline">Deadline Edit</label> -->
                <div>
                  <?=form_input('edit_deadline', $input->edit_deadline, 'class="form-control mydate_modal d-none" id="edit_deadline" required=""');?>
                </div>
                <div class="invalid-feedback">Harap diisi</div>
                <?=form_error('edit_deadline');?>
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
          <?=form_close();?>
          <!-- /.form -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal deadline-->
    <!-- modal deadline revisi-->
    <div class="modal fade" id="edit-revisi-deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title">Deadline revisi</h5>
          </div>
          <!-- /.modal-header -->
          <!-- .modal-body -->
          <div class="modal-body">
            <!-- .form -->
            <?=form_open('', '');?>
            <!-- .fieldset -->
            <fieldset>
              <input type="hidden" name="revision_id" id="revision_id" class="form-control" value="">
               <!-- .form-group -->
              <div class="form-group">
                <div>
                  <?=form_input('revision_edit_start_date', '', 'class="form-control mydate_modal d-none" id="revision_edit_start_date" required=""');?>
                </div>
              </div>
              <!-- /.form-group -->
               <!-- .form-group -->
              <div class="form-group">
                <div>
                  <?=form_input('revision_edit_end_date', '', 'class="form-control mydate_modal d-none" id="revision_edit_end_date" required=""');?>
                </div>
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <div>
                  <?=form_input('revision_edit_deadline', '', 'class="form-control mydate_modal d-none" id="revision_edit_deadline" required=""');?>
                </div>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" id="btn-edit-revisi-deadline">Pilih</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
          <!-- /.modal-footer -->
          <?=form_close();?>
          <!-- /.form -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal deadline revisi-->
    <!-- modal aksi edit -->
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
            <?=form_open('', '');?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <label for="edit_status" class="font-weight-bold">Catatan Admin</label>
                <div class="alert alert-info">
                  Catatan admin dapat dilihat oleh semua user yang terkait dengan draft ini.
                </div>
                <?php
$hidden_date = array(
    'type'  => 'hidden',
    'id'    => 'edit_finish_date',
    'value' => date('Y-m-d H:i:s'),
);
echo form_input($hidden_date);
$edit_status = array(
    'name'  => 'edit_status',
    'class' => 'form-control summernote-basic',
    'id'    => 'crp2',
    'rows'  => '6',
    'value' => $input->edit_status,
);
if ($ceklevel != 'superadmin' and $ceklevel != 'admin_penerbitan') {
    echo '<div class="font-italic">' . nl2br($input->edit_status) . '</div>';
} else {
    echo form_textarea($edit_status);
}
?>
                <div class="alert alert-info">
                  Pilih salah satu tombol dibawah ini: <br>
                  Jika <strong class="text-success">Setuju</strong>, maka tahap edit akan diakhiri dan tanggal selesai edit akan dicatat <br>
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
            <button class="btn btn-success" type="submit" id="edit-setuju" value="7">Setuju</button>
            <button class="btn btn-danger" type="submit" id="edit-tolak" value="99">Tolak</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
          <!-- /.modal-footer -->
          <?=form_close();?>
          <!-- /.form -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal aksi edit-->
  </div>
  <!-- /.card-body -->
</section>
<!-- /.card -->
<script>
$(document).ready(function() {

  //panggil setingan validasi di ugmpress js
  validate_setting();

  //submit dan validasi
  $("#editform").validate({
      rules: {
        edit_file: {
          require_from_group: [1, ".naskah"],
          dokumen: "docx|doc|pdf|zip|rar",
          filesize50: 52428200
        },
        editor_file_link: {
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
        var $this = $('#btn-upload-edit');
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
        let id = $('[name=draft_id]').val();
        var formData = new FormData(form);
        $.ajax({
          url: "<?php echo base_url('draft/upload_progress/'); ?>" + id + "/edit_file",
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
            $('#modal-edit').load(' #modal-edit');
          }
        });
        $resetform = $('#edit_file');
        $resetform.val('');
        $resetform.next('label.custom-file-label').html('');
        return false;
      }
    },
   validate_select2()
  );

  //tombol hapus file
  $('#modal-edit').on('click','#btn-delete-edit', function(){
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
    var id = $('input[name=draft_id]').val();

    var jenis = 'edit';
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
        $('#modal-edit').load(' #modal-edit');
        $('#editor_file_link').val('');
      }
    })
  });

  //tombol pilih editor
  $('#btn-pilih-editor').on('click', function() {
    $('.help-block').remove();
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    var editor = $('#pilih_editor').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/add/editor'); ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        user_id: editor
      },
      success: function(data) {
        var dataeditor = JSON.parse(data);
        console.log(dataeditor);
        if (!dataeditor.validasi) {
          $('#form-editor').append('<div class="text-danger help-block">editor sudah dipilih</div>');
          toastr_view('33');
        } else if (dataeditor.validasi == 'max') {
          toastr_view('98');
        } else {
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

  //tombol mulai proses editor
  $('#btn-mulai-editor').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/mulai_proses/editor'); ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        col: 'edit_start_date'
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
        $('#list-group-edit').load(' #list-group-edit');
        $this.removeAttr("disabled").html('<i class="fas fa-play"></i><span class="d-none d-md-inline"> Mulai</span>');
        $this.addClass('disabled');
        $this.attr("disabled", "disabled");
        location.reload();
      }

    });
    return false;
  });

  //tombol selesai proses editor
  $('#btn-selesai-editor').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/selesai_proses/editor'); ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        col: 'edit_end_date'
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
        $('#list-group-edit').load(' #list-group-edit');
        $this.removeAttr("disabled").html('<i class="fas fa-stop"></i><span class="d-none d-md-inline"> Selesai</span>');
        $this.addClass('disabled');
        $this.attr("disabled", "disabled");
        //location.reload();
      }

    });
    return false;
  });

  //hapus editor
  $('#reload-editor').on('click', '.delete-editor', function() {
    $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
    var id = $(this).attr('data');
    console.log(id);
    $.ajax({
      url: "<?php echo base_url('responsibility/delete/'); ?>" + id,
      success: function(data) {
        console.log(data);
        $('#reload-editor').load(' #reload-editor');
        toastr_view('6');
        //$('#list-group-edit').load(' #list-group-edit');
      }
    })
  });

  $('#btn-submit-edit').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let ce = $('#ce').val();
    let cep = $('#cep').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        edit_notes: ce,
        edit_notes_date: true,
        edit_notes_author: cep
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax);

        $this.removeAttr("disabled").html("Submit");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-edit').load(' #list-group-edit');
        $('#edit_last_notes').html(datax.edit_notes_date);
        $('#edit').modal('toggle');
      }
    });
    return false;
  });

  $('#btn-submit-edit-confidential').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let cecon = $('#cecon').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        edit_notes_confidential: cecon,
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax);
        $this.removeAttr("disabled").html("Submit");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#edit-confidential').modal('toggle');
      }
    });
    return false;
  });



  $('#edit-setuju').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let edit_status = $('[name=edit_status]').val();
    let action = $('#edit-setuju').val();
    let end_date = $('#edit_finish_date').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        edit_status: edit_status,
        draft_status: action,
        is_edit: 'y'
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
        $('#list-group-edit').load(' #list-group-edit');
        location.reload();
      }
    });

    // $('#edit_aksi').modal('hide');
    return false;
  });

  $('#edit-tolak').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let edit_status = $('[name=edit_status]').val();
    let action = $('#edit-tolak').val();
    let end_date = $('#edit_finish_date').val();

    console.log(end_date);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        edit_status: edit_status,
        draft_status: action,
        is_edit: 'n'
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
        $('#list-group-edit').load(' #list-group-edit');
        location.reload();
      }
    });

    // $('#edit_aksi').modal('hide');
    return false;
  });

  //edit deadline
  $('#btn-edit-deadline').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let ed = $('[name=edit_deadline]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        edit_deadline: ed
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
        $('#list-group-edit').load(' #list-group-edit');
        $('#edit_deadline').modal('toggle');
      }
    });
    return false;
  });

  //load data ketika modal dibuka
  $('#edit-revisi').on('shown.bs.modal', function (e) {
    load_revisi_edit();
  })

  //kosongkan modal ketika close
  $('#edit-revisi').on('hidden.bs.modal', function (e) {
    $('#accordion-editor').html('');
  })

  //gantian modal revisi dan deadline revisi
  // $('#edit-revisi-deadline').on('shown.bs.modal', function (e) {
  //   $('#edit-revisi').modal('toggle');
  // })
  $('#edit-revisi-deadline').on('hidden.bs.modal', function (e) {
    load_revisi_edit();
  })

  $('#accordion-editor').on('click', '.trigger-edit-revisi-deadline',function(e){
    var revision_id = $(this).attr('data');
    $('#revision_id').val(revision_id);
  });

  $('#btn-edit-revisi-deadline').on('click', function (e) {
    var revision_id = $('#revision_id').val();
        e.preventDefault();
        let revision_edit_deadline = $('[name=revision_edit_deadline]').val();
        let revision_edit_start_date = $('[name=revision_edit_start_date]').val();
        let revision_edit_end_date = $('[name=revision_edit_end_date]').val();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('draft/deadlineRevision'); ?>",
          datatype: "JSON",
          data: {
            revision_id: revision_id,
            revision_deadline: revision_edit_deadline,
            revision_start_date: revision_edit_start_date,
            revision_end_date: revision_edit_end_date,
          },
          success: function(data){
            let datax = JSON.parse(data);
            console.log(datax);
            if (datax.status == true) {
              toastr_view('111');
            } else {
              toastr_view('000');
            }
            $('#edit-revisi-deadline').modal('toggle');
          }
        })
      })

  function load_revisi_edit(){
    let draft_id = $('[name=draft_id]').val();
    $('#accordion-editor').html('<i class="fa fa-spinner fa-spin"></i> Loading data...');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/getRevision'); ?>",
      datatype: "JSON",
      data:{
        draft_id: draft_id,
        role: 'editor'
      },
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax.flag);
        if(datax.flag != true){
          $('#mulai-revisi-editor').removeAttr('disabled');
        }
        var i;
        if(datax.revisi.length>0){
          for(i=0; i<datax.revisi.length; i++){
            $('#accordion-editor').html(datax.revisi);
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
          $('#accordion-editor').html(datax.revisi);
        }

      }
    });
  }



  $('#accordion-editor').on('click', '.selesai-revisi',function(){
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
        load_revisi_edit();
      }
    })
  });

  $('#accordion-editor').on('click', '.submit-revisi',function(){
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

  $('#accordion-editor').on('click', '.hapus-revisi',function(){
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
        load_revisi_edit();
      }
    })
  });


  $('#mulai-revisi-editor').on('click', function(){
    $(this).attr("disabled", "disabled");
    $(this).tooltip('dispose');
    let draft_id = $('[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/insertRevision'); ?>",
      datatype: "JSON",
      data:{
        draft_id: draft_id,
        role: 'editor'
      },
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax);
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        load_revisi_edit();
      }
    })
  });





  $('#btn-close-editor').on('click', function() {
    location.reload();
  });

})
</script>