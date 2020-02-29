<!-- .page-title-bar -->
<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>">Penerbitan</a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('book');?>">Buku</a>
         </li>
         <li class="breadcrumb-item">
            <a class="text-muted">Form Buku</a>
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
               <?=form_open_multipart($form_action, 'novalidate id="formbook"');?>
               <!-- .fieldset -->
               <fieldset>
                  <legend>Data Buku</legend>
                  <?=isset($input->book_id) ? form_hidden('book_id', $input->book_id) : '';?>
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="category">Draft
                        <abbr title="Required">*</abbr>
                     </label>
                     <?php if ($input->draft_id == '' or $this->uri->segment(2) == 'add'): ?>
                     <?=form_dropdown('draft_id', getDropdownListBook('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft_id" class="form-control custom-select d-block"');?>
                     <small class="form-text text-muted">Hanya draft yang telah lolos proofread yang dapat
                        dipilih</small>
                     <?=form_error('draft_id');?>
                     <?php else: ?>
                     <p class="font-weight-bold"><a
                           href="<?=base_url('draft/view/' . $input->draft_id);?>"><?=konversiID('draft', 'draft_id', $input->draft_id)->draft_title;?></a>
                     </p>
                     <?=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '';?>
                     <?php endif;?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="book_code">Kode Buku</label>
                     <?=form_input('book_code', $input->book_code, 'class="form-control" id="book_code"');?>
                     <?=form_error('book_code');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="book_title">Judul Buku
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_input('book_title', $input->book_title, 'class="form-control" id="book_title"');?>
                     <?=form_error('book_title');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="book_edition">Edisi Buku</label>
                     <?=form_input('book_edition', $input->book_edition, 'class="form-control" id="book_edition" ');?>
                     <?=form_error('book_edition');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="book_pages">Jumlah Halaman</label>
                     <?=form_input('book_pages', $input->book_pages, 'class="form-control" id="book_pages"');?>
                     <?=form_error('book_pages');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="isbn">ISBN</label>
                     <?=form_input('isbn', $input->isbn, 'class="form-control" id="isbn"');?>
                     <?=form_error('isbn');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="eisbn">eISBN</label>
                     <?=form_input('eisbn', $input->eisbn, 'class="form-control" id="eisbn"');?>
                     <?=form_error('eisbn');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="published_date">Tanggal Terbit</label>
                     <?=form_input('published_date', $input->published_date, 'class="form-control mydate" id="published_date"');?>
                     <?=form_error('published_date');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="harga">Harga</label>
                     <?=form_input('harga', $input->harga, 'class="form-control" id="harga"');?>
                     <?=form_error('harga');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="book_file">
                        File Buku
                        <!--              <abbr title="Required">*</abbr>-->
                     </label>
                     <div class="alert alert-info">File buku diambil dari file proofread yang terakhir. Kosongkan kolom
                        ini jika tidak ingin mengganti file buku.</div>
                     <div class="custom-file">
                        <?=form_upload('book_file', '', 'class="custom-file-input" id="book_file"');?>
                        <label
                           class="custom-file-label"
                           for="book_file"
                        >Pilih file</label>
                     </div>
                     <small class="form-text text-muted">Hanya menerima file bertype : pdf, docx, dan doc</small>
                     <?=file_form_error('book_file', '<p class="text-danger">', '</p>');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="book_file_link">Link File Buku</label>
                     <?=form_input('book_file_link', $input->book_file_link, 'class="form-control" id="book_file_link"');?>
                     <?=form_error('book_file_link');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="book_notes">Keterangan Buku</label>
                     <?=form_textarea('book_notes', $input->book_notes, 'class="form-control summernote-basic"');?>
                     <?=form_error('book_notes');?>
                  </div>
                  <!-- /.form-group -->
               </fieldset>
               <!-- /.fieldset -->
               <hr>
               <!-- .form-actions -->
               <div class="form-actions">
                  <button
                     class="btn btn-primary ml-auto"
                     type="submit"
                     value="Submit"
                     id="btn-submit"
                  >Submit data</button>
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
   loadValidateSetting();
   $("#formbook").validate({
         rules: {
            draft_id: "crequired",
            book_file_link: "curl",
            book_title: {
               crequired: true,
               cminlength: 5,
            },
            book_file: {
               dokumen: "docx|doc|pdf",
               filesize50: 52428200
            },
         },
         errorElement: "span",
         errorClass: "none",
         validClass: "none",
         errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            if (element.parent('.input-group').length) {
               error.insertAfter(element.next('span.select2')); // input group
            } else if (element.hasClass("select2-hidden-accessible")) {
               error.insertAfter(element.next('span.select2')); // select2
            } else if (element.parent().parent().hasClass('input-group')) {
               error.insertAfter(element.closest('.input-group')); // fileinput append
            } else if (element.hasClass("custom-file-input")) {
               error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
            } else if (element.hasClass("custom-control-input")) {
               error.insertAfter($(".custom-radio").last()); // radio
            } else {
               error.insertAfter(element); // default
            }
         },
         highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
         },
         unhighlight: function(element, errorClass, validClass) {
            $(element).addClass(validClass).removeClass(errorClass);
         }
      },
      validateSelect2()
   );
   $("#draft_id").select2({
      placeholder: '-- Pilih --',
      allowClear: true
   });
});
</script>