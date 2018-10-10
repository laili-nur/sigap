  <?php $ceklevel = $this->session->userdata('level'); ?>
  <!-- .card -->
  <section id="progress-review" class="card" >
    <!-- .card-header -->
    <header class="card-header">
      <!-- .d-flex -->
      <div class="d-flex align-items-center">
        <span class="mr-auto">Review</span>
        <!-- .card-header-control -->
        <div class="card-header-control">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <!-- .tombol add -->
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review_deadline">Atur Deadline</button>
          <!-- /.tombol add -->
          <?php endif ?>
        </div>
        <!-- /.card-header-control -->
      </div>
      <!-- /.d-flex -->
    </header>
     <div class="list-group list-group-flush list-group-bordered" id="list-group-review">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong><?= konversiTanggal($input->review_start_date) ?></strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong><?= konversiTanggal($input->review_end_date) ?></strong>
          </div>
          <?php if($reviewer_order=='0' or $reviewer_order!='1'): ?>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Deadline reviewer 1</span>
            <strong><?= konversiTanggal($input->review1_deadline) ?></strong>
          </div>
          <?php endif ?>
          <?php if($reviewer_order=='1' or $reviewer_order!='0'): ?>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Deadline reviewer 2</span>
            <strong><?= konversiTanggal($input->review2_deadline) ?></strong>
          </div>
          <?php endif ?>
          <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer' ): ?>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Reviewer</span>
            <div>
              <?php if ($reviewers) {
                foreach ($reviewers as $reviewer){
                  echo '<span class="badge badge-info p-1">'.$reviewer->reviewer_name.'</span> ';
                }
              }
              ?>
            </div>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Rekomendasi Reviewer</span>
            <div>
              <?php 
              if($input->review1_flag != ''){
                if($input->review1_flag == 'y'){
                  echo '<span class="badge badge-success p-1">1. Setuju</span> ';
                }else{
                  echo '<span class="badge badge-danger p-1">1. Menolak</span> ';
                }
              }
              if($input->review2_flag != ''){
                if($input->review2_flag == 'y'){
                  echo '<span class="badge badge-success p-1">2. Setuju</span> ';
                }else{
                  echo '<span class="badge badge-danger p-1">2. Menolak</span> ';
                }
              }
               ?>
            </div>
          </div>
          <?php endif ?>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Status</span>
            <?php if($input->is_review == 'y'): ?>
            <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->review_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Review Selesai</a>
            <?php elseif($input->is_review == 'n' and $input->stts == 99): ?>
            <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->review_status ?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Draft ditolak</a>
            <?php else: ?>
              -
            <?php endif ?>
            
    
          </div>
          <hr class="m-0">
      </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example ">
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
        <button class="btn btn-secondary" style="width:50px" data-toggle="modal" data-target="#review_aksi"><i class="fa fa-thumbs-up"></i></button>
        <!-- <button class="btn btn-danger" style="width:50px"><i class="fa fa-times"></i></button> -->
        <?php endif ?>
        <?php if($reviewer_order=='0' or $reviewer_order!='1'): ?>       
          <button type="button" class="btn <?=($input->review1_notes!='' || $input->review1_notes_author!='')? 'btn-success' : 'btn-outline-success' ?>" data-toggle="modal" data-target="#review1">Tanggapan Review 1 <?=($input->review1_notes!='' || $input->review1_notes_author!='')? '<i class="fa fa-check"></i>' : '' ?></button>
        <?php endif ?>
        <?php if($reviewer_order=='1' or $reviewer_order!='0'): ?>
          <button type="button" class="btn <?=($input->review2_notes!='' || $input->review2_notes_author!='')? 'btn-success' : 'btn-outline-success' ?>" data-toggle="modal" data-target="#review2">Tanggapan Review 2 <?=($input->review2_notes!='' || $input->review2_notes_author!='')? '<i class="fa fa-check"></i>' : '' ?></button>
        <?php endif ?>
      </div>
        <!-- modal -->
        <div class="modal fade" id="review1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Review 1</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/review1_file', 'novalidate'); ?>
                  <p class="font-weight-bold">NASKAH</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="review1_file">File Naskah</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('review1_file','','class="custom-file-input"') ?> 
                          <label class="custom-file-label" for="tf3">Choose file</label>
                          <div class="invalid-feedback">Field is required</div>
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit" value="Submit" id="btn-upload-review1"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                      </div>
                      <!-- /.input-group -->
                    </div>
                    <!-- /.form-group -->
                <?= form_close(); ?>
                <p>Last Upload: <?=konversiTanggal($input->review1_upload_date) ?></p>
                <?=(!empty($input->review1_file))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->review1_file.'" href="'.base_url('draftfile/'.$input->review1_file).'" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '' ?>
                <hr class="my-3">
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/review1_template', 'novalidate'); ?>
                  <p class="font-weight-bold">REVIEW</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="review1_template">File Review</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('review1_template','','class="custom-file-input"') ?> 
                          <label class="custom-file-label" for="tf3">Choose file</label>
                          <div class="invalid-feedback">Field is required</div>
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit" value="Submit" id="btn-upload-review1-template"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                      </div>
                      <!-- /.input-group -->
                    </div>
                    <!-- /.form-group -->
                <?= form_close(); ?>
                <a href="#">Download file template review</a>
                <hr class="my-3">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id,'id="formreview1"') ?>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cr1" class="font-weight-bold">Catatan Reviewer 1</label>
                      <?php 
                      $optionscr1 = array(
                          'name' => 'review1_notes',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'cr1',
                          'rows' => '6',
                          'value'=> $input->review1_notes
                      );
                      if($ceklevel!='reviewer'){
                        echo '<div class="font-italic">'.nl2br($input->review1_notes).'</div>';
                      }else{
                        echo form_textarea($optionscr1);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr class="my-3">
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="crp1" class="font-weight-bold">Catatan Penulis</label>
                      <?php 
                      $optionscrp1 = array(
                          'name' => 'review1_notes_author',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'crp1',
                          'rows' => '6',
                          'value'=> $input->review1_notes_author
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->review1_notes_author).'</div>';
                      }else{
                        echo form_textarea($optionscrp1);
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
                <?php if($ceklevel=='reviewer'): ?>
                <div class="card-footer-content text-muted p-0 m-0">
                  <div class="mb-1 font-weight-bold">Rekomendasi (Pilih jika sudah final)</div> 
                  <div class="custom-control custom-control-inline custom-radio">
                    <?= form_radio('review1_flag', 'y', isset($input->review1_flag) && ($input->review1_flag == 'y') ? true : false,'required class="custom-control-input" id="review1_flagy"')?>
                    <label class="custom-control-label" for="review1_flagy">Setuju</label>
                  </div>
                  <div class="custom-control custom-control-inline custom-radio">
                    <?= form_radio('review1_flag', 'n', isset($input->review1_flag) && ($input->review1_flag == 'n') ? true : false,'required class="custom-control-input" id="review1_flagn"')?>
                    <label class="custom-control-label" for="review1_flagn">Tidak</label>
                  </div>
                </div>
                <?php endif ?>
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-review1">Submit</button>
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
      <!-- modal -->
        <div class="modal fade" id="review2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Review 2</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/review2_file', 'novalidate'); ?>
                  <p class="font-weight-bold">NASKAH</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="review2_file">File Naskah</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('review2_file','','class="custom-file-input"') ?> 
                          <label class="custom-file-label" for="review2_file">Choose file</label>
                          <div class="invalid-feedback">Field is required</div>
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit" value="Submit" id="btn-upload-review2"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                      </div>
                      <!-- /.input-group -->
                    </div>
                    <!-- /.form-group -->
                <?= form_close(); ?>
                <p>Last Upload: <?=konversiTanggal($input->review2_upload_date) ?></p>
                <?=(!empty($input->review2_file))? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="'.$input->review2_file.'" href="'.base_url('draftfile/'.$input->review2_file).'" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '' ?>
                <hr class="my-3">
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/review2_template', 'novalidate'); ?>
                  <p class="font-weight-bold">REVIEW</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="review2_template">File Review</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('review2_template','','class="custom-file-input"') ?> 
                          <label class="custom-file-label" for="tf3">Choose file</label>
                          <div class="invalid-feedback">Field is required</div>
                        </div>
                        <div class="input-group-append">
                          <button class="btn btn-primary" type="submit" value="Submit" id="btn-upload-review2-template"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                      </div>
                      <!-- /.input-group -->
                    </div>
                    <!-- /.form-group -->
                <?= form_close(); ?>
                <a href="#">Download file template review</a>
                <hr class="my-3">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id,'id="formreview2"') ?>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cr2" class="font-weight-bold">Catatan Reviewer 2</label>
                      <?php 
                      $optionscr2 = array(
                          'name' => 'review2_notes',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'cr2',
                          'rows' => '6',
                          'value'=> $input->review2_notes
                      );
                      if($ceklevel!='reviewer'){
                        echo '<div class="font-italic">'.nl2br($input->review2_notes).'</div>';
                      }else{
                        echo form_textarea($optionscr2);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="crp2" class="font-weight-bold">Catatan Penulis</label>
                      <?php 
                      $optionscrp2 = array(
                          'name' => 'review2_notes_author ',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'crp2',
                          'rows' => '6',
                          'value'=> $input->review2_notes_author
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->review2_notes_author).'</div>';
                      }else{
                        echo form_textarea($optionscrp2);
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
                <?php if($ceklevel=='reviewer'): ?>
                <div class="card-footer-content text-muted p-0 m-0">
                  <div class="mb-1 font-weight-bold">Rekomendasi (Pilih jika sudah final)</div> 
                  <div class="custom-control custom-control-inline custom-radio">
                    <?= form_radio('review2_flag', 'y', isset($input->review2_flag) && ($input->review2_flag == 'y') ? true : false,'required class="custom-control-input" id="review2_flagy"')?>
                    <label class="custom-control-label" for="review2_flagy">Setuju</label>
                  </div>
                  <div class="custom-control custom-control-inline custom-radio">
                    <?= form_radio('review2_flag', 'n', isset($input->review2_flag) && ($input->review2_flag == 'n') ? true : false,'required class="custom-control-input" id="review2_flagn"')?>
                    <label class="custom-control-label" for="review2_flagn">Tidak</label>
                  </div>
                </div>
                <?php endif ?>
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-review2">Submit</button>
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
        <div class="modal fade" id="review_deadline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title">Deadline Review</h5>
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
                    <label for="review1_deadline">Deadline Reviewer 1</label>
                    <div>
                      <?= form_input('review1_deadline', $input->review1_deadline, 'class="form-control mydate_modal d-none" id="review1_deadline" required=""') ?>
                    </div>
                    
                      <div class="invalid-feedback">Harap diisi</div>
                      <?= form_error('review1_deadline') ?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                    <label for="review2_deadline">Deadline Reviewer 2</label>
                    <div>
                      <?= form_input('review2_deadline', $input->review2_deadline, 'class="form-control mydate_modal d-none" id="review2_deadline" required="" ') ?>
                    </div>
                      <div class="invalid-feedback">Harap diisi</div>
                      <?= form_error('review2_deadline') ?>
                  </div>
                  <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="btn-review-deadline">Pilih</button>
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
        <div class="modal fade" id="review_aksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <label for="review_status" class="font-weight-bold">Catatan Admin</label>
                      <?php 
                      $hidden_date = array(
                          'type'  => 'hidden',
                          'id'    => 'review_end_date',
                          'value' => date('Y-m-d H:i:s')
                      );
                      echo form_input($hidden_date);
                      $review_status = array(
                          'name' => 'review_status',
                          'class'=> 'form-control summernote-basic',
                          'id'  => 'crp2',
                          'rows' => '6',
                          'value'=> $input->review_status
                      );
                      if($ceklevel!='superadmin'){
                        echo '<div class="font-italic">'.nl2br($input->review_status).'</div>';
                      }else{
                        echo form_textarea($review_status);
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
                <button class="btn btn-success" type="submit" id="review-setuju" value="5">Setuju</button>
                <button class="btn btn-danger" type="submit" id="review-tolak" value="99">Tolak</button>
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
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->

  <script>
    $(document).ready(function(){
      $('#btn-submit-review1').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let cr1=$('#cr1').val();
        let crp1=$('#crp1').val();
        let rev1_flag=$('[name=review1_flag]:checked').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            review1_notes : cr1,
            review1_notes_author : crp1,
            review1_flag : rev1_flag,
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
            $('#list-group-review').load(' #list-group-review');
          }
        });
        return false;
      });

      $('#btn-submit-review2').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let cr2=$('#cr2').val();
        let crp2=$('#crp2').val();
        let rev2_flag=$('[name=review2_flag]:checked').val();
        console.log(rev2_flag);
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            review2_notes : cr2,
            review2_notes_author : crp2,
            review2_flag : rev2_flag,

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
            $('#list-group-review').load(' #list-group-review');
          }
        });
        return false;
      });

      $('#review-setuju').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let review_status=$('[name=review_status]').val();
        let action=$('#review-setuju').val();
        let end_date=$('#review_end_date').val();
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              review_status : review_status,
              draft_status : action,
              review_end_date : end_date,
              is_review : 'y'
            },
            success :function(data){
              let datax = JSON.parse(data);
              console.log(datax)
              $this.removeAttr("disabled").html("Setuju");
              if(datax.status == true){
                toastr_view('111');
              }else{
                toastr_view('000');
              }
                $('#list-group-review').load(' #list-group-review');
            }
          });

          // $('#review_aksi').modal('hide');
          // location.reload();
          return false;
      });

      $('#review-tolak').on('click', function() {
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let review_status=$('[name=review_status]').val();
        let action=$('#review-tolak').val();
        let end_date=$('#review_end_date').val();

              console.log(end_date);
        $.ajax({
            type : "POST",
            url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
            datatype : "JSON",
            data : {
              review_status : review_status,
              draft_status : action,
              review_end_date : end_date,
              is_review : 'n'
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
              $('#list-group-review').load(' #list-group-review');
            }
          });

          // $('#review_aksi').modal('hide');
          // location.reload();
          return false;
      });

    //   $('#cr2').summernote({
    //   placeholder: 'Write here...',
    //   height: 200,
    //   disableDragAndDrop: true,
    //   toolbar: [
    //     ['style', ['bold', 'italic', 'underline', 'clear']],
    //     ['font', ['strikethrough']],
    //     ['fontsize', ['fontsize','height']],
    //     ['para', ['ul', 'ol', 'paragraph']],
    //     ['height', ['height']],
    //     ['view', ['codeview']],
    //   ],
      
    // });

    })
  </script>