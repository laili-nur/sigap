  <?php $ceklevel = $this->session->userdata('level'); ?>
  <!-- .card -->
  <section id="progress-review" class="card">
    <!-- .card-header -->
    <header class="card-header">Review</header>
     <div class="list-group list-group-flush list-group-bordered">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong><?= konversiTanggal($input->review_start_deadline) ?></strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong><?= konversiTanggal($input->review_end_deadline) ?></strong>
          </div>
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
        <button class="btn btn-success"><i class="fa fa-check"></i></button>
        <?php endif ?>       
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review1">Lihat Detail Review 1</button>
        <!-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#review2">Lihat Detail Review 2</button> -->
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
                <button type="button" class="btn btn-secondary"><i class="fa fa-download"></i> Download File</button>
                <button type="button" class="btn btn-secondary"><i class="fa fa-upload"></i> Upload File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cr1" class="font-weight-bold">Catatan Reviewer 1</label>
                      <?php 
                      $optionscr1 = array(
                          'name' => 'review_notes',
                          'class'=> 'form-control',
                          'id'  => 'cr1',
                          'rows' => '6',
                          'value'=> $input->review_notes
                      );
                      if($ceklevel!='reviewer'){
                        echo '<div class="font-italic">'.nl2br($input->review_notes).'</div>';
                      }else{
                        echo form_textarea($optionscr1);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="crp1" class="font-weight-bold">Catatan Penulis</label>
                      <?php 
                      $optionscrp1 = array(
                          'name' => 'author_review_notes',
                          'class'=> 'form-control',
                          'id'  => 'crp1',
                          'rows' => '6',
                          'value'=> $input->author_review_notes
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->author_review_notes).'</div>';
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
                <button class="btn btn-primary">Simpan</button>
                <form>
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
                <button type="button" class="btn btn-secondary"><i class="fa fa-download"></i> Download File</button>
                <button type="button" class="btn btn-secondary"><i class="fa fa-upload"></i> Upload File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cr1">Catatan Reviewer 1</label>
                      <?php 
                      $optionscr1 = array(
                          'name' => 'review_notes',
                          'class'=> 'form-control',
                          'id'  => 'cr1',
                          'rows' => '6',
                          'value'=> $input->review_notes
                      );
                      echo form_textarea($optionscr1); ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="crp1">Catatan Penulis</label>
                      <?php 
                      $optionscrp1 = array(
                          'name' => 'author_review_notes',
                          'class'=> 'form-control',
                          'id'  => 'crp1',
                          'rows' => '6',
                          'value'=> $input->author_review_notes
                      );
                      echo form_textarea($optionscrp1); ?>
                    </div>
                    <!-- /.form-group -->
                  </fieldset>
                  <!-- /.fieldset -->
              </div>
              <!-- /.modal-body -->
              <!-- .modal-footer -->
              <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
                <form>
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