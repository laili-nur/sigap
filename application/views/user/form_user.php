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
        <?= form_open($form_action,'id="formuser" novalidate=""') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data User</legend>
            <?= isset($input->user_id) ? form_hidden('user_id', $input->user_id) : '' ?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="username">Username
                <abbr title="Required">*</abbr>
              </label>
              <?= form_input('username', $input->username, 'class="form-control" id="username"') ?>
              <?= form_error('username') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="password">Password
                <abbr title="Required">*</abbr>
              </label>
             <?= form_password('password','' ,'class="form-control" id="password"') ?>
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
                          isset($input->level) && ($input->level == 'superadmin') ? true : false,' class="custom-control-input" id="level1"')?>
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
                      <div class="custom-control custom-radio">
                        <?= form_radio('level', 'author_reviewer',
                          isset($input->level) && ($input->level == 'author_reviewer') ? true : false,' class="custom-control-input" id="level7"')?>
                        <label class="custom-control-label" for="level7">Author dan Reviewer</label>
                      </div>
                     <?= form_error('level') ?>
                  </div>
                  <!-- /.form-group -->
              </div>
              <div class="col-md-6">
                <!-- .form-group -->
                <div class="form-group">
                  <label>Status</label>
                  <div>
                    <!-- button radio -->
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary <?=($input->is_blocked == 'y') ? 'active' : '' ?>">
                      <?= form_radio('is_blocked', 'y',
                      isset($input->is_blocked) && ($input->is_blocked == 'y') ? true : false,' class="custom-control-input" id="blocked1"')?> Blocked</label>
                    <label class="btn btn-secondary <?=($input->is_blocked == 'n') ? 'active' : '' ?>">
                      <?= form_radio('is_blocked', 'n',
                      isset($input->is_blocked) && ($input->is_blocked == 'n') ? true : false,' class="custom-control-input" id="blocked2"')?> Not Blocked</label>
                  </div>
                  <!-- /button radio -->
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
<script>
  $(document).ready(function(){
    setting_validasi();
    $("#formuser").validate({
        rules: {
          username : {
            crequired :true,
            username : true,
          },
          password: {
            crequired : true,
            cminlength : 5
          },
          level : "crequired"
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
           error.addClass( "invalid-feedback" );
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.next('span.select2'));      // input group
            } else if (element.hasClass("select2-hidden-accessible")){
                error.insertAfter(element.next('span.select2'));  // select2
            } else if (element.hasClass("custom-file-input")){
                error.insertAfter(element.next('label.custom-file-label'));  // fileinput custom
            } else if (element.hasClass("custom-control-input")){
                error.insertAfter($(".custom-radio").last());  // radio
            }else {                                      
                error.insertAfter(element);               // default
            }
        }
      },
      select2_validasi()
     );
  })
</script>


