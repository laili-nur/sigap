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
        <a href="<?=base_url('workunit')?>">Unit Kerja</a>
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
    <div class="col-md-6">
      <!-- .card -->
  <section id="data-author" class="card">
    <!-- .card-body -->
    <div class="card-body">
      <!-- .form -->
      <?= form_open($form_action,'class="needs-validation" novalidate=""') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Unit Kerja</legend>
          <?= isset($input->work_unit_id) ? form_hidden('work_unit_id', $input->work_unit_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="work_unit_name">Unit Kerja
              <abbr title="Required">*</abbr>
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('work_unit_name', $input->work_unit_name, 'class="form-control" id="work_unit_name" autofocus') ?>
            </div>
            <div class="invalid-feedback">erot</div>
            <?= form_error('work_unit_name') ?>
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
</div>
<!-- /.page-section -->