<!-- .page-title-bar -->

  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted">Form Ganti Password</a>
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
        <?=form_open($form_action, 'id="formchangepassword" novalidate=""');?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Ganti Password</legend>
            <?=isset($input->user_id) ? form_hidden('user_id', $input->user_id) : '';?>
            <!-- .form-group -->
            <div class="form-group">
              <label for="username">Username
                <abbr title="Required">*</abbr>
              </label>
              <?=form_input('username', $input->username, 'class="form-control" id="username" disabled');?>
              <?=form_error('username');?>
            </div>
            <!-- /.form-group -->
            <?=form_hidden('username', $input->username);?>

            <!-- .form-group -->
            <div class="form-group">
              <label for="password">Password Lama
                <abbr title="Required">*</abbr>
              </label>
             <?=form_password('password', '', 'class="form-control" id="password"');?>
              <?=form_error('password');?>
            </div>
            <!-- /.form-group -->

            <!-- .form-group -->
            <div class="form-group">
              <label for="newpassword">Password Baru
                <abbr title="Required">*</abbr>
              </label>
             <?=form_password('newpassword', '', 'class="form-control" id="newpassword"');?>
              <?=form_error('newpassword');?>
            </div>
            <!-- /.form-group -->

            <!-- .form-group -->
            <div class="form-group">
              <label for="confirmpassword">Konfirmasi Password
                <abbr title="Required">*</abbr>
              </label>
             <?=form_password('confirmpassword', '', 'class="form-control" id="confirmpassword"');?>
              <?=form_error('confirmpassword');?>
            </div>
            <!-- /.form-group -->
            <?=isset($input->level) ? form_hidden('level', $input->level) : '';?>
            <?=isset($input->is_blocked) ? form_hidden('is_blocked', $input->is_blocked) : '';?>
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

<script>
  $(document).ready(function(){
    validate_setting();
    $("#formchangepassword").validate({
        rules: {
          username : {
            crequired :true,
            username : true,
          },
          password: {
            crequired : true,
            cminlength : 4
          },
          newpassword: {
            crequired : true,
            cminlength : 4,
            notEqualTo: '#password'
          },
          confirmpassword: {
            crequired : true,
            minlength : 4,
            equalTo : '#newpassword'
          },
          level : "crequired"
        },
        messages : {
          newpassword: {
            notEqualTo: 'Password baru tidak boleh sama dengan password lama'
          },
          confirmpassword: {
            equalTo : "Kolom konfirmasi harus sama dengan kolom password baru"
          }
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
     validate_select2()
     );
  })
</script>


