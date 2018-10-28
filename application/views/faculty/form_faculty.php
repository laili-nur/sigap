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
        <a href="<?=base_url('faculty')?>">Fakultas</a>
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
      <?= form_open($form_action,'id="formfaculty" novalidate=""') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Fakultas</legend>
          <?= isset($input->faculty_id) ? form_hidden('faculty_id', $input->faculty_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="faculty_name">Fakultas
              <abbr title="Required">*</abbr>
            </label>
            <?= form_input('faculty_name', $input->faculty_name, 'class="form-control" id="faculty_name" autofocus') ?>
            <?= form_error('faculty_name') ?>
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
    $("#formfaculty").validate({
        rules: {
          faculty_name : {
            crequired :true,
            alphanum : true,
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
      select2_validasi()
     );
  })
</script>
