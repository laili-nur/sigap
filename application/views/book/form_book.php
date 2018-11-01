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
          <a class="text-muted">Form</a>
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
      <?= form_open_multipart($form_action,'novalidate id="formbook"') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Buku</legend>
          <?= isset($input->book_id) ? form_hidden('book_id', $input->book_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="category">Draft
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('draft_id', getDropdownListBook('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft_id" class="form-control custom-select d-block"') ?>
            <small class="form-text text-muted">Hanya draft yang telah lolos proofread yang dapat dipilih</small>
            <?= form_error('category_id') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_code">Kode Buku</label>
            <?= form_input('book_code', $input->book_code, 'class="form-control" id="book_code"') ?>
            <?= form_error('book_code') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_title">Judul Buku
              <abbr title="Required">*</abbr>
            </label>
            <?= form_input('book_title', $input->book_title, 'class="form-control" id="book_title"') ?>
            <?= form_error('book_title') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_edition">Edisi Buku</label>
            <?= form_input('book_edition', $input->book_edition, 'class="form-control" id="book_edition" ') ?>
            <?= form_error('book_edition') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="isbn">ISBN</label>
            <?= form_input('isbn', $input->isbn, 'class="form-control" id="isbn"') ?>
            <?= form_error('isbn') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="eisbn">eISBN</label>
            <?= form_input('eisbn', $input->eisbn, 'class="form-control" id="eisbn"') ?>
            <?= form_error('eisbn') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_file">File Buku
<!--              <abbr title="Required">*</abbr>-->
            </label>
            <div class="custom-file">
              <?= form_upload('book_file','','class="custom-file-input" id="book_file"') ?> 
              <label class="custom-file-label" for="book_file">Choose file</label>
            </div>
            <small class="form-text text-muted">Hanya menerima file bertype : pdf, docx, dan doc</small>
            <?= fileFormError('book_file', '<p class="text-danger">', '</p>'); ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_file_link">Link File Buku</label>
            <?= form_input('book_file_link', $input->book_file_link, 'class="form-control" id="book_file_link"') ?>
            <?= form_error('book_file_link') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="published_date">Tanggal Terbit</label>
            <?= form_input('published_date', $input->published_date, 'class="form-control mydate" id="published_date"') ?>
            <?= form_error('published_date') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label>Tipe Printing</label>
            <div>
              <!-- button radio -->
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
              <label class="btn btn-secondary <?=($input->printing_type == 'p') ? 'active' : '' ?>">
                <?= form_radio('printing_type', 'p',
                isset($input->printing_type) && ($input->printing_type == 'p') ? true : false,'required class="custom-control-input" id="blocked1"')?> POD</label>
              <label class="btn btn-secondary <?=($input->printing_type == 'o') ? 'active' : '' ?>">
                <?= form_radio('printing_type', 'o',
                isset($input->printing_type) && ($input->printing_type == 'o') ? true : false,' class="custom-control-input" id="blocked2"')?> Offset</label>
            </div>
            <!-- /button radio -->
            </div>
             <?= form_error('printing_type') ?>
          </div>
          <!-- /.form-group -->
            <!-- .form-group -->
          <div class="form-group">
            <label for="serial_num">Serial Number Total
            </label>
            <?= form_input('serial_num', $input->serial_num, 'class="form-control" id="serial_num"') ?>
            <?= form_error('serial_num') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="serial_num_per_year">Serial Number Per Tahun</label>
            <?= form_input('serial_num_per_year', $input->serial_num_per_year, 'class="form-control" id="serial_num_per_year" ') ?>
            <?= form_error('serial_num_per_year') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="copies_num">Jumlah Copy</label>
            <?= form_input('copies_num', $input->copies_num, 'class="form-control" id="copies_num"') ?>
            <?= form_error('copies_num') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <!-- .form-group -->
            <div class="form-group">
              <label for="book_notes">Keterangan Buku</label>
                <?= form_textarea('book_notes', $input->book_notes, 'class="form-control"') ?>
              <?= form_error('book_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label>Status</label>
              <div>
                <!-- button radio -->
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary <?=($input->is_reprint == 'y') ? 'active' : '' ?>">
                    <?= form_radio('is_reprint', 'y',
                    isset($input->is_reprint) && ($input->is_reprint == 'y') ? true : false,'required class="custom-control-input" id="reprint1"')?> Cetak Ulang</label>
                  <label class="btn btn-secondary <?=($input->is_reprint == 'n') ? 'active' : '' ?>">
                    <?= form_radio('is_reprint', 'n',
                    isset($input->is_reprint) && ($input->is_reprint == 'n') ? true : false,' class="custom-control-input" id="reprint2"')?> Baru</label>
                </div>
              <!-- /button radio -->
              </div>
               <?= form_error('is_reprint') ?>
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
    //populate judul ketika pilih draft
    $('#draft_id').on('change', function() {
      var data = $("#draft_id option:selected").text();
      $('#book_title').val(data);
    })
    

    setting_validasi();
    $("#formbook").validate({
        rules: {
          draft_id : "crequired",
          book_title: {
            crequired: true,
            cminlength: 5,
          },
          book_file: {
            dokumen: "docx|doc|pdf",
            filesize50: 52428200
          },
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
        },
        highlight: function ( element, errorClass, validClass ) {
          $( element ).addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).addClass(validClass).removeClass(errorClass);
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
