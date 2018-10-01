<?php $ceklevel = $this->session->userdata('level'); ?>
<!-- .card -->
  <section id="progress-proofread" class="card">
    <!-- .card-header -->
    <header class="card-header">Proofread</header>
    <div class="list-group list-group-flush list-group-bordered">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong><?= konversiTanggal($input->proofread_start_date) ?></strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong><?= konversiTanggal($input->proofread_end_date) ?></strong>
          </div>
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
        <button class="btn btn-success" style="width:50px"><i class="fa fa-check"></i></button>
        <button class="btn btn-danger" style="width:50px"><i class="fa fa-times"></i></button>    
        <?php endif ?>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#proofread">Proofread dan Tanggapan</button>
        <!-- modal -->
        <div class="modal fade" id="proofread" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <!-- .modal-dialog -->
          <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
            <!-- .modal-content -->
            <div class="modal-content">
              <!-- .modal-header -->
              <div class="modal-header">
                <h5 class="modal-title"> Progress Proofread</h5>
              </div>
              <!-- /.modal-header -->
              <!-- .modal-body -->
              <div class="modal-body">
                <?= form_open_multipart('draft/upload_progress/'.$input->draft_id.'/proofread_file', 'novalidate'); ?>
                  <p class="font-weight-bold">UPLOAD</p>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                  <!-- .form-group -->
                    <div class="form-group">
                      <label for="proofread_file">File Review</label>
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <div class="custom-file">
                          <?= form_upload('proofread_file','','class="custom-file-input"') ?> 
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
                <?=(!empty($input->proofread_file))? '<a href="'.base_url('draftfile/'.$input->proofread_file).'" class="btn btn-success"><i class="fa fa-download"></i> '.$input->proofread_file.'</a>' : '' ?>
                <hr class="my-3">
                <!-- .form -->
                <?= form_open('draft/ubahnotes/'.$input->draft_id,'id="formproofread"') ?>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cpr" class="font-weight-bold">Catatan Proofread</label>
                      <?php 
                      $optionscpr = array(
                          'name' => 'proofread_notes',
                          'class'=> 'form-control',
                          'id'  => 'cpr',
                          'rows' => '6',
                          'value'=> $input->proofread_notes
                      );
                      if($ceklevel=='author'){
                        echo '<div class="font-italic">'.nl2br($input->proofread_notes).'</div>';
                      }else{
                        echo form_textarea($optionscpr);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cprp" class="font-weight-bold">Catatan Penulis</label>
                      <?php 
                      $optionscprp = array(
                          'name' => 'proofread_notes_author',
                          'class'=> 'form-control',
                          'id'  => 'cprp',
                          'rows' => '6',
                          'value'=> $input->proofread_notes_author
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->proofread_notes_author).'</div>';
                      }else{
                        echo form_textarea($optionscprp);
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
                <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-proofread">Submit</button>
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
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->

  <script>
    $(document).ready(function(){
      $('#btn-submit-proofread').on('click',function(){
        var $this = $(this);
        $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id=$('[name=draft_id]').val();
        let cpr=$('#cpr').val();
        let cprp=$('#cprp').val();
        $.ajax({
          type : "POST",
          url : "<?php echo base_url('draft/ubahnotes/') ?>"+id,
          datatype : "JSON",
          data : {
            proofread_notes : cpr,
            proofread_notes_author : cprp
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