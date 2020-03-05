<!-- .page-section -->
<div class="page-section">
   <div class="row">
      <div class="col-md-6">
         <!-- .card -->
         <section class="card">
            <!-- .card-body -->
            <div class="card-body">
               <!-- .form -->
               <?=form_open('draftreviewer/add/' . $input->draft_id);?>
               <!-- .fieldset -->
               <fieldset>
                  <legend>Pilih Reviewer untuk draft </legend>
                  <?=isset($input->draft_reviewer_id) ? form_hidden('draft_reviewer_id', $input->draft_reviewer_id) : '';?>
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="user_id">Nama Draft
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('draft_id', get_dropdown_list('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft_id" class="form-control custom-select d-block"');?>
                     <div class="invalid-feedback">erot</div>
                     <?=form_error('draft_id');?>
                  </div>
                  <!-- /.form-group -->
                  <!-- .form-group -->
                  <div class="form-group">
                     <label for="user_id">Nama Reviewer
                        <abbr title="Required">*</abbr>
                     </label>
                     <?=form_dropdown('reviewer_id', get_dropdown_list('reviewer', ['reviewer_id', 'reviewer_name']), $input->reviewer_id, 'id="reviewer_id" class="form-control custom-select d-block"');?>
                     <div class="invalid-feedback">erot</div>
                     <?=form_error('reviewer_id');?>
                  </div>
                  <!-- /.form-group -->
               </fieldset>
               <!-- /.fieldset -->
               <hr>
               <!-- .form-actions -->
               <div class="form-actions">
                  <a
                     href="<?=base_url('draft/view/' . $input->draft_id);?>"
                     class="btn btn-secondary"
                  >Back</a>
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