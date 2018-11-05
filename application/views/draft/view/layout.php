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
          <button type="button" class="btn <?=($layouters==null)? 'btn-warning' : 'btn-secondary' ?>" data-toggle="modal" data-target="#pilihlayouter">Pilih Layouter</button>
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#layout_deadline">Atur Deadline</button>
          <?php endif ?>
          <?php if($ceklevel == 'layouter'): ?>
          <button type="button" class="btn btn-warning" id="btn-kerjakan-layouter">Mulai Proses</button>
          <?php endif ?>
          <!-- /.tombol add -->
        </div>
        <!-- /.card-header-control -->
      </div>
      <!-- /.d-flex -->
    </header>
    <?php if($layouters == null): ?>
    <div class="alert alert-warning"><strong>PERHATIAN!</strong> Pilih layouter terlebih dahulu sebelum lanjut ke tahap selanjutnya.</div>
    <?php endif ?>
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
        <?php if($input->is_layout == 'y'): ?>
        <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->layout_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Layout Selesai</a>
        <?php elseif($input->is_layout == 'n' and $input->stts == 99): ?>
        <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->layout_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Draft Ditolak</a>
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
        <button title="Aksi admin" class="btn btn-secondary" style="width:50px" data-toggle="modal" data-target="#layout_aksi"><i class="fa fa-thumbs-up"></i></button>
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
                  <p class="font-weight-bold">NASKAH</p>
                  <!-- if upload ditampilkan di level tertentu -->
                  <?php if($ceklevel=='layouter' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
                  <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/layout_file', 'id="layoutform"'); ?>
                  <div class="alert alert-info">Upload file naskah atau sertakan link naskah. Kosongi jika file naskah hard copy.</div>
                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                    <!-- .form-group -->
                      <div class="form-group ">
                        <label for="layout_file">File Naskah</label>
                        <!-- .input-group -->
                          <div class="custom-file">
                            <?= form_upload('layout_file','','class="custom-file-input naskah" id="layout_file"') ?> 
                            <label class="custom-file-label" for="layout_file">Choose file</label>
                          </div>
                        <small class="form-text text-muted">Tipe file upload  bertype : docx, doc, dan pdf.</small>
                        <!-- /.input-group -->
                      </div>
                      <!-- /.form-group -->
                      <!-- .form-group -->
                    <div class="form-group">
                      <label for="layouter_file_link">Link Naskah</label>
                      <div>
                        <?= form_input('layouter_file_link', $input->layouter_file_link, 'class="form-control naskah" id="layouter_file_link"') ?>
                      </div>
                        <?= form_error('layouter_file_link') ?>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                      <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-layout"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                  <?= form_close(); ?>
                  <?php endif ?>
                  <!-- endif upload ditampilkan di level tertentu -->
                  
                  <!-- if download ditampilkan di level tertentu -->
                  <?php if($ceklevel!='author' and $ceklevel != 'reviewer' ): ?>
                  <!-- keterangan last upload dan tombol download -->
                  <div id="modal-layout">
                  <p>Last Upload : <?=konversiTanggal($input->layout_upload_date) ?>, 
                    <br> by : <?=konversi_username_level($input->layout_last_upload) ?>
                    <?php  if($ceklevel !='author' and $ceklevel !='reviewer'):?>
                      <em>(<?=$input->layout_last_upload ?>)</em>
                    <?php endif ?>
                  </p>
                  <?=(!empty($input->layout_file))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->layout_file.'" href="'.base_url('draftfile/'.$input->layout_file).'" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '' ?>
                  <?=(!empty($input->layouter_file_link))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->layouter_file_link.'" href="'.$input->layouter_file_link.'" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : '' ?>
                  </div>
                  <?php endif ?>
                  <!-- endif download ditampilkan di level tertentu -->
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
                <?php if($author_order!=0 or $ceklevel!='author'): ?>
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-layout">Submit</button>
                <?php endif ?>
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
                <!-- if upload ditampilkan di level tertentu -->
                <?php if($ceklevel=='layouter' or $ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
                <p class="font-weight-bold">COVER</p>
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
                  <p>Last Upload : <?=konversiTanggal($input->cover_upload_date) ?>, 
                  <br> by : <?=konversi_username_level($input->cover_last_upload) ?>
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
                <hr class="my-3">
                <?php endif ?>
                <!-- endif download ditampilkan di level tertentu -->
                
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
                    <?php if ($layouters):?>
                    <!-- .table-responsive -->
                      <div class="table-responsive">
                        <!-- .table -->
                        <table class="table table-bordered mb-0 nowrap">
                          <!-- tbody -->
                          <tbody>
                            <?php foreach($layouters as $layouter): ?>
                            <!-- tr -->
                            <tr>
                              <td class="align-middle"><?= $layouter->username ?></td>
                              <td class="align-middle text-right" width="20px">
                                <button data-toggle="tooltip" data-placement="right" title="Hapus" href="javascript" class="btn btn-sm btn-danger delete-layouter" data="<?= $layouter->responsibility_id ?>">
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
                <button type="button" class="btn btn-light" data-dismiss="modal" id="btn-close-layouter">Close</button>
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
                <button class="btn btn-success" type="submit" id="layout-setuju" value="12">Setuju</button>
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
      //panggil setingan validasi di ugmpress js
      setting_validasi();

      //submit dan validasi
      $("#layoutform").validate({
          rules: {
            layout_file: {
              require_from_group: [1, ".naskah"],
              dokumen: "docx|doc|pdf",
              filesize50: 52428200
            },
            layouter_file_link : {
              curl : true,
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
                var $this = $('#btn-upload-layout');
                $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
                let id=$('[name=draft_id]').val();
                var formData = new FormData(form);
                $.ajax({
                    url : "<?php echo base_url('draft/upload_progress/') ?>"+id+"/layout_file",
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
                      $('#modal-layout').load(' #modal-layout');
                    }
                  });
                $resetform = $('#layout_file');
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
            cover_file_link : {
              curl : true,
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
                var $this = $('#btn-upload-cover');
                $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
                let id=$('[name=draft_id]').val();
                var formData = new FormData(form);
                $.ajax({
                    url : "<?php echo base_url('draft/upload_progress/') ?>"+id+"/cover_file",
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

      //pilih layouter
    $('#btn-pilih-layouter').on('click',function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var layouter = $('#pilih_layouter').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('responsibility/add/layouter') ?>",
        datatype : "JSON",
        data : {
          draft_id : draft,
          user_id : layouter
        },
        success :function(data){
          var datalayouter = JSON.parse(data);
          console.log(datalayouter);
          if(!datalayouter.validasi){
            $('#form-layouter').append('<div class="text-danger help-block">layouter sudah dipilih</div>');
            toastr_view('44');
          }else if(datalayouter.validasi == 'max'){
            toastr_view('97');
          }else{
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

    //tombol kerjakan editor
    $('#btn-kerjakan-layouter').on('click',function(){
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('responsibility/mulai_proses/') ?>",
        datatype : "JSON",
        cache:false,
        data : {
          draft_id : draft,
          col : 'layout_start_date'
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
          $('#list-group-layout').load(' #list-group-layout');
          $this.removeAttr("disabled").html("Mulai Proses");
        }

      });
      return false;
    });

    //hapus layouter
    $('#reload-layouter').on('click','.delete-layouter',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('responsibility/delete/') ?>"+id,
          success : function(data){
            console.log(data);
            $('#reload-layouter').load(' #reload-layouter');
            toastr_view('8');
            //$('#list-group-layout').load(' #list-group-layout');
          }

        })
    });

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
            $('#list-group-layout').load(' #list-group-layout');
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
            cover_notes_author : ccp,
            draft_status : 10,
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
            $('#list-group-layout').load(' #list-group-layout');
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
              proofread_start_date : end_date,
              is_layout : 'y',
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
              $('#list-group-layout').load(' #list-group-layout');
              location.reload();
            }
          });

          // $('#layout_aksi').modal('hide');
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
              is_layout : 'n'
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
              $('#list-group-layout').load(' #list-group-layout');
              location.reload();
            }
          });

          // $('#layout_aksi').modal('hide');
          return false;
      });

      //layout deadline
    $('#btn-layout-deadline').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let ld=$('[name=layout_deadline]').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            layout_deadline : ld
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
             $('#list-group-layout').load(' #list-group-layout');
             $('#layout_deadline').modal('toggle');
          }
        });
        return false;
      });

    $('#btn-close-layouter').on('click',function(){
      location.reload();
    });

    })
  </script>