<?php $ceklevel = $this->session->userdata('level'); ?>
<!-- .card -->
  <section id="progress-proofread" class="card">
    <!-- .card-header -->
    <header class="card-header">Proofread</header>
    <div class="list-group list-group-flush list-group-bordered">
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal masuk</span>
            <strong><?= konversiTanggal($input->proofread_start_deadline) ?></strong>
          </div>
          <div class="list-group-item justify-content-between">
            <span class="text-muted">Tanggal jadi</span>
            <strong><?= konversiTanggal($input->proofread_end_deadline) ?></strong>
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
        <button class="btn btn-success"><i class="fa fa-check"></i></button>       
        <?php endif ?>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#proofread">Lihat Detail</button>
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
                <button type="button" class="btn btn-secondary"><i class="fa fa-download"></i> Download File</button>
                <button type="button" class="btn btn-secondary"><i class="fa fa-upload"></i> Upload File</button>
                <hr>
                <!-- .form -->
                <form>
                  <!-- .fieldset -->
                  <fieldset>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cp" class="font-weight-bold">Catatan Proofread</label>
                      <?php 
                      $optionscp = array(
                          'name' => 'proofread_notes',
                          'class'=> 'form-control',
                          'id'  => 'cp',
                          'rows' => '6',
                          'value'=> $input->proofread_notes
                      );
                      if($ceklevel=='author'){
                        echo '<div class="font-italic">'.nl2br($input->proofread_notes).'</div>';
                      }else{
                        echo form_textarea($optionscp);
                      }
                      ?>
                    </div>
                    <!-- /.form-group -->
                    <hr>
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cpp" class="font-weight-bold">Catatan Penulis</label>
                      <?php 
                      $optionscpp = array(
                          'name' => 'author_proofread_notes',
                          'class'=> 'form-control',
                          'id'  => 'cpp',
                          'rows' => '6',
                          'value'=> $input->author_proofread_notes
                      );
                      if($ceklevel!='author'){
                        echo '<div class="font-italic">'.nl2br($input->layout_notes).'</div>';
                      }else{
                        echo form_textarea($optionscpp);
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
      </div>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->