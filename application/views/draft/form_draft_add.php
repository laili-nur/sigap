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
    <div class="col-md-8">
     <!-- .card -->
     <section id="data-author" class="card">
      <!-- .card-body -->
      <div class="card-body">
        <!-- .form -->
        <?= form_open_multipart($form_action,'novalidate="" id="formdraft"') ?>
        <!-- .fieldset -->
        <fielsdet>
          <legend>Data Draft</legend>
          <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="category">Jenis Kategori
              <abbr title="Required">*</abbr>
            </label>
            <!-- cek parameter category, jika ada isinya maka disable pilihan category -->
            <?php if(!empty($this->uri->segment(3)) and $this->uri->segment(2) != 'cetakUlang'){
              $atribut = 'disabled';
            }else{
              $atribut = '';
            }
            ?>
            <?= form_dropdown('category_id', getDropdownListCategory('category', ['category_id', 'category_name']), $input->category_id, 'id="category" class="form-control custom-select d-block '.$atribut.'" '.$atribut.'') ?>
            <?= form_error('category_id') ?>
          </div>
          <?php if (!empty($this->uri->segment(3))){
            if(isset($input->category_id)){
              echo form_hidden('category_id', $input->category_id);
            }
          }
          ?>
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
            <div class="form-group d-none cek">
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
                <div class="p-0 m-0">
                  <small class="text-muted">Jika Penulis belum ada di list, tambahkan penulis di menu <a target="_blank" href="<?=base_url('author/add') ?>">PENULIS</a>, lalu klik tombol reload berikut</small>
                </div>
                <div class="p-0 m-0">
                  <button id="callback" type="button" class="btn btn-secondary btn-xs mt-2"><i class="fa fa-sync" id="ajax-reload-author"></i> Reload Penulis</button>
                </div>
              </div>
            <?php endif ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="draft_file">File Draft</label>
              <div class="custom-file">
                <?= form_upload('draft_file','','class="custom-file-input"') ?>
                <label class="custom-file-label" for="draft_file">Choose file</label>
              </div>
              <small class="form-text text-muted">Tipe file upload  bertype : docx, doc, dan pdf. Maksimal 50 MB</small>
              <?= fileFormError('draft_file', '<p class="text-danger">', '</p>'); ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="draft_file_link">Link File Draft</label>
              <?= form_input('draft_file_link', $input->draft_file_link, 'class="form-control" id="draft_file_link"') ?>
              <small class="form-text text-muted">Isikan link external file draft</small>
              <?= form_error('draft_file_link') ?>
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
          <?=form_close(); ?>
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
    $("#formdraft").validate({
      rules: {
        category_id : "crequired",
        theme_id : "crequired",
        draft_title: {
          crequired: true,
          cminlength: 5,
        },
        "author_id[]": {
          crequired: true,
        },
        draft_file: {
          dokumen: "docx|doc|pdf",
          filesize50: 52428200
        },
        draft_file_link :"curl"

      },
      messages: {},
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

    // $("#callback").on("click",function(){
    //   console.log("cekk bro");
    //     $("#cek").load("#cek", function(){
    //       $('#author option[value=""]').detach();
    //       $("#author").select2();
    //       document.getElementById("callback").onclick = null;
    //     });
    // });

    //reload author yang baru ditambahkan
    $("#callback").on("click",function(){
      $("#ajax-reload-author").addClass("fa-spin");
        $.get("<?php echo base_url('draft/ajax_reload_author/');?>",
          function(data){
            var datax = JSON.parse(data);
          // var tampil = [];
          // for(i=0; i<datax.length; i++){
          //   tampil[datax[i].author_id]=datax[i].author_name;
          // }

          $('#author').find('option').remove().end();
            $.each(datax, (key, value) => {
              $("<option/>", {
                "value": key,
                "text": value
              }).appendTo($("#author"));
            });
            toastr_view("update_author");
            $("#ajax-reload-author").removeClass("fa-spin");
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
    //urut sesuai pilihan input
    $("#author").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);

        $element.detach();
        $(this).append($element);
          $(this).trigger("change");
        });

    // $("#formdraft").submit(function(){
    //   $('#btn-submit').attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    // });
    
  });
</script>


