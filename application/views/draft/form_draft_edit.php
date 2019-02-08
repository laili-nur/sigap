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
                <?= form_input('entry_date', $input->entry_date, 'class="form-control tanggal_edit" ') ?>
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
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('review_start_date', $input->review_start_date, 'class="form-control tanggal_edit"') ?>
                <?= form_error('review_start_date') ?>
              </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="review_end_date">Tanggal Selesai Review
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('review_end_date', $input->review_end_date, 'class="form-control tanggal_edit" ') ?>
                <?= form_error('review_end_date') ?>
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
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('edit_start_date', $input->edit_start_date, 'class="form-control tanggal_edit" ') ?>
                <?= form_error('edit_start_date') ?>
              </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="edit_end_date">Tanggal Selesai Edit
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('edit_end_date', $input->edit_end_date, 'class="form-control tanggal_edit" ') ?>
                <?= form_error('edit_end_date') ?>
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
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('layout_start_date', $input->layout_start_date, 'class="form-control tanggal_edit" ') ?>
                <?= form_error('layout_start_date') ?>
              </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="layout_end_date">Tanggal Selesai layout
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('layout_end_date', $input->layout_end_date, 'class="form-control tanggal_edit" ') ?>
                <?= form_error('layout_end_date') ?>
              </div>
            </div>
            <!-- /.form-group -->
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
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('proofread_start_date', $input->proofread_start_date, 'class="form-control tanggal_edit"  ') ?>
                <?= form_error('proofread_start_date') ?>
              </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="proofread_end_date">Tanggal Selesai proofread
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('proofread_end_date', $input->proofread_end_date, 'class="form-control tanggal_edit"  ') ?>
                <?= form_error('proofread_end_date') ?>
              </div>
            </div>
            <!-- /.form-group -->
            <hr>
            <h5 class="card-title">Cetak</h5>
            <!-- .form-group -->
            <div class="form-group">
              <label>Status Cetak</label>
              <div class="mb-1">
                <label>
                  <?= form_radio('is_print', 'y',
                        isset($input->is_print) && ($input->is_print == 'y') ? true : false)
                    ?> Print
                </label>
              </div>
              <div class="mb-1">
                <label>
                  <?= form_radio('is_print', 'n',
                        isset($input->is_print) && ($input->is_print == 'n') ? true : false)
                    ?> Not printed
                </label>
              </div>
              <?= form_error('is_print') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="print_start_date">Tanggal Mulai Cetak
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('print_start_date', $input->print_start_date, 'class="form-control tanggal_edit" ') ?>
                <?= form_error('print_start_date') ?>
              </div>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="print_end_date">Tanggal Selesai Cetak
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                        <i class="fa fa-times-circle"></i>
                      </span>
                </button>
                <?= form_input('print_end_date', $input->print_end_date, 'class="form-control tanggal_edit"') ?>
                <?= form_error('print_end_date') ?>
              </div>
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

<script>
  $(document).ready(function() {
    $('.tanggal_edit').flatpickr({
      disableMobile: true,
      altInput: true,
      altFormat: 'j F Y',
      dateFormat: 'Y-m-d',
    });
  });
</script>