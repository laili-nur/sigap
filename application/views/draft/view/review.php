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
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Deadline reviewer 1</span>
            <strong><?= konversiTanggal($input->review1_deadline) ?></strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Deadline reviewer 2</span>
            <strong><?= konversiTanggal($input->review2_deadline) ?></strong>
          </div>
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
          <?php endif ?>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Status</span>
            <strong></strong>
          </div>
          <hr class="m-0">
      </div>
    <!-- .card-body -->
    <div class="card-body">
      <div class="el-example ">
        <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
        <button class="btn btn-success" style="width:50px"><i class="fa fa-check"></i></button>
        <button class="btn btn-danger" style="width:50px"><i class="fa fa-times"></i></button>
        <?php endif ?>
        <?php if($reviewer_order=='0'): ?>       
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review1">Review dan Tanggapan 1</button>
        <?php elseif($reviewer_order=='1'): ?>
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review2">Review dan Tanggapan 2</button>
        <?php else: ?>
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review1">Review dan Tanggapan 1</button>
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review2">Review dan Tanggapan 2</button>
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
                  <p class="font-weight-bold">UPLOAD</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="review1_file">File Review</label>
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
                <hr class="my-3">
                <?=(!empty($input->review1_file))? '<a href="'.base_url('draftfile/'.$input->review1_file).'" class="btn btn-success"><i class="fa fa-download"></i> '.$input->review1_file.'</a>' : '' ?>
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
                          'class'=> 'form-control',
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
                          'class'=> 'form-control',
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
                  <p class="font-weight-bold">UPLOAD</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="review2_file">File Review</label>
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
                <hr class="my-3">
                <?=(!empty($input->review2_file))? '<a href="'.base_url('draftfile/'.$input->review2_file).'" class="btn btn-success"><i class="fa fa-download"></i> '.$input->review2_file.'</a>' : '' ?>
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
                          'class'=> 'form-control',
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
                          'name' => 'review2_notes_author',
                          'class'=> 'form-control',
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
                      <?= form_input('review1_deadline', $input->review1_deadline, 'class="form-control mydate" id="review1_deadline" required=""') ?>
                    </div>
                      <div class="invalid-feedback">Harap diisi</div>
                      <?= form_error('review1_deadline') ?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                    <label for="review2_deadline">Deadline Reviewer 2</label>
                    <div>
                      <?= form_input('review2_deadline', $input->review2_deadline, 'class="form-control mydate" id="review2_deadline" required=""') ?>
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
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            review1_notes : cr1,
            review1_notes_author : crp1
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

      $('#btn-submit-review2').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let cr2=$('#cr2').val();
        let crp2=$('#crp2').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            review2_notes : cr2,
            review2_notes_author : crp2
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


    })
  </script>