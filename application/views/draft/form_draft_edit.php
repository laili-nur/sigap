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
        <a class="text-muted">Tambah</a>
      </li>
    </ol>
  </nav> 
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <div class="row">
    <div class="col-12">
      <!-- .card -->
        <section id="data-author" class="card">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .form -->
            <?= form_open_multipart($form_action,'class="needs-validation" novalidate=""') ?>
              <!-- .fieldset -->
              <fieldset>
                <legend>Data Draft</legend>
                <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                <!-- .form-group -->
                <div class="form-group">
                  <label for="category_id">Kategori
                    <abbr title="Required">*</abbr>
                  </label>
                  <?= form_dropdown('category_id', getDropdownList('category', ['category_id', 'category_name']), $input->category_id, 'id="category_id" class="form-control custom-select d-block"') ?>
                  <div class="invalid-feedback">Field is required</div>
                  <?= form_error('category_id') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="theme_id">Tema
                    <abbr title="Required">*</abbr>
                  </label>
                  <?= form_dropdown('theme_id', getDropdownList('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme_id" class="form-control custom-select d-block"') ?>
                  <div class="invalid-feedback">Field is required</div>
                  <?= form_error('theme_id') ?>
                </div>
                <!-- /.form-group -->
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
                  <div class="invalid-feedback">Field is required</div>
                  <?= form_error('draft_title') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="draft_file">File Draft
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="custom-file">
                    <?= form_upload('draft_file','','class="custom-file-input"') ?> 
                    <label class="custom-file-label" for="draft_file">Choose file</label>
                    <div class="invalid-feedback">Field is required</div>
                  </div>
                  <small class="form-text text-muted">Hanya menerima file bertype : docx dan doc</small>
                  <?= fileFormError('draft_file', '<p class="text-danger">', '</p>'); ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
            <div class="form-group">
                <label for="draft_file_link">Link File Draft</label>
                <?= form_input('draft_file_link', $input->draft_file_link, 'class="form-control" id="draft_file_link"') ?>
                <?= form_error('draft_file_link') ?>
            </div>
          <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="entry_date">Tanggal Masuk
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('entry_date', $input->entry_date, 'class="form-control" id="flatpickr03"') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('entry_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <hr>
                <h5 class="card-title">Review</h5>
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status Review</label>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_review', 'y',
                        isset($input->is_review) && ($input->is_review == 'y') ? true : false)
                    ?> Reviewed
                    </label>
                  </div>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_review', 'n',
                        isset($input->is_review) && ($input->is_review == 'n') ? true : false)
                    ?> Not Reviewed
                    </label>
                  </div>
                   <?= form_error('is_review') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="review_start_date">Tanggal Mulai Review
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('review_start_date', $input->review_start_date, 'class="form-control" id="flatpickr03"') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('review_start_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="review_end_date">Tanggal Selesai Review
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('review_end_date', $input->review_end_date, 'class="form-control" id="flatpickr03"') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('review_end_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <div class="row">
                  <div class="col-md-6">
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review1_file">File Review 1
                        <abbr title="Required">*</abbr>
                      </label>
                      <div class="custom-file">
                        <?= form_upload('review1_file','','class="custom-file-input"') ?> 
                        <label class="custom-file-label" for="review1_file">Choose file</label>
                        <div class="invalid-feedback">Field is required</div>
                      </div>
                      <small class="form-text text-muted">Hanya menerima file bertype : docx dan doc</small>
                      <?= fileFormError('review1_file', '<p class="text-danger">', '</p>'); ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                      <div class="form-group">
                        <label for="reviewer1_file_link">Link File Review 1</label>
                        <?= form_input('reviewer1_file_link', $input->reviewer1_file_link, 'class="form-control" id="reviewer1_file_link"') ?>
                        <?= form_error('reviewer1_file_link') ?>
                      </div>
                      <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review1_notes">Keterangan Review 1(Reviewer 1)</label>
                        <?= form_textarea('review1_notes', $input->review1_notes, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('review1_notes') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="catatan_review1_admin">Keterangan Review 1(admin)</label>
                        <?= form_textarea('catatan_review1_admin', $input->catatan_review1_admin, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('catatan_review1_admin') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review1_notes_author">Keterangan Review 1 (Penulis)</label>
                        <?= form_textarea('review1_notes_author', $input->review1_notes_author, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('review1_notes_author') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review1_deadline">Review 1 Deadline
                        <abbr title="Required">*</abbr>
                      </label>
                      <div class="has-clearable">
                        <button type="button" class="close" aria-label="Close">
                          <span aria-hidden="true">
                            <i class="fa fa-times-circle"></i>
                          </span>
                        </button>
                        <?= form_input('review1_deadline', $input->review1_deadline, 'class="form-control" id="flatpickr03"') ?>
                        <div class="invalid-feedback"> Field is required </div>
                        <?= form_error('review1_deadline') ?>
                    </div>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-6">
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review2_file">File Review 2
                        <abbr title="Required">*</abbr>
                      </label>
                      <div class="custom-file">
                        <?= form_upload('review2_file','','class="custom-file-input" ') ?> 
                        <label class="custom-file-label" for="review2_file">Choose file</label>
                        <div class="invalid-feedback">Field is required</div>
                      </div>
                      <small class="form-text text-muted">Hanya menerima file bertype : docx dan doc</small>
                      <?= fileFormError('review2_file', '<p class="text-danger">', '</p>'); ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                      <div class="form-group">
                        <label for="reviewer2_file_link">Link File Review 2</label>
                        <?= form_input('reviewer2_file_link', $input->reviewer2_file_link, 'class="form-control" id="reviewer2_file_link"') ?>
                        <?= form_error('reviewer2_file_link') ?>
                      </div>
                      <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review2_notes">Keterangan Review 2 (Reviewer 2)</label>
                        <?= form_textarea('review2_notes', $input->review2_notes, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('review2_notes') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="catatan_review2_admin">Keterangan Review 2 (Admin)</label>
                        <?= form_textarea('catatan_review2_admin', $input->catatan_review2_admin, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('catatan_review2_admin') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review2_notes_author">Keterangan Review 2 (Penulis)</label>
                        <?= form_textarea('review2_notes_author', $input->review2_notes_author, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('review2_notes_author') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="review2_deadline">Review 2 Deadline
                        <abbr title="Required">*</abbr>
                      </label>
                      <div class="has-clearable">
                        <button type="button" class="close" aria-label="Close">
                          <span aria-hidden="true">
                            <i class="fa fa-times-circle"></i>
                          </span>
                        </button>
                        <?= form_input('review2_deadline', $input->review2_deadline, 'class="form-control" id="flatpickr03"') ?>
                        <div class="invalid-feedback"> Field is required </div>
                        <?= form_error('review2_deadline') ?>
                    </div>
                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
                
                <hr>
                <h5 class="card-title">Edit</h5>
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status Edit</label>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_edit', 'y',
                        isset($input->is_edit) && ($input->is_edit == 'y') ? true : false)
                    ?> Edited
                    </label>
                  </div>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_edit', 'n',
                        isset($input->is_edit) && ($input->is_edit == 'n') ? true : false)
                    ?> Not edited
                    </label>
                  </div>
                   <?= form_error('is_edit') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="edit_start_date">Tanggal Mulai edit
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('edit_start_date', $input->edit_start_date, 'class="form-control" id="flatpickr03"') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('edit_start_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="edit_end_date">Tanggal Selesai Edit
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('edit_end_date', $input->edit_end_date, 'class="form-control" id="flatpickr03"') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('edit_end_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="edit_file">File Edit
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="custom-file">
                    <?= form_upload('edit_file','','class="custom-file-input" ') ?> 
                    <label class="custom-file-label" for="edit_file">Choose file</label>
                    <div class="invalid-feedback">Field is required</div>
                  </div>
                  <small class="form-text text-muted">Hanya menerima file bertype : docx dan doc</small>
                  <?= fileFormError('edit_file', '<p class="text-danger">', '</p>'); ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                      <div class="form-group">
                        <label for="editor_file_link">Link File Edit</label>
                        <?= form_input('editor_file_link', $input->editor_file_link, 'class="form-control" id="editor_file_link"') ?>
                        <?= form_error('editor_file_link') ?>
                      </div>
                      <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="edit_notes">Keterangan Edit</label>
                    <?= form_textarea('edit_notes', $input->edit_notes, 'class="form-control summernote-basic"') ?>
                  <div class="invalid-feedback"> Field is required </div>
                  <?= form_error('edit_notes') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="edit_notes_author">Keterangan Edit (Penulis)</label>
                    <?= form_textarea('edit_notes_author', $input->edit_notes_author, 'class="form-control summernote-basic"') ?>
                  <div class="invalid-feedback"> Field is required </div>
                  <?= form_error('edit_notes_author') ?>
                </div>
                <!-- /.form-group -->
                <hr>
                <h5 class="card-title">Layout</h5>
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status Layout</label>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_layout', 'y',
                        isset($input->is_layout) && ($input->is_layout == 'y') ? true : false)
                    ?> Layouted
                    </label>
                  </div>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_layout', 'n',
                        isset($input->is_layout) && ($input->is_layout == 'n') ? true : false)
                    ?> Not layouted
                    </label>
                  </div>
                   <?= form_error('is_layout') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="layout_start_date">Tanggal Mulai layout
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('layout_start_date', $input->layout_start_date, 'class="form-control" id="flatpickr03"') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('layout_start_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="layout_end_date">Tanggal Selesai layout
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('layout_end_date', $input->layout_end_date, 'class="form-control" id="flatpickr03"') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('layout_end_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <div class="row">
                  <div class="col-md-6">
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="layout_file">File Layout
                        <abbr title="Required">*</abbr>
                      </label>
                      <div class="custom-file">
                        <?= form_upload('layout_file','','class="custom-file-input" ') ?> 
                        <label class="custom-file-label" for="layout_file">Choose file</label>
                        <div class="invalid-feedback">Field is required</div>
                      </div>
                      <small class="form-text text-muted">Hanya menerima file bertype : docx dan doc</small>
                      <?= fileFormError('layout_file', '<p class="text-danger">', '</p>'); ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                      <div class="form-group">
                        <label for="layouter_file_link">Link File Layout</label>
                        <?= form_input('layouter_file_link', $input->layouter_file_link, 'class="form-control" id="layouter_file_link"') ?>
                        <?= form_error('layouter_file_link') ?>
                      </div>
                      <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="layout_notes">Keterangan layout</label>
                        <?= form_textarea('layout_notes', $input->layout_notes, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('layout_notes') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="layout_notes_author">Keterangan layout (Penulis)</label>
                        <?= form_textarea('layout_notes_author', $input->layout_notes_author, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('layout_notes_author') ?>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="cover_file">File Cover
                        <abbr title="Required">*</abbr>
                      </label>
                      <div class="custom-file">
                        <?= form_upload('cover_file','','class="custom-file-input" ') ?> 
                        <label class="custom-file-label" for="cover_file">Choose file</label>
                        <div class="invalid-feedback">Field is required</div>
                      </div>
                      <small class="form-text text-muted">Hanya menerima file bertype : png dan jpg</small>
                      <?= fileFormError('cover_file', '<p class="text-danger">', '</p>'); ?>
                    </div>
                    <!-- /.form-group -->
                        <!-- .form-group -->
                      <div class="form-group">
                        <label for="cover_file_link">Link File Cover</label>
                        <?= form_input('cover_file_link', $input->cover_file_link, 'class="form-control" id="cover_file_link"') ?>
                        <?= form_error('cover_file_link') ?>
                      </div>
                      <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cover_notes">Keterangan Cover</label>
                        <?= form_textarea('cover_notes', $input->cover_notes, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('cover_notes') ?>
                    </div>
                    <!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group">
                      <label for="cover_notes_author">Keterangan Cover (Penulis)</label>
                        <?= form_textarea('cover_notes_author', $input->cover_notes_author, 'class="form-control summernote-basic"') ?>
                      <div class="invalid-feedback"> Field is required </div>
                      <?= form_error('cover_notes_author') ?>
                    </div>
                    <!-- /.form-group -->
                  </div>
                </div>
                <hr>
                <h5 class="card-title">Proofread</h5>
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status Proofread</label>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_proofread', 'y',
                        isset($input->is_proofread) && ($input->is_proofread == 'y') ? true : false)
                    ?> Proofread
                    </label>
                  </div>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_proofread', 'n',
                        isset($input->is_proofread) && ($input->is_proofread == 'n') ? true : false)
                    ?> Not proofread
                    </label>
                  </div>
                   <?= form_error('is_proofread') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="proofread_start_date">Tanggal Mulai proofread
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('proofread_start_date', $input->proofread_start_date, 'class="form-control" id="flatpickr03" required=""') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('proofread_start_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="proofread_end_date">Tanggal Selesai proofread
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="has-clearable">
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                    </button>
                    <?= form_input('proofread_end_date', $input->proofread_end_date, 'class="form-control" id="flatpickr03" required=""') ?>
                    <div class="invalid-feedback"> Field is required </div>
                    <?= form_error('proofread_end_date') ?>
                </div>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="proofread_file">File Proofread
                    <abbr title="Required">*</abbr>
                  </label>
                  <div class="custom-file">
                    <?= form_upload('proofread_file','','class="custom-file-input"') ?> 
                    <label class="custom-file-label" for="proofread_file">Choose file</label>
                    <div class="invalid-feedback">Field is required</div>
                  </div>
                  <small class="form-text text-muted">Hanya menerima file bertype : png dan jpg</small>
                  <?= fileFormError('proofread_file', '<p class="text-danger">', '</p>'); ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
          <div class="form-group">
            <label for="proofread_file_link">Link File Proofread</label>
            <?= form_input('proofread_file_link', $input->proofread_file_link, 'class="form-control" id="proofread_file_link"') ?>
            <?= form_error('proofread_file_link') ?>
          </div>
          <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="proofread_notes">Keterangan proofread</label>
                    <?= form_textarea('proofread_notes', $input->proofread_notes, 'class="form-control summernote-basic"') ?>
                  <div class="invalid-feedback"> Field is required </div>
                  <?= form_error('proofread_notes') ?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="proofread_notes_author">Keterangan proofread (Penulis)</label>
                    <?= form_textarea('proofread_notes_author', $input->proofread_notes_author, 'class="form-control summernote-basic"') ?>
                  <div class="invalid-feedback"> Field is required </div>
                  <?= form_error('proofread_notes_author') ?>
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

