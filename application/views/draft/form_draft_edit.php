<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>">Penerbitan</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url('draft')?>">Draft</a>
      </li>
      <li class="breadcrumb-item">
        <a class="text-muted">Tambah</a>
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
            <?php form_close(); ?>
            <!-- /.form -->
          </div>
          <!-- /.card-body -->
        </section>
        <!-- /.card --> 
      
    </div>
  </div>
       
</div>
<!-- /.page-section -->

