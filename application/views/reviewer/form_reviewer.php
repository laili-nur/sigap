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
  <div class="row">
  <div class="col-md-6">
    <!-- .card -->
  <section id="data-author" class="card">
    <!-- .card-body -->
    <div class="card-body">
      <!-- .form -->
      <?= form_open($form_action,' novalidate="" id="formreviewer"') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Reviewer</legend>
          <?= isset($input->reviewer_id) ? form_hidden('reviewer_id', $input->reviewer_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="user_id">Pilih User ID untuk Login
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('user_id', getDropdownListReviewer('user', ['user_id', 'username']), $input->user_id, 'id="user_id" class="form-control custom-select d-block"') ?>
            <small class="form-text text-muted">Reviewer wajib memiliki akun. Jika belum ada, daftarkan akun di <a href="<?=base_url('user/add') ?>"><strong>sini</strong></a></small>
            <?= form_error('user_id') ?>
          </div>
          <!-- /.form-group -->
          <hr class="my-2">
          <!-- .form-group -->
          <div class="form-group">
            <label for="reviewer_nip">NIP
              <abbr title="Required">*</abbr>
            </label>
            <?= form_input('reviewer_nip', $input->reviewer_nip, 'class="form-control" id="reviewer_nip"') ?>
            <?= form_error('reviewer_nip') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="reviewer_name">Nama
              <abbr title="Required">*</abbr>
            </label>
            <?= form_input('reviewer_name', $input->reviewer_name, 'class="form-control" id="reviewer_name"') ?>
            <?= form_error('reviewer_name') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="user_id">Fakultas
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('faculty_id', getDropdownList('faculty', ['faculty_id', 'faculty_name']), $input->faculty_id, 'id="faculty_id" class="form-control custom-select d-block"') ?>
            <?= form_error('faculty_id') ?>
          </div>
          <!-- /.form-group -->
          <div class="row">
            <div class="col-md-6">
              <!-- .form-group -->
              <div class="form-group">
                <label for="author_degree_front">Gelar Depan Nama</label>
                <?= form_input('reviewer_degree_front', $input->reviewer_degree_front,'class="form-control" id="reviewer_degree_front" placeholder="contoh = Ir."') ?>
                <?= form_error('reviewer_degree_front') ?>
              </div>
              <!-- /.form-group -->
            </div>
            <div class="col-md-6">
              <!-- .form-group -->
              <div class="form-group">
                <label for="reviewer_degree_back">Gelar Belakang Nama</label>
                <div class="has-clearable">
                  <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">
                      <i class="fa fa-times-circle"></i>
                    </span>
                  </button>
                <?= form_input('reviewer_degree_back', $input->reviewer_degree_back,'class="form-control" id="reviewer_degree_back" placeholder="contoh = S.T"') ?>
                </div>
                <?= form_error('reviewer_degree_back') ?>
              </div>
              <!-- /.form-group -->
            </div>
          </div>
          <!-- .form-group -->
          <div class="form-group">
            <label for="reviewer_expert">Kepakaran
              <abbr title="Required">*</abbr>
            </label>
              <?= form_dropdown('reviewer_expert[]',$input->sumber,$input->pilih, 'id="reviewer_expert" class="form-control custom-select d-block" multiple="multiple"') ?> 
              <small class="form-text text-muted">Pilih kepakaran yang telah ada, atau tambahkan kepakaran baru (Ketik lalu tekan enter)</small>
            <?= form_error('reviewer_expert') ?>
          </div>
          <!-- /.form-group -->
        <hr class="my-2">
            <!-- .form-group -->
            <div class="form-group">
              <label for="reviewer_contact">No HP</label>
              <?= form_input('reviewer_contact', $input->reviewer_contact,'class="form-control" id="reviewer_contact"') ?>
              <?= form_error('reviewer_contact') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="reviewer_email">Email</label>
              <?= form_input('reviewer_email', $input->reviewer_email,'class="form-control" id="reviewer_email"') ?>
              <?= form_error('reviewer_email') ?>
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

<script>
    $(document).ready(function(){
      setting_validasi();
    $("#formreviewer").validate({
        rules: {
          user_id : "crequired",
          reviewer_nip : {
            crequired :true,
            cminlength : 3,
            cnumber : true
          },
          reviewer_name : {
            crequired :true,
            huruf :true
          },
          faculty_id : "crequired",
          "reviewer_expert[]" : "crequired",
          reviewer_contact : {
            cnumber :true
          },
          reviewer_email : {
            cemail :true
          },
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

      $("#user_id").select2({
      placeholder: '-- Choose --',
      allowClear: true
      });
      $("#faculty_id").select2({
        placeholder: '-- Choose --',
        allowClear: true
      });
      $('#reviewer_expert option[value=""]').detach();
      $("#reviewer_expert").select2({
        tags:true,
        placeholder: '-- Multiple --',
        tokenSeparators: [',']
      });

    })
  </script>
