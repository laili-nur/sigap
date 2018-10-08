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
          <a href="<?=base_url('reviewer')?>">Reviewer</a>
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
  <div class="col-md-6">
    <!-- .card -->
  <section id="data-author" class="card">
    <!-- .card-body -->
    <div class="card-body">
      <!-- .form -->
      <?= form_open($form_action,'class="needs-validation" novalidate=""') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Reviewer</legend>
          <?= isset($input->reviewer_id) ? form_hidden('reviewer_id', $input->reviewer_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="user_id">User ID
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('user_id', getDropdownList('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block" required') ?>
            <div class="invalid-feedback">Field is required</div>
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
            <?= form_input('reviewer_nip', $input->reviewer_nip, 'class="form-control" id="reviewer_nip" required') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
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
            <?= form_input('reviewer_name', $input->reviewer_name, 'class="form-control" id="reviewer_name" required') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('reviewer_name') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="user_id">Fakultas
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('faculty_id', getDropdownList('faculty', ['faculty_id', 'faculty_name']), $input->faculty_id, 'id="faculty_id" class="form-control custom-select d-block" required') ?>
            <div class="invalid-feedback">Field is required</div>
            <?= form_error('faculty_id') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="expert">Kepakaran</label>
              <?= form_dropdown('expert[]',$input->sumber,$input->pilih, 'id="expert" class="form-control custom-select d-block" multiple="multiple" required') ?> 
              <small class="form-text text-muted">Pilih kepakaran yang telah ada, atau tambahkan kepakaran baru</small>
            <div class="invalid-feedback"> Field is required </div>
            <?= form_error('expert') ?>
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
</div>
<!-- /.page-section -->

<script>
    $(document).ready(function(){
      $("#user_id").select2({
      placeholder: '-- Choose --',
      allowClear: true
      });
      $("#faculty_id").select2({
        placeholder: '-- Choose --',
        allowClear: true
      });
      $('#expert option[value=""]').detach();
      $("#expert").select2({
        tags:true,
        placeholder: '-- Multiple --',
        tokenSeparators: [',', ' ']
      });

    })
  </script>
