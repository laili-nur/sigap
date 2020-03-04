<?php
$ceklevel          = $this->session->userdata('level');
$sisa_waktu_layout = ceil((strtotime($input->layout_deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
?>
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
        <button type="button" class="d-inline btn <?=($layouters == null) ? 'btn-warning' : 'btn-secondary';?>" data-toggle="modal" data-target="#pilihlayouter" title="Pilih Layouter"><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih layouter</span></button>
        <button type="button" class="d-inline btn btn-secondary" data-toggle="modal" data-target="#layout_deadline" title="Ubah Deadline"><i class="fas fa-calendar-alt fa-fw"></i><span class="d-none d-lg-inline"> Ubah Deadline</span></button>
        <?php endif;?>
        <?php if ($ceklevel == 'layouter' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
        <button title="Mulai proses layout" type="button" class="d-inline btn btn-secondary" id="btn-mulai-layouter" <?=(($input->layout_start_date == null or $input->layout_start_date == '0000-00-00 00:00:00') and $layouters) ? '' : 'disabled';?>><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
        <button title="Mulai proses layout" type="button" class="d-inline btn btn-secondary" id="btn-selesai-layouter" <?=($input->layout_end_date == null or $input->layout_end_date == '0000-00-00 00:00:00' and ($input->layout_start_date != null and $input->layout_start_date != '0000-00-00 00:00:00')) ? '' : 'disabled';?>><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
        <?php endif;?>
        <!-- /.tombol add -->
      </div>
      <!-- /.card-header-control -->
    </div>
    <!-- /.d-flex -->
  </header>
  <?php if ($layouters == null and ($ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan')): ?>
  <div class="alert alert-warning"><strong>PERHATIAN!</strong> Pilih layouter terlebih dahulu sebelum mulai proses layout.</div>
  <?php endif;?>
  <div class="list-group list-group-flush list-group-bordered" id="list-group-layout">
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal mulai</span>
      <strong><?=format_datetime($input->layout_start_date);?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal selesai</span>
      <strong><?=format_datetime($input->layout_end_date);?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Deadline</span>
      <strong><?=($sisa_waktu_layout <= 0 and $input->layout_notes == '' and ($input->layout_start_date != "0000-00-00 00:00:00" and $input->layout_start_date != null)) ? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">' . format_datetime($input->layout_deadline) . '</span>' : format_datetime($input->layout_deadline);?></strong>
    </div>
    <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Layouter</span>
      <strong>
            <?php if ($layouters) {
    foreach ($layouters as $layouter) {
        echo '<span class="badge badge-info p-1">' . $layouter->username . '</span> ';
    }
}
?>
          </strong>
    </div>
    <?php endif;?>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Status</span>
      <?php if ($input->is_layout == 'y'): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->layout_status;?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Layout Selesai</a>
      <?php elseif ($input->is_layout == 'n' and $input->stts == 99): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->layout_status;?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Draft Ditolak</a>
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
      <button title="Aksi admin" class="btn btn-secondary" data-toggle="modal" data-target="#layout_aksi"><i class="fa fa-thumbs-up"></i> Aksi</button>
      <?php endif;?>
      <button type="button" class="btn <?=($input->layout_notes != '' || $input->layout_notes_author != '') ? 'btn-success' : 'btn-outline-success';?>" data-toggle="modal" data-target="#layout" <?=($ceklevel == 'layouter' and $sisa_waktu_layout <= 0 and $input->layout_notes == '') ? 'disabled' : '';?>>Tanggapan Layout
        <?=($input->layout_notes != '' || $input->layout_notes_author != '') ? '<i class="fa fa-check"></i>' : '';?></button>
      <button type="button" class="btn <?=($input->cover_notes != '' || $input->cover_notes_author != '') ? 'btn-success' : 'btn-outline-success';?>" data-toggle="modal" data-target="#cover" <?=($ceklevel == 'layouter' and $sisa_waktu_layout <= 0 and $input->layout_notes == '') ? 'disabled' : '';?>>Tanggapan Cover
        <?=($input->cover_notes != '' || $input->cover_notes_author != '') ? '<i class="fa fa-check"></i>' : '';?></button>
      <?php if ($ceklevel != 'author'): ?>
        <button data-toggle="modal" data-target="#layout-revisi" class="btn btn-outline-info"><i class="fa fa-tasks"></i> Revisi <span class="badge badge-info"><?=$tot_revisi['layouter'];?></span></button>
      <?php endif;?>
      <!-- peringatan disabled -->
      <?=($ceklevel == 'layouter' and $sisa_waktu_layout <= 0 and $input->layout_notes == '' and ($input->layout_start_date != "0000-00-00 00:00:00" and $input->layout_start_date != null)) ? '<span class="font-weight-bold text-danger" data-toggle="tooltip" data-placement="bottom" title="Hubungi admin untuk membuka draft ini"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>' : '';?>
    </div>
    <!-- modal tanggapan layout -->
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
            <p class="font-weight-bold">NASKAH</p>
            <!-- if upload ditampilkan di level tertentu -->
            <?php if ($ceklevel == 'layouter' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
            <?=form_open_multipart('draft/upload_progress/' . $input->draft_id . '/layout_file', 'id="layoutform"');?>
            <div class="alert alert-info">Upload file naskah atau sertakan link naskah. Kosongi jika file naskah hard copy.</div>
            <?=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '';?>
            <!-- .form-group -->
            <div class="form-group ">
              <label for="layout_file">File Naskah</label>
              <!-- .input-group -->
              <div class="custom-file">
                <?=form_upload('layout_file', '', 'class="custom-file-input naskah" id="layout_file"');?>
                <label class="custom-file-label" for="layout_file">Pilih file</label>
              </div>
              <small class="form-text text-muted">Tipe file upload  bertype : idml, indd, indt, pdf, rar, dan zip.</small>
              <!-- /.input-group -->
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="layouter_file_link">Link Naskah</label>
              <div>
                <?=form_input('layouter_file_link', $input->layouter_file_link, 'class="form-control naskah" id="layouter_file_link"');?>
              </div>
              <?=form_error('layouter_file_link');?>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-layout"><i class="fa fa-upload"></i> Upload</button>
            </div>
            <?=form_close();?>
            <?php endif;?>
            <!-- endif upload ditampilkan di level tertentu -->
            <!-- if download ditampilkan di level tertentu -->
            <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
            <!-- keterangan last upload dan tombol download -->
            <div id="modal-layout">
              <p>Last Upload :
                <?=format_datetime($input->layout_upload_date);?>,
                <br> by :
                <?=konversi_username_level($input->layout_last_upload);?>
                <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
                <em>(<?=$input->layout_last_upload;?>)</em>
                <?php endif;?>
              </p>
              <?=(!empty($input->layout_file)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->layout_file . '" href="' . base_url('draftfile/' . $input->layout_file) . '" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '';?>
              <?=(!empty($input->layouter_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->layouter_file_link . '" href="' . $input->layouter_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : '';?>
              <?=(!empty($input->layouter_file_link) or !empty($input->layout_file)) ? '<button data-toggle="tooltip" data-placement="right" title="" data-original-title="hapus file" class="btn btn-danger" id="btn-delete-layout"><i class="fa fa-trash"></i></button>' : '';?>
            </div>
            <?php endif;?>
            <!-- endif download ditampilkan di level tertentu -->
            <hr class="my-3">
            <!-- .form -->
            <?=form_open('draft/ubahnotes/' . $input->draft_id, 'id="formlayout"');?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <label for="cl" class="font-weight-bold">Catatan Layout</label>
                <small class="text-muted" id="layout_last_notes"><?=format_datetime($input->layout_notes_date);?></small>
                <?php
$optionscl = array(
    'name'  => 'layout_notes',
    'class' => 'form-control summernote-basic',
    'id'    => 'cl',
    'rows'  => '6',
    'value' => $input->layout_notes,
);
if ($ceklevel != 'layouter') {
    echo '<div class="font-italic">' . nl2br($input->layout_notes) . '</div>';
} else {
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
    'name'  => 'layout_notes_author',
    'class' => 'form-control summernote-basic',
    'id'    => 'clp',
    'rows'  => '6',
    'value' => $input->layout_notes_author,
);
if ($ceklevel != 'editor') {
    echo '<div class="font-italic">' . nl2br($input->layout_notes_author) . '</div>';
} else {
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
            <?php if ($ceklevel == 'layouter' or $ceklevel == 'editor'): ?>
            <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-layout">Submit</button>
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
    <!-- /.modal tanggapan layout-->
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
            <?php if ($ceklevel == 'layouter' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
            <div class="alert alert-info">Upload file cover atau sertakan link cover.</div>
            <?=form_open_multipart('draft/upload_progress/' . $input->draft_id . '/cover_file', 'id="coverform"');?>
            <?=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '';?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="cover_file">File Cover</label>
              <!-- .input-group -->
              <div class="custom-file">
                <?=form_upload('cover_file', '', 'class="custom-file-input naskah" id="cover_file"');?>
                <label class="custom-file-label" for="cover_file">Pilih file</label>
              </div>
              <small class="form-text text-muted">Tipe file upload  bertype : jpg, jpeg, png, dan pdf.</small>
              <!-- /.input-group -->
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="cover_file_link">Link Cover</label>
              <div>
                <?=form_input('cover_file_link', $input->cover_file_link, 'class="form-control naskah" id="cover_file_link"');?>
              </div>
              <?=form_error('cover_file_link');?>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-cover"><i class="fa fa-upload"></i> Upload</button>
            </div>
            <?=form_close();?>
            <?php endif;?>
            <!-- endif upload ditampilkan di level tertentu -->
            <!-- if download ditampilkan di level tertentu -->
            <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
            <!-- keterangan last upload dan tombol download -->
            <div id="modal-cover">
              <p>Last Upload :
                <?=format_datetime($input->cover_upload_date);?>
                <br> by :
                <?=konversi_username_level($input->cover_last_upload);?>
                <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
                <em>(<?=$input->cover_last_upload;?>)</em>
                <?php endif;?>
              </p>
              <?php if (!empty($input->cover_file)): ?>
              <div class="row">
                <!-- grid column -->
                <div class="col-12 col-sm-4">
                  <!-- .card -->
                  <section class="card card-figure">
                    <!-- .card-figure -->
                    <figure class="figure">
                      <!-- .figure-img -->
                      <div class="figure-img">
                        <img class="img-fluid" src="<?=base_url('coverfile/' . $input->cover_file);?>" alt="Card image cap">
                        <div class="figure-action">
                          <a href="<?=base_url('draft/download/coverfile/' . urlencode($input->cover_file));?>" class="btn btn-block btn-sm btn-primary">Download Cover</a>
                        </div>
                      </div>
                      <!-- /.figure-img -->
                      <!-- .figure-caption -->
                      <figcaption class="figure-caption">
                        <h6 class="figure-title">
                                    <a href="<?=base_url('draft/download/coverfile/' . urlencode($input->cover_file));?>"><?=$input->cover_file;?></a>
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
              <?php endif;?>
              <?=(!empty($input->cover_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->cover_file_link . '" href="' . $input->cover_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : '';?>
            </div>
            <?php endif;?>
            <!-- endif download ditampilkan di level tertentu -->
            <hr class="my-3">
            <!-- .form -->
            <?=form_open('draft/ubahnotes/' . $input->draft_id, 'id="formcover"');?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <label for="cc" class="font-weight-bold">Catatan Cover</label>
                <?php
$optionscc = array(
    'name'  => 'cover_notes',
    'class' => 'form-control summernote-basic',
    'id'    => 'cc',
    'rows'  => '6',
    'value' => $input->cover_notes,
);
if ($ceklevel != 'layouter') {
    echo '<div class="font-italic">' . nl2br($input->cover_notes) . '</div>';
} else {
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
    'name'  => 'cover_notes_author',
    'class' => 'form-control summernote-basic',
    'id'    => 'ccp',
    'rows'  => '6',
    'value' => $input->cover_notes_author,
);
if ($ceklevel != 'editor') {
    echo '<div class="font-italic">' . nl2br($input->cover_notes_author) . '</div>';
} else {
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
            <?php if ($author_order != 0 or $ceklevel != 'author'): ?>
            <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-cover">Submit</button>
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
    <!-- /.modal tanggapan cover-->
    <!-- modal layout revisi-->
    <div class="modal fade" id="layout-revisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title"> Revisi Layout</h5>
          </div>
          <!-- /.modal-header -->
          <!-- .modal-body -->
          <div class="modal-body">
            <!-- #accordion -->
            <div id="accordion-layouter" class="card-expansion">
            </div>
            <!-- /#accordion -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer justify-content-between">
            <button disabled="disabled" class="btn btn-success" id="mulai-revisi-layouter" title="Tanggal mulai revisi dan status draft akan tersimpan" data-toggle="tooltip"><i class="fa fa-plus"></i> Mulai Revisi Baru</button>
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
          <!-- /.modal-footer -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal layout revisi-->
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
            <?=form_open('', '');?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group" id="form-layouter">
                <label for="sel1">Layouter</label>
                <?=form_dropdown('layouter', getDropdownListLayouter('user', ['user_id', 'username']), '', 'id="pilih_layouter" class="form-control custom-select d-block"');?>
                <small class="form-text text-muted">1 untuk layouter dan 1 untuk desain cover</small>
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
              <?php if ($layouters): ?>
              <!-- .table-responsive -->
              <div class="table-responsive">
                <!-- .table -->
                <table class="table table-bordered mb-0 nowrap">
                  <!-- tbody -->
                  <tbody>
                    <?php foreach ($layouters as $layouter): ?>
                    <!-- tr -->
                    <tr>
                      <td class="align-middle">
                        <?=$layouter->username;?>
                      </td>
                      <td class="align-middle text-right" width="20px">
                        <button data-toggle="tooltip" data-placement="right" title="Hapus" href="javascript" class="btn btn-sm btn-danger delete-layouter" data="<?=$layouter->responsibility_id;?>">
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
              <p>Layouter belum dipilih</p>
              <?php endif;?>
            </div>
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal" id="btn-close-layouter">Close</button>
          </div>
          <!-- /.modal-footer -->
          <?=form_close();?>
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
            <?=form_open('draft/ubahnotes/' . $input->draft_id);?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <!-- <label for="layout_deadline">Deadline Layout</label> -->
                <div>
                  <?=form_input('layout_deadline', $input->layout_deadline, 'class="form-control mydate_modal d-none" id="layout_deadline" required=""');?>
                </div>
                <div class="invalid-feedback">Harap diisi</div>
                <?=form_error('layout_deadline');?>
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
          <?=form_close();?>
          <!-- /.form -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal deadline-->
    <!-- modal deadline revisi-->
    <div class="modal fade" id="layout-revisi-deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <!-- .modal-dialog -->
      <div class="modal-dialog" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
          <!-- .modal-header -->
          <div class="modal-header">
            <h5 class="modal-title">Deadline revisi layout</h5>
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
                <!-- <label for="edit_deadline">Deadline Edit</label> -->
                <div>
                  <?=form_input('revision_layout_start_date', '', 'class="form-control mydate_modal d-none" id="revision_layout_start_date" required=""');?>
                </div>
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <!-- <label for="edit_deadline">Deadline Edit</label> -->
                <div>
                  <?=form_input('revision_layout_end_date', '', 'class="form-control mydate_modal d-none" id="revision_layout_end_date" required=""');?>
                </div>
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <!-- <label for="edit_deadline">Deadline Edit</label> -->
                <div>
                  <?=form_input('revision_layout_deadline', '', 'class="form-control mydate_modal d-none" id="revision_layout_deadline" required=""');?>
                </div>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
          </div>
          <!-- /.modal-body -->
          <!-- .modal-footer -->
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" id="btn-layout-revisi-deadline">Pilih</button>
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
            <?=form_open('draft/ubahnotes/' . $input->draft_id);?>
            <!-- .fieldset -->
            <fieldset>
              <!-- .form-group -->
              <div class="form-group">
                <label for="layout_status" class="font-weight-bold">Catatan Admin</label>
                <div class="alert alert-info">
                  Catatan admin dapat dilihat oleh semua user yang terkait dengan draft ini.
                </div>
                <?php
$hidden_date = array(
    'type'  => 'hidden',
    'id'    => 'layout_finish_date',
    'value' => date('Y-m-d H:i:s'),
);
echo form_input($hidden_date);
$layout_status = array(
    'name'  => 'layout_status',
    'class' => 'form-control summernote-basic',
    'id'    => 'crp2',
    'rows'  => '6',
    'value' => $input->layout_status,
);
if ($ceklevel != 'superadmin' and $ceklevel != 'admin_penerbitan') {
    echo '<div class="font-italic">' . nl2br($input->layout_status) . '</div>';
} else {
    echo form_textarea($layout_status);
}
?>
                <div class="alert alert-info">
                  Pilih salah satu tombol dibawah ini: <br>
                  Jika <strong class="text-success">Setuju</strong>, maka tahap layout akan diakhiri dan tanggal selesai layout akan dicatat <br>
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
            <button class="btn btn-success" type="submit" id="layout-setuju" value="12">Setuju</button>
            <button class="btn btn-danger" type="submit" id="layout-tolak" value="99">Tolak</button>
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
    <!-- /.modal -->
  </div>
  <!-- /.card-body -->
</section>
<!-- /.card -->
<script>
$(document).ready(function() {
  //panggil setingan validasi di ugmpress js
  loadValidateSetting();

  //submit dan validasi
  $("#layoutform").validate({
      rules: {
        layout_file: {
          require_from_group: [1, ".naskah"],
          dokumen: "idml|indd|indt|pdf|zip|rar",
          filesize50: 52428200
        },
        layouter_file_link: {
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
        var $this = $('#btn-upload-layout');
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
        let id = $('[name=draft_id]').val();
        var formData = new FormData(form);
        $.ajax({
          url: "<?php echo base_url('draft/upload_progress/'); ?>" + id + "/layout_file",
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
            $('#modal-layout').load(' #modal-layout');
          }
        });
        $resetform = $('#layout_file');
        $resetform.val('');
        $resetform.next('label.custom-file-label').html('');
        return false;
      }
    },
   validateSelect2()
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
          url: "<?php echo base_url('draft/upload_progress/'); ?>" + id + "/cover_file",
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
   validateSelect2()
  );

   //tombol hapus file
   $('#modal-layout').on('click','#btn-delete-layout', function(){
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
    var id = $('input[name=draft_id]').val();
    var jenis = 'layout';
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
        $('#modal-layout').load(' #modal-layout');
        $('#layouter_file_link').val('');
      }
    })
  });

  //pilih layouter
  $('#btn-pilih-layouter').on('click', function() {
    $('.help-block').remove();
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    var layouter = $('#pilih_layouter').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/add/layouter'); ?>",
      datatype: "JSON",
      data: {
        draft_id: draft,
        user_id: layouter
      },
      success: function(data) {
        var datalayouter = JSON.parse(data);
        console.log(datalayouter);
        if (!datalayouter.validasi) {
          $('#form-layouter').append('<div class="text-danger help-block">layouter sudah dipilih</div>');
          toastr_view('44');
        } else if (datalayouter.validasi == 'max') {
          toastr_view('97');
        } else {
          toastr_view('7');
        }
        $('[name=layouter]').val("");
        $('#reload-layouter').load(' #reload-layouter');
        //$('#list-group-layout').load(' #list-group-layout');
        $this.removeAttr("disabled").html("Pilih");
      }

    });
    return false;
  });

  //tombol kerjakan layouter
  $('#btn-mulai-layouter').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/mulai_proses/layouter'); ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        col: 'layout_start_date'
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
        $('#list-group-layout').load(' #list-group-layout');
        $this.removeAttr("disabled").html('<i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span>');
        $this.addClass('disabled');
        $this.attr("disabled", "disabled");
        location.reload();
      }

    });
    return false;
  });

   //tombol selesai proses layouter
  $('#btn-selesai-layouter').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/selesai_proses/layouter'); ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        col: 'layout_end_date'
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
        $('#list-group-layout').load(' #list-group-layout');
        $this.removeAttr("disabled").html('<i class="fas fa-stop"></i><span class="d-none d-md-inline"> Selesai</span>');
        $this.addClass('disabled');
        $this.attr("disabled", "disabled");
        //location.reload();
      }

    });
    return false;
  });

  //hapus layouter
  $('#reload-layouter').on('click', '.delete-layouter', function() {
    $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
    var id = $(this).attr('data');
    console.log(id);
    $.ajax({
      url: "<?php echo base_url('responsibility/delete/'); ?>" + id,
      success: function(data) {
        console.log(data);
        //$('#reload-layouter').load(' #reload-layouter');
        toastr_view('8');
        //$('#list-group-layout').load(' #list-group-layout');
      }

    })
  });

  $('#btn-submit-layout').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let cl = $('#cl').val();
    let clp = $('#clp').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        layout_notes: cl,
        layout_notes_date: true,
        layout_notes_author: clp
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
        $('#list-group-layout').load(' #list-group-layout');
        $('#layout_last_notes').html(datax.layout_notes_date);
        $('#layout').modal('toggle');
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
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
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
        $('#list-group-layout').load(' #list-group-layout');
        $('#cover').modal('toggle');
      }
    });
    return false;
  });


  $('#layout-setuju').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let layout_status = $('[name=layout_status]').val();
    let action = $('#layout-setuju').val();
    let end_date = $('#layout_finish_date').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        layout_status: layout_status,
        draft_status: action,
        proofread_start_date: end_date,
        is_layout: 'y',
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
        $('#list-group-layout').load(' #list-group-layout');
        location.reload();
      }
    });

    // $('#layout_aksi').modal('hide');
    return false;
  });

  $('#layout-tolak').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let layout_status = $('[name=layout_status]').val();
    let action = $('#layout-tolak').val();
    let end_date = $('#layout_finish_date').val();

    console.log(end_date);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        layout_status: layout_status,
        draft_status: action,
        is_layout: 'n'
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
        $('#list-group-layout').load(' #list-group-layout');
        location.reload();
      }
    });

    // $('#layout_aksi').modal('hide');
    return false;
  });

  //layout deadline
  $('#btn-layout-deadline').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let ld = $('[name=layout_deadline]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        layout_deadline: ld
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
        $('#list-group-layout').load(' #list-group-layout');
        $('#layout_deadline').modal('toggle');
      }
    });
    return false;
  });

  //load data ketika modal dibuka
  $('#layout-revisi').on('shown.bs.modal', function (e) {
    load_revisi_layout();
  })

  //kosongkan modal ketika close
  $('#layout-revisi').on('hidden.bs.modal', function (e) {
    $('#accordion-layouter').html('');
  })

  //gantian modal revisi dan deadline revisi
  // $('#layout-revisi-deadline').on('shown.bs.modal', function (e) {
  //   $('#layout-revisi').modal('toggle');
  // })
  $('#layout-revisi-deadline').on('hidden.bs.modal', function (e) {
    load_revisi_layout();
  })

  $('#accordion-layouter').on('click', '.trigger-layout-revisi-deadline',function(e){
    var revision_id = $(this).attr('data');
    $('#revision_id').val(revision_id);

  });

  $('#btn-layout-revisi-deadline').on('click', function (e) {
        var revision_id = $('#revision_id').val();
        e.preventDefault();
        let revision_layout_deadline = $('[name=revision_layout_deadline]').val();
        let revision_layout_start_date = $('[name=revision_layout_start_date]').val();
        let revision_layout_end_date = $('[name=revision_layout_end_date]').val();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('draft/deadlineRevision'); ?>",
          datatype: "JSON",
          data: {
            revision_id: revision_id,
            revision_deadline: revision_layout_deadline,
            revision_start_date: revision_layout_start_date,
            revision_end_date: revision_layout_end_date,
          },
          success: function(data){
            let datax = JSON.parse(data);
            console.log(datax);
            if (datax.status == true) {
              toastr_view('111');
            } else {
              toastr_view('000');
            }
            $('#layout-revisi-deadline').modal('toggle');
          }
        })
      })


  function load_revisi_layout(){
    let draft_id = $('[name=draft_id]').val();
    $('#accordion-layouter').html('<i class="fa fa-spinner fa-spin"></i> Loading data...');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/getRevision'); ?>",
      datatype: "JSON",
      data:{
        draft_id: draft_id,
        role: 'layouter'
      },
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax.flag);
        if(datax.flag != true){
          $('#mulai-revisi-layouter').removeAttr('disabled');
        }
        var i;
        if(datax.revisi.length>0){
          for(i=0; i<datax.revisi.length; i++){
            $('#accordion-layouter').html(datax.revisi);
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
          $('#accordion-layouter').html(datax.revisi);
        }

      }
    });
  }



  $('#accordion-layouter').on('click', '.selesai-revisi',function(){
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
        load_revisi_layout();
      }
    })
  });

  $('#accordion-layouter').on('click', '.submit-revisi',function(){
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

  $('#accordion-layouter').on('click', '.hapus-revisi',function(){
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
        load_revisi_layout();
      }
    })
  });


  $('#mulai-revisi-layouter').on('click', function(){
    $(this).attr("disabled", "disabled");
    $(this).tooltip('dispose');
    let draft_id = $('[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/insertRevision'); ?>",
      datatype: "JSON",
      data:{
        draft_id: draft_id,
        role: 'layouter'
      },
      success: function(data){
        let datax = JSON.parse(data);
        console.log(datax);
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        load_revisi_layout();
      }
    })
  });

  //tombol close modal layouter
  $('#btn-close-layouter').on('click', function() {
    location.reload();
  });

})
</script>