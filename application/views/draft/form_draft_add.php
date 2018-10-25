<?php $ceklevel = $this->session->userdata('level'); ?>
<?php $cekrole = $this->session->userdata('role_id'); ?>
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
          <a href="<?=base_url('draft')?>">Draft</a>
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
      <?= form_open_multipart($form_action,'novalidate="" id="formdraft"') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Draft</legend>
          <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="category">Jenis Kategori
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('category_id', getDropdownListCategory('category', ['category_id', 'category_name']), $input->category_id, 'id="category" class="form-control custom-select d-block"') ?>
            <?= form_error('category_id') ?>
          </div>
          <!-- /.form-group -->
          <hr class="my-2">
          <!-- .form-group -->
          <div class="form-group">
            <label for="theme">Pilih Tema
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('theme_id', getDropdownList('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme" class="form-control custom-select d-block"') ?>
            <?= form_error('theme_id') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="draft_title">Judul Draft
              <abbr title="Required">*</abbr>
            </label>
            <?= form_input('draft_title', $input->draft_title, 'class="form-control customer" id="draft_title"') ?>
            <?= form_error('draft_title') ?>
          </div>
          <!-- /.form-group -->
          <?php if($ceklevel == 'author'): ?>
            <div class="form-group d-none">
            <label for="draft_title">Penulis
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('author_id[]', getDropdownList('author', ['author_id', 'author_name']),$cekrole, 'id="author" class="form-control custom-select" multiple="multiple"') ?>
            <?= form_error('author_id[]') ?>
          </div>
          <?php else: ?>
          <!-- .form-group -->
          <div class="form-group" id="cek">
            <label for="author_id">Pilih Penulis
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('author_id[]', getDropdownList('author', ['author_id', 'author_name']),isset($input->author_id)?$input->author_id:'', 'id="author" class="form-control custom-select d-block" multiple="multiple"') ?>
            <?= form_error('author_id[]') ?>
          <!-- /.form-group -->
          <!-- <a id="callback" class="btn btn-secondary btn-xs mt-2">Reload Penulis</a> -->
          </div>
          <?php endif ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="draft_file">File Draft
              <abbr title="Required">*</abbr>
            </label>
            <div class="custom-file">
              <?= form_upload('draft_file','','class="custom-file-input"') ?> 
              <label class="custom-file-label" for="draft_file">Choose file</label>
            </div>
            <small class="form-text text-muted">Tipe file upload  bertype : docx, doc, dan pdf</small>
            <?= fileFormError('draft_file', '<p class="text-danger">', '</p>'); ?>
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

    $.validator.addMethod("alphanum", function(value, element) {
        return this.optional(element) || /^[\w. ]+$/i.test(value);
    }, "Hanya diperbolehkan menggunakan huruf, angka, underscore, titik, dan spasi");
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'File harus kurang dari 50MB');
    $.validator.addMethod("crequired", $.validator.methods.required,"Kolom tidak boleh kosong");
    $.validator.addMethod("cminlength", $.validator.methods.minlength, $.validator.format("Minimal {0} karakter"));
    $.validator.addMethod("dokumen", $.validator.methods.extension, "Hanya boleh docx, doc, atau pdf");
    $("#formdraft").validate({
        rules: {
          category_id : "crequired",
          theme_id : "crequired",
          draft_title: {
            crequired: true,
            cminlength: 5,
            alphanum: true,
          },
          "author_id[]": {
            crequired: true,
          },
          draft_file: {
            crequired: true,
            dokumen: "docx|doc|pdf",
            filesize: 52428200
          }

        },
        messages: {},
        errorElement: "span",
        errorClass : "none",
        validClass : "none",
        errorPlacement: function (error, element) {
           error.addClass( "invalid-feedback" );
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass("select2-hidden-accessible")){
                error.insertAfter(element.next('span.select2'));  // select2
            } else if (element.hasClass("custom-file-input")){
                error.insertAfter(element.next('label.custom-file-label'));  // fileinput custom
            } else {                                      
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
      $("select").on("select2:close", function (e) {  
          $(this).valid(); 
      })
     );

    $("#callback").click(function(){
      console.log("cekk bro");
        $("#cek").load(" #cek", function(){
          $('#author option[value=""]').detach();
          $("#author").select2();
        });
    });
    $("#category").select2({
      placeholder: '-- Choose --',
      allowClear: true
    });
    $("#theme").select2({
      placeholder: '-- Choose --',
      allowClear: true
    });
    $('#author option[value=""]').detach();
    $("#author").select2({
      placeholder: '-- Choose Multiple --',
      multiple :true
    });
    
    // $("#formdraft").submit(function(){
    //   $('#btn-submit').attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    // });
    

 });
</script>


