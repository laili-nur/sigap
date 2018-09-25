<!-- .page-title-bar -->
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url('user')?>">User</a>
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
            <legend>Data User</legend>
            <?= isset($input->user_id) ? form_hidden('user_id', $input->user_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="username">Username
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_input('username', $input->username, 'class="form-control" id="username" required ') ?>
              <div class="invalid-feedback">Field is required</div>
              </div>
              <?= form_error('username') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="password">Password
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
             <?= form_password('password','' ,'class="form-control" id="password"') ?>
              </div>
              <?= form_error('password') ?>
            </div>
            <!-- /.form-group -->
            <div class="row" id="hilang">
              <div class="col-md-6">
                <!-- .form-group -->
                  <div class="form-group">
                    <label>Level</label>
                      <div class="custom-control custom-radio">
                        <?= form_radio('level', 'superadmin',
                          isset($input->level) && ($input->level == 'superadmin') ? true : false,'required class="custom-control-input" id="level1"')?>
                        <label class="custom-control-label" for="level1">Superadmin</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <?= form_radio('level', 'admin_penerbitan',
                          isset($input->level) && ($input->level == 'admin_penerbitan') ? true : false, 'class="custom-control-input" id="level2"')?>
                        <label class="custom-control-label" for="level2">Admin Penerbitan</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <?= form_radio('level', 'editor',
                          isset($input->level) && ($input->level == 'editor') ? true : false,' class="custom-control-input" id="level3"')?>
                        <label class="custom-control-label" for="level3">Editor</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <?= form_radio('level', 'layouter',
                          isset($input->level) && ($input->level == 'layouter') ? true : false,' class="custom-control-input" id="level4"')?>
                        <label class="custom-control-label" for="level4">Layouter</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <?= form_radio('level', 'author',
                          isset($input->level) && ($input->level == 'author') ? true : false,' class="custom-control-input" id="level5"')?>
                        <label class="custom-control-label" for="level5">Author</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <?= form_radio('level', 'reviewer',
                          isset($input->level) && ($input->level == 'reviewer') ? true : false,' class="custom-control-input" id="level6"')?>
                        <label class="custom-control-label" for="level6">Reviewer</label>
                      </div>
                      <div class="invalid-feedback">Field is required</div>
                     <?= form_error('level') ?>
                  </div>
                  <!-- /.form-group -->
              </div>
              <div class="col-md-6">
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status</label>
                  <div class="custom-control custom-radio">
                    <?= form_radio('is_blocked', 'y',
                      isset($input->is_blocked) && ($input->is_blocked == 'y') ? true : false,'required class="custom-control-input" id="blocked1"')?>
                    <label class="custom-control-label" for="blocked1">Blocked</label>
                  </div>
                  <div class="custom-control custom-radio">
                    <?= form_radio('is_blocked', 'n',
                      isset($input->is_blocked) && ($input->is_blocked == 'n') ? true : false,' class="custom-control-input" id="blocked2"')?>
                    <label class="custom-control-label" for="blocked2">Not Blocked</label>
                  </div>
                   <?= form_error('is_blocked') ?>
                </div>
                <!-- /.form-group -->
              </div>
            </div>
            
            
          
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

<?php if ($input->username == 'superadmin'): ?>
  <script>
    $('#hilang').hide();
  </script>
<?php endif ?>


