<!-- .page-section -->
<div class="page-section">
   <div class="row">
      <div class="col-md-6">
         <!-- .card -->
         <section class="card">
            <!-- .card-body -->
            <div class="card-body">
               <!-- .form -->
               <?=form_open('draftauthor/add/');?>
               <!-- .fieldset -->
               <fieldset>
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="draft_id">Judul Draft
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('draft_id', get_dropdown_list('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft_id" class="form-control custom-select d-block"');?>
                     <div class="invalid-feedback">erot</div>
                     <?=form_error('draft_id');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="author_id">Nama Penulis
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('author_id', get_dropdown_list('author', ['author_id', 'author_name']), $input->author_id, 'id="author_id" class="form-control custom-select d-block"');?>
                     <div class="invalid-feedback">erot</div>
                     <?=form_error('author_id');?>
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
                  >Submit data</button>
               </div>
               <!-- /.form-actions -->
               </form>
               <!-- /.form -->
            </div>
            <!-- /.card-body -->
         </section>
         <!-- /.card --
    </div>
  </div>
</div>
 <!-- /.page-section -->