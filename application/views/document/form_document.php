<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>"><span class="fa fa-home"></span></a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url('document')?>">Document</a>
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
      <section class="card">
        <!-- .card-body -->
        <div class="card-body">
          <!-- .form -->
          <?= form_open_multipart($form_action,'id="formdocument" novalidate=""') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Dokument</legend>
            <?= isset($input->document_id) ? form_hidden('document_id', $input->document_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="document_name">Nama Dokumen
              <abbr title="Required">*</abbr>
              </label>
              <?= form_input('document_name', $input->document_name, 'class="form-control" id="document_name"') ?>
              <?= form_error('document_name') ?>
            </div>
            <!-- /.form-group -->
             <!-- .form-group -->
            <div class="form-group">
              <label for="document_year">Tahun Dokumen</label>
              <?= form_input('document_year', $input->document_year, 'class="form-control dokumen" id="document_year"') ?>
              <?= form_error('document_year') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="document_file">File document</label>
              <div class="custom-file">
                <?=form_upload('document_file', '', 'class="custom-file-input dokumen"');?>
                <label class="custom-file-label" for="document_file">Choose file</label>
              </div>
              <small class="form-text text-muted">Tipe file upload bertype : jpg, png, jpeg, docx, doc, dan pdf. Maksimal 50 MB</small>
              <?=fileFormError('document_file', '<p class="text-danger">', '</p>');?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="document_file_link">Link Dokumen</label>
              <?= form_input('document_file_link', $input->document_file_link, 'class="form-control dokumen" id="document_file_link"') ?>
              <?= form_error('document_file_link') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="document_notes">Catatan Dokumen</label>
              <?= form_textarea('document_notes', $input->document_notes, 'class="form-control summernote-basic" id="document_notes"') ?>
              <?= form_error('document_notes') ?>
            </div>
            <!-- /.form-group -->
            
          </fieldset>
          <!-- /.fieldset -->
          <hr>
          <!-- .form-actions -->
          <div class="form-actions">
            <button class="btn btn-primary ml-auto" type="submit">Submit data</button>
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
  $(document).ready(function(){
    setting_validasi();
    $("#formdocument").validate({
        rules: {
          document_name : "crequired",
          document_file: {
            require_from_group: [1, ".dokumen"],
            dokumen: "docx|doc|pdf|jpeg|jpg|png|xls|xlsx|zip|rar",
            filesize50: 52428200
          },
          document_file_link: {
            curl: true,
            require_from_group: [1, ".dokumen"]
          },
          document_year : {
            crange : [1900,2100]
          }
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
           error.addClass( "invalid-feedback" );
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.next('span.select2'));      // input group
            } else if (element.hasClass("select2-hidden-accessible")){
                error.insertAfter(element.next('span.select2'));  // select2
            } else if (element.hasClass("custom-file-input")){
                error.insertAfter(element.next('label.custom-file-label'));  // fileinput custom
            } else if (element.hasClass("custom-control-input")){
                error.insertAfter($(".custom-radio").last());  // radio
            }else {                                      
                error.insertAfter(element);               // default
            }
        }
      },
      select2_validasi()
     );
  })
</script>