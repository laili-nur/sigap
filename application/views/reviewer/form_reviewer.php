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
    <h1 class="page-title"> Form Reviewer </h1>
  </header>
  <!-- /.page-title-bar -->
  <!-- .page-section -->
  <div class="page-section">
    <!-- .card -->
    <section id="data-author" class="card">
      <!-- .card-body -->
      <div class="card-body">
        <!-- .form -->
        <?= form_open($form_action,'class="needs-validation" novalidate=""') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Penulis</legend>
            <?= isset($input->reviewer_id) ? form_hidden('reviewer_id', $input->reviewer_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="user_id">User ID
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('user_id', getDropdownList('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('user_id') ?>
            </div>
            <!-- /.form-group -->
            <hr class="my-2">
            <!-- .form-group -->
            <div class="form-group">
              <label for="reviewer_nip">NIP
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('reviewer_nip', $input->reviewer_nip, 'class="form-control" id="reviewer_nip"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('reviewer_nip') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="reviewer_name">Nama
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('reviewer_name', $input->reviewer_name, 'class="form-control" id="reviewer_name"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
              <?= form_error('reviewer_name') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="user_id">User ID
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('faculty_id', getDropdownList('faculty', ['faculty_id', 'faculty_name']), $input->faculty_id, 'id="faculty_id" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">erot</div>
              <?= form_error('user_id') ?>
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
  </div>
  <!-- /.page-section -->
</div>
