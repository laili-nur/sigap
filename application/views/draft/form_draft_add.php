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
          <legend>Data Draft</legend>
          <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="category_id">Jenis Kategori ID
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('category_id', getDropdownList('category', ['category_id', 'category_name']), $input->category_id, 'id="category_id" class="form-control custom-select d-block"') ?>
            <div class="invalid-feedback">erot</div>
            <?= form_error('category_id') ?>
          </div>
          <!-- /.form-group -->
          <hr class="my-2">
          <!-- .form-group -->
          <div class="form-group">
            <label for="theme_id">Pilih Tema
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('theme_id', getDropdownList('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme_id" class="form-control custom-select d-block"') ?>
            <div class="invalid-feedback">erot</div>
            <?= form_error('theme_id') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="draft_title">Judul Draft
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
            <label for="draft_title">Form Upload
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
  <!-- .card -->
  <section id="data-author" class="card">
    <!-- .card-body -->
    <div class="card-body">
      <a href="<?=base_url('draftauthor/add') ?>" class="btn btn-success">Tambah Penulis</a>
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->  
  </div>
</div>
</div>
<!-- /.page-section -->


