<!-- .page-title-bar -->
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span></a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>">Penerbitan</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url('book')?>">Buku</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted">Form Hak Cipta</a>
        </li>
      </ol>
    </nav> 
  </header>
  <!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
<div class="row">
  <div class="col-md-6">
     <!-- .card -->
  <section id="data-author" class="card">
    <!-- .card-body -->
    <div class="card-body">
      <!-- .form -->
      <?= form_open_multipart($form_action,'novalidate id="form_hakcipta"') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Hak Cipta</legend>
          <?= isset($input->book_id) ? form_hidden('book_id', $input->book_id) : '' ?>
          <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
          <?= isset($input->book_title) ? form_hidden('book_title', $input->book_title) : '' ?>
          <!-- <?= isset($input->book_code) ? form_hidden('book_code', $input->book_code) : '' ?>
          <?= isset($input->book_edition) ? form_hidden('book_edition', $input->book_edition) : '' ?>
          <?= isset($input->isbn) ? form_hidden('isbn', $input->isbn) : '' ?>
          <?= isset($input->eisbn) ? form_hidden('eisbn', $input->eisbn) : '' ?>
          <?= isset($input->book_file) ? form_hidden('book_file', $input->book_file) : '' ?>
          <?= isset($input->book_file_link) ? form_hidden('book_file_link', $input->book_file_link) : '' ?>
          <?= isset($input->published_date) ? form_hidden('published_date', $input->published_date) : '' ?>
          <?= isset($input->printing_type) ? form_hidden('printing_type', $input->printing_type) : '' ?>
          <?= isset($input->serial_num) ? form_hidden('serial_num', $input->serial_num) : '' ?>
          <?= isset($input->serial_num_per_year) ? form_hidden('serial_num_per_year', $input->serial_num_per_year) : '' ?>
          <?= isset($input->copies_num) ? form_hidden('copies_num', $input->copies_num) : '' ?>
          <?= isset($input->book_notes) ? form_hidden('book_notes', $input->book_notes) : '' ?>
          <?= isset($input->is_reprint) ? form_hidden('is_reprint', $input->is_reprint) : '' ?> -->
            
            <!-- .form-group -->
          <div class="form-group">
            <label for="book_title">Judul</label>
            <h6><?=$input->book_title ?></h6>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="nomor_hak_cipta">Nomor Hak Cipta</label>
            <?= form_input('nomor_hak_cipta', $input->nomor_hak_cipta, 'class="form-control" id="nomor_hak_cipta" ') ?>
            <?= form_error('nomor_hak_cipta') ?>
          </div>
          <!-- /.form-group -->
            
          <!-- .form-group -->
          <div class="form-group">
            <label for="file_hak_cipta">File Hak Cipta
<!--              <abbr title="Required">*</abbr>-->
            </label>
            <div class="custom-file">
              <?= form_upload('file_hak_cipta','','class="custom-file-input" id="file_hak_cipta"') ?> 
              <label class="custom-file-label" for="tf3">Choose file</label>
            </div>
            <small class="form-text text-muted">Hanya menerima file bertype : jpg, png, jpeg, dan pdf</small>
            <?= fileFormError('file_hak_cipta', '<p class="text-danger">', '</p>'); ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="file_hak_cipta_link">Link File Hak Cipta</label>
            <?= form_input('file_hak_cipta_link', $input->file_hak_cipta_link, 'class="form-control" id="file_hak_cipta_link"') ?>
            <?= form_error('file_hak_cipta_link') ?>
          </div>
          <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label>Status Hak Cipta</label>
              <div>
                <!-- button radio -->
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary <?=($input->status_hak_cipta == '') ? 'active' : '' ?>">
                    <?= form_radio('status_hak_cipta', '',
                    isset($input->is_reprint) && ($input->status_hak_cipta == '') ? true : false,'required class="custom-control-input" id="status_hak_cipta0"')?> -</label>
                  <label class="btn btn-secondary <?=($input->status_hak_cipta == '1') ? 'active' : '' ?>">
                    <?= form_radio('status_hak_cipta', '1',
                    isset($input->is_reprint) && ($input->status_hak_cipta == '1') ? true : false,'required class="custom-control-input" id="status_hak_cipta1"')?> Dalam Proses</label>
                    
                    <label class="btn btn-secondary <?=($input->status_hak_cipta == '2') ? 'active' : '' ?>">
                    <?= form_radio('status_hak_cipta', '2',
                    isset($input->is_reprint) && ($input->status_hak_cipta == '2') ? true : false,' class="custom-control-input" id="status_hak_cipta2"')?> Sudah Jadi</label>
                </div>
              <!-- /button radio -->
              </div>
               <?= form_error('status_hak_cipta') ?>
            </div>
            <!-- /.form-group --> 
        </fieldset>
        <!-- /.fieldset -->
        <hr>
        <!-- .form-actions -->
        <div class="form-actions">
          <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit">Submit data</button>
        </div>
        <!-- /.form-actions -->
      </form>
      <!-- /.form -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->   
  </div>
</div>
</div>
<!-- /.page-section -->
<script>
  $(document).ready(function() {
    setting_validasi();
    $("#form_hakcipta").validate({
        rules: {
          file_hak_cipta_link : "curl",
          file_hak_cipta: {
            dokumen: "png|jpg|jpeg|pdf",
            filesize50: 52428200
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
        }
      },
      select2_validasi()
     );

    $("#draft_id").select2({
      placeholder: '-- Choose --',
      allowClear: true
    });
 });
</script>
