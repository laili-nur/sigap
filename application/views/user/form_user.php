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
        <?= form_open($form_action,'class="needs-validation" novalidate=""') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Penulis</legend>
            <?= isset($input->reviewer_id) ? form_hidden('reviewer_id', $input->reviewer_id) : '' ?>
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
              <?= form_input('username', $input->username, 'class="form-control" id="username"') ?>
              </div>
              <div class="invalid-feedback">erot</div>
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
              <div class="invalid-feedback">erot</div>
              <?= form_error('password') ?>
            </div>
            <!-- /.form-group -->
            <div class="row">
              <div class="col-md-6">
                <!-- .form-group -->
                  <div class="form-group">
                    <label>Level</label>
                    <div class="mb-1">
                      <label>
                      <?= form_radio('level', 'superadmin',
                          isset($input->level) && ($input->level == 'superadmin') ? true : false)
                      ?> Superadmin
                      </label>
                    </div>
                    <div class="mb-1">
                      <label>
                      <?= form_radio('level', 'admin_penerbitan',
                          isset($input->level) && ($input->level == 'admin_penerbitan') ? true : false)
                      ?> Admin Penerbitan
                      </label>
                    </div>
                    <div class="mb-1">
                      <label>
                      <?= form_radio('level', 'staff_penerbitan',
                          isset($input->level) && ($input->level == 'staff_penerbitan') ? true : false)
                      ?> Staff Penerbitan
                      </label>
                    </div>
                     <?= form_error('level') ?>
                  </div>
                  <!-- /.form-group -->
              </div>
              <div class="col-md-6">
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status</label>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_blocked', 'y',
                        isset($input->is_blocked) && ($input->is_blocked == 'y') ? true : false)
                    ?> Blocked
                    </label>
                  </div>
                  <div class="mb-1">
                    <label>
                    <?= form_radio('is_blocked', 'n',
                        isset($input->is_blocked) && ($input->is_blocked == 'n') ? true : false)
                    ?> Not Blocked
                    </label>
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


