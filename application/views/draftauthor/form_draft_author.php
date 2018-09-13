<!-- .page-section -->
<div class="page-section">
  <div class="row">
    <div class="col-md-6">
      <!-- .card -->
        <section id="data-category" class="card">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .form -->
            <?= form_open('draftauthor/add/'.$input->draft_id) ?>
              <!-- .fieldset -->
              <fieldset>
                <legend>Pilih Penulis untuk draft <strong><?= konversiID('draft','draft_id',$input->draft_id)->draft_title ?></strong></legend>
                <?= isset($input->category_id) ? form_hidden('category_id', $input->category_id) : '' ?>
                <?= form_hidden('draft_id', $input->draft_id, 'class="form-control" id="draft_id" readonly=""') ?>
                <!-- .form-group -->
                <div class="form-group">
                  <label for="user_id">Nama Penulis
                    <abbr title="Required">*</abbr>
                  </label>
                  <?= form_dropdown('author_id', getDropdownList('author', ['author_id', 'author_name']), $input->author_id, 'id="author_id" class="form-control custom-select d-block"') ?>
                  <div class="invalid-feedback">erot</div>
                  <?= form_error('author_id') ?>
                </div>  
                <!-- /.form-group -->
              </fieldset>
              <!-- /.fieldset -->
              <hr>
              <!-- .form-actions -->
              <div class="form-actions">
                <a href="<?=base_url('draft/view/'.$input->draft_id) ?>" class="btn btn-secondary">Back</a>
                <button class="btn btn-primary ml-auto" type="submit">Submit data</button>
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

 <!-- .page-section -->
<div class="page-section">
  <div class="row">
    <div class="col-md-6">
      <!-- .card -->
        <section id="data-category" class="card">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .form -->
            <?= form_open('draftauthor/addmulti') ?>
              <!-- .fieldset -->
              <fieldset>
                <!-- .form-group -->
                <div class="form-group">
                  <?= form_input('author_id', '', 'class="form-control" id="draft_title"') ?>
                </div>  
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <?= form_input('draft_id', '', 'class="form-control" id="draft_title"') ?>
                </div>  
                <!-- /.form-group -->
              </fieldset>
              <!-- /.fieldset -->
              <hr>
              <!-- .form-actions -->
              <div class="form-actions">
                <a href="<?=base_url('draft/view/'.$input->draft_id) ?>" class="btn btn-secondary">Back</a>
                <button class="btn btn-primary ml-auto" type="submit">Submit data</button>
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









