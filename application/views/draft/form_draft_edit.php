<div class="col-md-8">
    <!-- .page-title-bar -->
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <a href="#">
            <i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Forms</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Form Penulis </h1>
  </header>
  <!-- /.page-title-bar -->
  <!-- .page-section -->
  <div class="page-section">
    <!-- .card -->
    <section id="data-author" class="card">
      <!-- .card-body -->
      <div class="card-body">
        <!-- .form -->
        <?= form_open_multipart($form_action,'class="needs-validation" novalidate=""') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Penulis</legend>
            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="category_id">Kategori
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('category_id', getDropdownList('category', ['category_id', 'category_name']), $input->category_id, 'id="category_id" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('category_id') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="theme_id">Tema
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('theme_id', getDropdownList('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme_id" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('theme_id') ?>
            </div>
            <!-- /.form-group -->
            <hr class="my-2">
            <h5 class="card-title">Mantap</h5>
            <!-- .form-group -->
            <div class="form-group">
              <label for="draft_title">Judul
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('draft_title', $input->draft_title, 'class="form-control" id="draft_title"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('draft_title') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="draft_title">File Draft
                <abbr title="Required">*</abbr>
              </label>
              <div class="custom-file">
                <?= form_upload('draft_file') ?>          
              </div>
              <div class="invalid-feedback">erot</div>
              <?= fileFormError('draft_file', '<p class="text-danger">', '</p>'); ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="proposed_fund">Dana yang diajukan
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('proposed_fund', $input->proposed_fund, 'class="form-control" id="proposed_fund"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('proposed_fund') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="approved_fund">Dana yang disetujui
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('approved_fund', $input->approved_fund, 'class="form-control" id="approved_fund"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('approved_fund') ?>
            </div>
            <!-- /.form-group -->
            <hr>
            <h5 class="card-title">Review</h5>
            <!-- .form-group -->
            <div class="form-group">
              <label>Status Review</label>
              <div class="mb-1">
                <label>
                <?= form_radio('is_reviewed', 'y',
                    isset($input->is_reviewed) && ($input->is_reviewed == 'y') ? true : false)
                ?> Reviewed
                </label>
              </div>
              <div class="mb-1">
                <label>
                <?= form_radio('is_reviewed', 'n',
                    isset($input->is_reviewed) && ($input->is_reviewed == 'n') ? true : false)
                ?> Not Reviewed
                </label>
              </div>
               <?= form_error('is_edited') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="review_notes">Keterangan Review</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('review_notes', $input->review_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('review_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_review_notes">Keterangan Review (Penulis)</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('author_review_notes', $input->author_review_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('author_review_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="review_start_deadline">Tanggal Mulai Review
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('review_start_deadline', $input->review_start_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('review_start_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="review_end_deadline">Tanggal Selesai Review
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('review_end_deadline', $input->review_end_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('review_end_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <hr>
            <h5 class="card-title">Edit</h5>
            <!-- .form-group -->
            <div class="form-group">
              <label>Status Edit</label>
              <div class="mb-1">
                <label>
                <?= form_radio('is_edited', 'y',
                    isset($input->is_edited) && ($input->is_edited == 'y') ? true : false)
                ?> edited
                </label>
              </div>
              <div class="mb-1">
                <label>
                <?= form_radio('is_edited', 'n',
                    isset($input->is_edited) && ($input->is_edited == 'n') ? true : false)
                ?> Not edited
                </label>
              </div>
               <?= form_error('is_edited') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="edit_notes">Keterangan Edit</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('edit_notes', $input->edit_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('edit_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_edit_notes">Keterangan Edit (Penulis)</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('author_edit_notes', $input->author_edit_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('author_edit_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="edit_start_deadline">Tanggal Mulai edit
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('edit_start_deadline', $input->edit_start_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('edit_start_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="edit_end_deadline">Tanggal Selesai Edit
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('edit_end_deadline', $input->edit_end_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('edit_end_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <hr>
            <h5 class="card-title">Layout</h5>
            <!-- .form-group -->
            <div class="form-group">
              <label>Status Layout</label>
              <div class="mb-1">
                <label>
                <?= form_radio('is_layouted', 'y',
                    isset($input->is_layouted) && ($input->is_layouted == 'y') ? true : false)
                ?> layouted
                </label>
              </div>
              <div class="mb-1">
                <label>
                <?= form_radio('is_layouted', 'n',
                    isset($input->is_layouted) && ($input->is_layouted == 'n') ? true : false)
                ?> Not layouted
                </label>
              </div>
               <?= form_error('is_layouted') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="layout_notes">Keterangan layout</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('layout_notes', $input->layout_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('layout_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_layout_notes">Keterangan layout (Penulis)</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('author_layout_notes', $input->author_layout_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('author_layout_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="layout_start_deadline">Tanggal Mulai layout
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('layout_start_deadline', $input->layout_start_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('layout_start_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="layout_end_deadline">Tanggal Selesai layout
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('layout_end_deadline', $input->layout_end_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('layout_end_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <hr>
            <h5 class="card-title">Proofread</h5>
            <!-- .form-group -->
            <div class="form-group">
              <label for="proofread_notes">Keterangan proofread</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('proofread_notes', $input->proofread_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('proofread_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="author_proofread_notes">Keterangan proofread (Penulis)</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('author_proofread_notes', $input->author_proofread_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback"> erot </div>
              <?= form_error('author_proofread_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="proofread_start_deadline">Tanggal Mulai proofread
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('proofread_start_deadline', $input->proofread_start_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('proofread_start_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="proofread_end_deadline">Tanggal Selesai proofread
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_input('proofread_end_deadline', $input->proofread_end_deadline, 'class="form-control" id="flatpickr03" required=""') ?>
                <div class="invalid-feedback"> erot </div>
                <?= form_error('proofread_end_deadline') ?>
            </div>
            </div>
            <!-- /.form-group -->
            <hr>
            
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
  <!-- /.page-section -->
</div>


<div style="display:none">
    <div class="row">
    <div class="col-10 no-margin">
        <h2>Draft</h2>
    </div>
</div>
<?= form_open_multipart($form_action) ?>

    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>

    <!-- work_unit_id -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Category Name', 'category_name', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_dropdown('category_id', getDropdownList('category', ['category_id', 'category_name']), $input->category_id, 'id="category"') ?>
        </div>
        <div class="col-4">
            <?= form_error('category_id') ?>
        </div>
    </div>
    
        <!-- theme_id -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Theme Name', 'theme_name', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_dropdown('theme_id', getDropdownList('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme"') ?>
        </div>
        <div class="col-4">
            <?= form_error('theme_id') ?>
        </div>
    </div>

        <!-- draft_title -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Draft Title', 'draft_title', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('draft_title', $input->draft_title) ?>
        </div>
        <div class="col-4">
            <?= form_error('draft_title') ?>
        </div>
    </div>
        
    <!-- draft_file -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Draft File', 'draft_file', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_upload('draft_file') ?>
        </div>
        <div class="col-4">
            <?= fileFormError('draft_file', '<p class="form-error">', '</p>'); ?>
        </div>
    </div>

    <!--  draft_file preview -->
    <?php if (!empty($input->draft_file)): ?>
        <div class="row form-group">
            <div class="col-2">&nbsp;</div>
            <div class="col-4">
                <img src="<?= site_url("/draftfile/$input->draft_file") ?>" alt="<?= $input->draft_title ?>">
            </div>
            <div class="col-4">&nbsp;</div>
        </div>
    <?php endif ?>
    

        <!-- proposed_fund -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Proposed Fund (Rp.)', 'proposed_fund', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('proposed_fund', $input->proposed_fund) ?>
        </div>
        <div class="col-4">
            <?= form_error('proposed_fund') ?>
        </div>
    </div>
        
        <!-- approved_fund -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Approved Fund (Rp.)', 'approved_fund', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('approved_fund', $input->approved_fund) ?>
        </div>
        <div class="col-4">
            <?= form_error('approved_fund') ?>
        </div>
    </div>

        
<!-- finish_date 
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Finish Date (yyyy-mm-dd)', 'finish_date', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('finish_date', $input->finish_date, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('finish_date') ?>
        </div>
    </div>
        
 print_date 
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Print Date (yyyy-mm-dd)', 'print_date', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('print_date', $input->print_date, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('print_date') ?>
        </div>
    </div>-->
        
        <!-- is_reviewed -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Review Status', 'is_reviewed', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <label class="block-label">
                <?= form_radio('is_reviewed', 'y',
                    isset($input->is_reviewed) && ($input->is_reviewed == 'y') ? true : false)
                ?> Reviewed
            </label>
            <label class="block-label">
                <?= form_radio('is_reviewed', 'n',
                    isset($input->is_reviewed) && ($input->is_reviewed == 'n') ? true : false)
                ?> Not Reviewed
            </label>
        </div>
        <div class="col-4">
            <?= form_error('is_reviewed') ?>
        </div>
    </div>
        
        <!-- review_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Review Notes', 'review_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('review_notes', $input->review_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('review_notes') ?>
        </div>
    </div>
        
        <!-- author_review_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Author Review Notes', 'author_review_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('author_review_notes', $input->author_review_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('author_review_notes') ?>
        </div>
    </div> 
                
                
<!--         review_start_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Review Start Deadline (yyyy-mm-dd)', 'review_start_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('review_start_deadline', $input->review_start_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('review_start_deadline') ?>
        </div>
    </div>
                        
<!--         review_end_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Review End Deadline (yyyy-mm-dd)', 'review_end_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('review_end_deadline', $input->review_end_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('review_end_deadline') ?>
        </div>
    </div> 
        
        <!-- is_revised -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Revise Status', 'is_revised', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <label class="block-label">
                <?= form_radio('is_revised', 'y',
                    isset($input->is_revised) && ($input->is_revised == 'y') ? true : false)
                ?> Revised
            </label>
            <label class="block-label">
                <?= form_radio('is_revised', 'n',
                    isset($input->is_revised) && ($input->is_revised == 'n') ? true : false)
                ?> Not Revised
            </label>
        </div>
        <div class="col-4">
            <?= form_error('is_revised') ?>
        </div>
    </div>
        
        <!-- revise_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Revise Notes', 'revise_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('revise_notes', $input->revise_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('revise_notes') ?>
        </div>
    </div>      
        
        <!-- is_edited -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Edit Status', 'is_edited', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <label class="block-label">
                <?= form_radio('is_edited', 'y',
                    isset($input->is_edited) && ($input->is_edited == 'y') ? true : false)
                ?> Edited
            </label>
            <label class="block-label">
                <?= form_radio('is_edited', 'n',
                    isset($input->is_edited) && ($input->is_edited == 'n') ? true : false)
                ?> Not Edited
            </label>
        </div>
        <div class="col-4">
            <?= form_error('is_edited') ?>
        </div>
    </div>
        
        <!-- edit_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Edit Notes', 'edit_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('edit_notes', $input->edit_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('edit_notes') ?>
        </div>
    </div>         

        <!-- author_edit_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Author Edit Notes', 'author_edit_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('author_edit_notes', $input->author_edit_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('author_edit_notes') ?>
        </div>
    </div> 
                
                
<!--         edit_start_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Edit Start Deadline (yyyy-mm-dd)', 'edit_start_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('edit_start_deadline', $input->edit_start_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('edit_start_deadline') ?>
        </div>
    </div>
                        
<!--         edit_end_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Edit End Deadline (yyyy-mm-dd)', 'edit_end_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('edit_end_deadline', $input->edit_end_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('edit_end_deadline') ?>
        </div>
    </div> 
        
        <!-- is_layouted -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Layout Status', 'is_layouted', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <label class="block-label">
                <?= form_radio('is_layouted', 'y',
                    isset($input->is_layouted) && ($input->is_layouted == 'y') ? true : false)
                ?> Layouted
            </label>
            <label class="block-label">
                <?= form_radio('is_layouted', 'n',
                    isset($input->is_layouted) && ($input->is_layouted == 'n') ? true : false)
                ?> Not Layouted
            </label>
        </div>
        <div class="col-4">
            <?= form_error('is_layouted') ?>
        </div>
    </div>
        
        <!-- layout_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Layout Notes', 'layout_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('layout_notes', $input->layout_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('layout_notes') ?>
        </div>
    </div> 

        <!-- author_layout_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Author Layout Notes', 'author_layout_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('author_layout_notes', $input->author_layout_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('author_layout_notes') ?>
        </div>
    </div> 
                
                
<!--         layout_start_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Layout Start Deadline (yyyy-mm-dd)', 'layout_start_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('layout_start_deadline', $input->layout_start_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('layout_start_deadline') ?>
        </div>
    </div>
                        
<!--         layout_end_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Layout End Deadline (yyyy-mm-dd)', 'layout_end_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('layout_end_deadline', $input->layout_end_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('layout_end_deadline') ?>
        </div>
    </div>         
        
        <!-- is_reprint -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Reprint Status', 'is_reprint', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <label class="block-label">
                <?= form_radio('is_reprint', 'y',
                    isset($input->is_reprint) && ($input->is_reprint == 'y') ? true : false)
                ?> Reprint
            </label>
            <label class="block-label">
                <?= form_radio('is_reprint', 'n',
                    isset($input->is_reprint) && ($input->is_reprint == 'n') ? true : false)
                ?> Not Reprint
            </label>
        </div>
        <div class="col-4">
            <?= form_error('is_reprint') ?>
        </div>
    </div>
        
        <!-- draft_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Draft Notes', 'draft_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('draft_notes', $input->draft_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('draft_notes') ?>
        </div>
    </div>        


        <!-- proofread_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Proofread Notes', 'proofread_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('proofread_notes', $input->proofread_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('proofread_notes') ?>
        </div>
    </div> 

        <!-- author_proofread_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Author Proofread Notes', 'author_proofread_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('author_proofread_notes', $input->author_proofread_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('author_proofread_notes') ?>
        </div>
    </div> 
                
                
<!--         proofread_start_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Proofread Start Deadline (yyyy-mm-dd)', 'proofread_start_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('proofread_start_deadline', $input->proofread_start_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('proofread_start_deadline') ?>
        </div>
    </div>
                        
<!--         proofread_end_deadline -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Proofread End Deadline (yyyy-mm-dd)', 'proofread_end_deadline', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('proofread_end_deadline', $input->proofread_end_deadline, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('proofread_end_deadline') ?>
        </div>
    </div>
        
    <!-- submit button -->
    <div class="row">
        <div class="col-2">&nbsp;</div>
        <div class="col-8"><?= form_button(['type' => 'submit', 'content' => 'Save', 'class' => 'btn-primary']) ?></div>
    </div>
 <?= form_close() ?>

</div>
